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
                    $q->where(
                        'emergency_groups.group_name',
                        'LIKE',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'emergency_signals.signal_id',
                        'LIKE',
                        "%{$search}%"
                    )
                    ->orWhere(
                        'users.name',
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
            ->orderBy('emergency_groups.id', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Get the latest response for each responder and signal.
        $latestResponses = DB::table('emergency_responses')
            ->selectRaw('MAX(id) as latest_response_id, signal_id, user_id')
            ->groupBy('signal_id', 'user_id');

        // Load members with membership status and actual help progress.
        foreach ($groups as $group) {
            $group->members = DB::table('emergency_group_members as egm')
                ->join('users as u', 'egm.user_id', '=', 'u.id')

                ->leftJoinSub(
                    $latestResponses,
                    'latest_er',
                    function ($join) use ($group) {
                        $join->on(
                            'latest_er.user_id',
                            '=',
                            'egm.user_id'
                        )
                        ->where(
                            'latest_er.signal_id',
                            '=',
                            $group->signal_id
                        );
                    }
                )

                ->leftJoin(
                    'emergency_responses as er',
                    'er.id',
                    '=',
                    'latest_er.latest_response_id'
                )

                ->where('egm.group_id', $group->id)

                ->select(
                    'egm.user_id',
                    'egm.role as member_role',
                    'egm.status as membership_status',
                    'u.name',
                    'u.phone_no',
                    'u.user_role',
                    'er.response_action',
                    'er.status as response_status',
                    'er.response_notes',
                    'er.updated_at as response_updated_at'
                )
                ->get();
        }

        return view(
            'admin.instant_emergency_groups_list',
            compact('groups')
        );
    }


}