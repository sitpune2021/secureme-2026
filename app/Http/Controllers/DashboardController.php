<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


    // SHOW ADMIN DASHBOARD
    public function AdminDashboard()
    {
        try {

            // EMERGENCY STATS

            $stats = DB::table('emergency_signals')
                ->selectRaw('
                    COUNT(*) as total_signals,

                    SUM(
                        CASE
                            WHEN signal_status = "Active"
                            THEN 1
                            ELSE 0
                        END
                    ) as active_emergency_signals,

                    SUM(
                        CASE
                            WHEN signal_status = "Resolved"
                            THEN 1
                            ELSE 0
                        END
                    ) as resolved_emergency_signals
                ')
                ->first();

            // TOTAL USERS
            // ONLY NORMAL USERS

            $users = DB::table('users')

                ->where('user_role', 'user')

                ->count();

            // TOTAL HELPERS
            // EXCEPT admin & user

            $total_helpers = DB::table('users')

                ->whereNotIn('user_role', [
                    'admin',
                    'user'
                ])

                ->count();

            // TOTAL POLICE

            $TotalPolices = DB::table('users')

                ->where('user_role', 'Police')

                ->count();

            // HELPERS LIST

            $helpers = DB::table('users')

                ->whereNotIn('user_role', [
                    'admin',
                    'user'
                ])

                ->latest()

                ->get();

            return view('admin.admin_dashboard', [

                'users' => $users,

                'total_helpers' => $total_helpers,

                'TotalPolices' => $TotalPolices,

                'helpers' => $helpers,

                'active_emergency_signals' => $stats->active_emergency_signals,

                'resolved_emergency_signals' => $stats->resolved_emergency_signals,

            ]);

        } catch (\Throwable $th) {

            dd($th);

        }
    }
    

}