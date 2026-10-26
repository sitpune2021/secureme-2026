<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SignalController extends Controller
{

   
    public function AllEmergencySignalsList()
    {
        $signals = DB::table('emergency_signals as es')
            ->join('users as u', 'u.id', '=', 'es.user_id')
            ->select(
                'es.id',
                'es.signal_id',
                'es.signal_status',
                'es.latitude',
                'es.longitude',
                'es.created_at',
                'u.name as user_name',
                'u.email as user_email',
                'u.phone_no as user_phone'
            )
            ->orderBy('es.id', 'desc')
            ->paginate(10);

        // Get all responder/helper responses for the signals on this page.
        $signalRecordIds = $signals->getCollection()
            ->pluck('id')
            ->toArray();

        $responses = DB::table('emergency_responses as er')
            ->leftJoin('users as responder', 'responder.id', '=', 'er.user_id')
            ->whereIn('er.signal_id', $signalRecordIds)
            ->select(
                'er.id',
                'er.signal_id',
                'er.responder_type',
                'er.user_id',
                'er.response_action',
                'er.response_notes',
                'er.status as response_status',
                'er.updated_at',
                'responder.name as responder_name',
                'responder.phone_no as responder_phone',
                'responder.user_role as responder_role'
            )
            ->orderBy('er.updated_at', 'desc')
            ->get()
            ->groupBy('signal_id');

        // Attach responder responses to each signal row.
        $signals->getCollection()->transform(function ($signal) use ($responses) {
            $signal->responders = $responses->get($signal->id, collect());
            return $signal;
        });

        return view('admin.emergency_signals_list', compact('signals'));
    }


    public function closeEmergencySignal($id)
    {
        $signal = DB::table('emergency_signals')
            ->where('id', $id)
            ->first();

        if (!$signal) {
            return redirect()->back()->with('error', 'Emergency signal not found.');
        }

        if ($signal->signal_status === 'Resolved') {
            return redirect()->back()->with('success', 'This emergency is already closed.');
        }

        DB::table('emergency_signals')
            ->where('id', $id)
            ->update([
                'signal_status' => 'Resolved',
                'updated_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Emergency signal closed successfully.');
    }
    

}
