<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmergencyAlert;

class EmergencyAlertController extends Controller
{

    // ADMIN VIEW
    public function index()
    {
        $alerts = EmergencyAlert::latest()->get();

        return view('admin.emergency-alerts',
            compact('alerts'));
    }

    // STORE ALERT
    public function store(Request $request)
    {
        EmergencyAlert::create([

            'user_name' => $request->user_name,

            'mobile' => $request->mobile,

            'message' => $request->message,

            'latitude' => $request->latitude,

            'longitude' => $request->longitude,
        ]);

        return back()->with('success',
            'Emergency Alert Sent Successfully');
    }

    // UPDATE STATUS
    public function updateStatus(Request $request, $id)
    {
        $alert = EmergencyAlert::findOrFail($id);

        $alert->status = $request->status;

        $alert->save();

        return back()->with('success',
            'Status Updated');
    }


}