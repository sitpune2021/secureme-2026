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

    // EMERGENCY ALERT REPORT
    public function EmergencyAlertsReport(Request $request)
    {
        $search = $request->search;

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

        // TOTAL COUNTS

        $totalAlerts = DB::table('emergency_signals')->count();

        $activeAlerts = DB::table('emergency_signals')
            ->where('signal_status', 'Active')
            ->count();

        $resolvedAlerts = DB::table('emergency_signals')
            ->where('signal_status', 'Resolved')
            ->count();

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

            return view(
                'admin.emergency_responses_report',
                [
                    'responses' => collect(),
                    'totalResponses' => 0,
                    'acceptedResponses' => 0,
                    'pendingResponses' => 0
                ]
            );
        }

        $responses = DB::table('emergency_responses')

            ->join(
                'users',
                'emergency_responses.user_id',
                '=',
                'users.id'
            )

            ->join(
                'emergency_signals',
                'emergency_responses.signal_id',
                '=',
                'emergency_signals.id'
            )

            ->select(
                'emergency_responses.*',
                'users.name',
                'users.phone_no',
                'users.user_role',
                'emergency_signals.signal_id as emergency_signal_code'
            )

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'users.name',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'users.user_role',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'emergency_signals.signal_id',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'emergency_responses.status',
                        'LIKE',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'emergency_responses.response_action',
                        'LIKE',
                        "%{$search}%"
                    );
                });
            })

            ->latest('emergency_responses.id')

            ->paginate(10)

            ->withQueryString();

        // TOTALS

        $totalResponses = DB::table('emergency_responses')->count();

        $acceptedResponses = DB::table('emergency_responses')
            ->where('response_action', 'accepted')
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