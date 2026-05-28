<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


    public function UsersList()
    {
        $users = DB::table('users')

            ->whereIn('user_role', [
                'police',
                'Manager',
                'Gym_Person',
                'Defense'
            ])

            ->select(
                'id',
                'name',
                'email',
                'user_role',
                'phone_no',
                'created_at'
            )

            ->orderBy('id', 'desc')

            ->paginate(10);

        return view('admin.users_list', compact('users'));
    }

    // function to show the user details Page
    public function UsersDetails($id)
    {
        $UsersDetails = DB::table('users')
            ->where('id', $id)
            ->first();

        return view('admin.view_user_details', compact('UsersDetails'));
    }


}