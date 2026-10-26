<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmergencyResponsesController extends Controller
{


    /**
     * Fetch all emergency responses with counts of accepted/rejected
     */
   
    public function AllEmergencyResponsesList()
    {
        // Emergency response + responder + SOS user details
        $responses = DB::table('emergency_responses as er')
            ->join('emergency_signals as es', 'er.signal_id', '=', 'es.id')

            // Responder / helper details
            ->leftJoin('users as responder', 'er.user_id', '=', 'responder.id')

            // The user who triggered SOS
            ->leftJoin('users as sos_user', 'es.user_id', '=', 'sos_user.id')

            ->select(
                'er.id',
                'er.signal_id',
                'er.responder_type',
                'er.response_action',
                'er.response_notes',
                'er.status as response_status',
                'er.created_at as response_created_at',
                'er.updated_at as response_updated_at',

                'responder.id as responder_id',
                'responder.name as responder_name',
                'responder.email as responder_email',
                'responder.phone_no as responder_phone',
                'responder.user_role as responder_role',

                'es.signal_id as public_signal_id',
                'es.signal_status',
                'es.latitude',
                'es.longitude',

                'sos_user.id as sos_user_id',
                'sos_user.name as sos_user_name',
                'sos_user.email as sos_user_email',
                'sos_user.phone_no as sos_user_phone'
            )
            ->orderByDesc('er.id')
            ->paginate(10);

        // Accepted / Rejected counts
        // Your API stores lowercase actions, so handle both cases.
        $counts = DB::table('emergency_responses')
            ->selectRaw("
                SUM(CASE
                    WHEN LOWER(response_action) IN ('accept', 'accepted')
                    THEN 1 ELSE 0
                END) as accepted_count,

                SUM(CASE
                    WHEN LOWER(response_action) IN ('decline', 'declined', 'reject', 'rejected')
                    THEN 1 ELSE 0
                END) as rejected_count,

                SUM(CASE
                    WHEN LOWER(response_action) = 'help_completed'
                    THEN 1 ELSE 0
                END) as help_completed_count
            ")
            ->first();

        return view(
            'admin.emergency_responses_lists',
            compact('responses', 'counts')
        );
    }

    
}
