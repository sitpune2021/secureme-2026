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

    
}