<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Members;

class AdminController extends Controller
{
    public function index()
    {
        $title = 'Home';

        return view('admin.index', compact('title', 'header'));
    }
    public function approve(Request $request)
    {
        // get id from params
        $id = $request->id;
        // get user from database
        $user = User::find($id);
        // update user role
        $user->is_member = 1;
        $user->save();
        $member = Members::where('id_user', $id)->first();
        $member->status = 'active';
        $member->save();
        // redirect to index
        return redirect()->route('user.dashboard')->with('success', 'Berhasil menyetujui permintaan');
    }
    public function reject(Request $request)
    {
        // get id from params
        $id = $request->id;
        // get user from database
        $user = User::find($id);
        // update user role
        $user->is_member = 0;
        $user->save();
        $member = Members::where('id_user', $id)->first();
        $member->delete();
        // redirect to index
        return redirect()->route('user.dashboard')->with('success', 'Berhasil menolak permintaan');
    }
}
