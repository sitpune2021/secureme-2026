<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstantEmergencyGroupController extends Controller
{


    public function InstantEmergencyGroups(Request $request)
    {
        $search = $request->search;

        $groups = DB::table('emergency_groups')
            ->join(
                'emergency_signals',
                'emergency_groups.signal_id',
                '=',
                'emergency_signals.id'
            )

            ->join(
                'users',
                'emergency_signals.user_id',
                '=',
                'users.id'
            )

            ->select(
                'emergency_groups.*',
                'emergency_signals.signal_id as emergency_signal_id',
                'emergency_signals.signal_status',
                'users.name as emergency_user_name'
            )

            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('emergency_groups.group_name', 'LIKE', "%{$search}%")

                        ->orWhere('emergency_signals.signal_id', 'LIKE', "%{$search}%")

                        ->orWhere('users.name', 'LIKE', "%{$search}%")

                        ->orWhere('emergency_signals.signal_status', 'LIKE', "%{$search}%");
                });
            })

            ->orderBy('emergency_groups.id', 'desc')

            ->paginate(10)

            ->withQueryString();

        // MEMBERS

        foreach ($groups as $group) {

            $group->members = DB::table('emergency_group_members')

                ->join(
                    'users',
                    'emergency_group_members.user_id',
                    '=',
                    'users.id'
                )

                ->where(
                    'emergency_group_members.group_id',
                    $group->id
                )

                ->select(
                    'users.name',
                    'users.phone_no',
                    'users.user_role',
                    'emergency_group_members.status'
                )

                ->get();
        }

        return view(
            'admin.instant_emergency_groups_list',
            compact('groups')
        );
    }


}