<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReportController extends Controller
{


    public function ReportsAndLogsList()
    {

        // TOTAL USERS
        $totalUsers = DB::table('users')->count();

        /*
        |--------------------------------------------------------------------------
        | FAMILY MEMBERS COUNT
        |--------------------------------------------------------------------------
        | Agar table exist nahi hai to 0 return karo
        |
        */

        $totalFamilies = 0;

        if (Schema::hasTable('family_members')) {

            $totalFamilies = DB::table('family_members')->count();

        }

        /*
        |--------------------------------------------------------------------------
        | EMERGENCY SIGNALS
        |--------------------------------------------------------------------------
        */

        $totalSignals = 0;

        if (Schema::hasTable('emergency_signals')) {

            $totalSignals = DB::table('emergency_signals')->count();

        }

        /*
        |--------------------------------------------------------------------------
        | ACTIVE SIGNALS
        |--------------------------------------------------------------------------
        */

        $activeSignals = 0;

        if (Schema::hasTable('emergency_signals')) {

            $activeSignals = DB::table('emergency_signals')
                ->where('signal_status', 'Active')
                ->count();

        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSES
        |--------------------------------------------------------------------------
        */

        $totalResponses = 0;

        if (Schema::hasTable('emergency_responses')) {

            $totalResponses = DB::table('emergency_responses')->count();

        }

        /*
        |--------------------------------------------------------------------------
        | GROUPS
        |--------------------------------------------------------------------------
        */

        $totalGroups = 0;

        if (Schema::hasTable('emergency_groups')) {

            $totalGroups = DB::table('emergency_groups')->count();

        }

        /*
        |--------------------------------------------------------------------------
        | ACTIVE GROUPS
        |--------------------------------------------------------------------------
        */

        $activeGroups = 0;

        if (Schema::hasTable('emergency_signals')) {

            $activeGroups = DB::table('emergency_signals')
                ->where('signal_status', 'Active')
                ->count();

        }

        /*
        |--------------------------------------------------------------------------
        | RECENT SIGNALS
        |--------------------------------------------------------------------------
        */

        $recentSignals = collect();

        if (
            Schema::hasTable('emergency_signals') &&
            Schema::hasTable('users')
        ) {

            $recentSignals = DB::table('emergency_signals')

                ->join(
                    'users',
                    'emergency_signals.user_id',
                    '=',
                    'users.id'
                )

                ->select(
                    'users.name',
                    'emergency_signals.signal_id',
                    'emergency_signals.signal_status',
                    'emergency_signals.created_at'
                )

                ->latest('emergency_signals.id')

                ->take(5)

                ->get();
        }

        return view(
            'admin.reports_and_logs_list',
            compact(
                'totalUsers',
                'totalFamilies',
                'totalSignals',
                'activeSignals',
                'totalResponses',
                'totalGroups',
                'activeGroups',
                'recentSignals'
            )
        );
    }

    // ==========================================
    // EMERGENCY ALERT REPORT
    // ==========================================

    public function EmergencyAlertsReport(Request $request)
    {
        $search = $request->search;

        // ==========================================
        // FETCH EMERGENCY ALERTS
        // ==========================================
        $alerts = DB::table('emergency_signals')
            ->join(
                'users',
                'emergency_signals.user_id',
                '=',
                'users.id'
            )
            ->select(
                'emergency_signals.*',
                'users.name',
                'users.phone_no'
            )
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('users.name', 'LIKE', "%{$search}%")
                        ->orWhere(
                            'emergency_signals.signal_id',
                            'LIKE',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'emergency_signals.signal_status',
                            'LIKE',
                            "%{$search}%"
                        );
                });
            })
            ->orderBy('emergency_signals.id', 'desc')
            ->paginate(10)
            ->withQueryString();

        // ==========================================
        // FETCH RESPONDERS FOR CURRENT PAGE ALERTS
        // emergency_responses.signal_id stores
        // emergency_signals.id (numeric ID)
        // ==========================================
        $signalRecordIds = $alerts->getCollection()
            ->pluck('id')
            ->toArray();

        $responses = DB::table('emergency_responses as er')
            ->leftJoin('users as responder', 'responder.id', '=', 'er.user_id')
            ->whereIn('er.signal_id', $signalRecordIds)
            ->select(
                'er.id as response_id',
                'er.signal_id',
                'er.user_id as responder_id',
                'er.responder_type',
                'er.response_action',
                'er.response_notes',
                'er.status as response_status',
                'er.updated_at as response_updated_at',
                'responder.name as responder_name',
                'responder.phone_no as responder_phone',
                'responder.user_role as responder_role'
            )
            ->orderBy('er.updated_at', 'desc')
            ->get()
            ->groupBy('signal_id');

        // Attach responders to each alert
        $alerts->getCollection()->transform(function ($alert) use ($responses) {
            $alert->responders = $responses->get($alert->id, collect());

            return $alert;
        });

        // ==========================================
        // TOTAL COUNTS
        // ==========================================
        $totalAlerts = DB::table('emergency_signals')->count();

        $activeAlerts = DB::table('emergency_signals')
            ->where('signal_status', 'Active')
            ->count();

        $resolvedAlerts = DB::table('emergency_signals')
            ->where('signal_status', 'Resolved')
            ->count();

        // ==========================================
        // RETURN REPORT VIEW
        // ==========================================
        return view(
            'admin.emergency_alerts_report',
            compact(
                'alerts',
                'totalAlerts',
                'activeAlerts',
                'resolvedAlerts'
            )
        );
    }

    public function EmergencyResponsesReport(Request $request)
    {
    $search = $request->search;

    // CHECK TABLE EXISTS
    if (!\Schema::hasTable('emergency_responses')) {
        return view('admin.emergency_responses_report', [
            'responses' => collect(),
            'totalResponses' => 0,
            'acceptedResponses' => 0,
            'pendingResponses' => 0
        ]);
    }

    // FETCH RESPONSES WITH RESPONDER AND SOS USER DETAILS
    $responses = DB::table('emergency_responses as er')

        // Responder details
        ->join('users as responder', 'er.user_id', '=', 'responder.id')

        // SOS signal details
        ->join('emergency_signals as es', 'er.signal_id', '=', 'es.id')

        // Person who triggered the SOS
        ->join('users as sos_user', 'es.user_id', '=', 'sos_user.id')

        ->select(
            'er.*',

            // Responder details
            'responder.name as name',
            'responder.phone_no as phone_no',
            'responder.user_role as user_role',

            // Public SOS signal ID
            'es.signal_id as emergency_signal_code',
            'es.signal_status as sos_status',

            // SOS user details
            'sos_user.id as sos_user_id',
            'sos_user.name as sos_user_name',
            'sos_user.phone_no as sos_user_phone',
            'sos_user.user_role as sos_user_role'
        )

        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('responder.name', 'LIKE', "%{$search}%")
                    ->orWhere('responder.user_role', 'LIKE', "%{$search}%")
                    ->orWhere('responder.phone_no', 'LIKE', "%{$search}%")
                    ->orWhere('es.signal_id', 'LIKE', "%{$search}%")
                    ->orWhere('es.signal_status', 'LIKE', "%{$search}%")
                    ->orWhere('sos_user.name', 'LIKE', "%{$search}%")
                    ->orWhere('sos_user.phone_no', 'LIKE', "%{$search}%")
                    ->orWhere('er.status', 'LIKE', "%{$search}%")
                    ->orWhere('er.response_action', 'LIKE', "%{$search}%");
            });
        })

        ->orderByDesc('er.id')
        ->paginate(10)
        ->withQueryString();

    // TOTAL COUNTS
    $totalResponses = DB::table('emergency_responses')->count();

    $acceptedResponses = DB::table('emergency_responses')
        ->whereIn('response_action', ['accept', 'accepted'])
        ->count();

    $pendingResponses = DB::table('emergency_responses')
        ->where('status', 'pending')
        ->count();

    return view(
        'admin.emergency_responses_report',
        compact(
            'responses',
            'totalResponses',
            'acceptedResponses',
            'pendingResponses'
        )
    );
    }

    
}