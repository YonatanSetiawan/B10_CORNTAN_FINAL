<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Members;

class UserController extends Controller
{
    public function index()
    {
        $title = 'Profile';
        $header = 'User Profile';

        return view('user.index', compact('title', 'header'));
    }
    public function update(Request $request)
    {
        // get id from params
        $id = $request->id;
        // get data from form
        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
        // update data
        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        if ($password != null) {
            $user->password = Hash::make($password);
        }
        $user->save();
        // redirect to index
        return redirect()->route('user')->with('success', 'Data berhasil diubah');
    }
    public function dashboard()
    {
        $user = Auth::user();
        $user_roles = $user->user_roles;
        $member = Members::where('expired_at', '<', date('Y-m-d'));
        $member = $member->get();
        // change status to expired
        foreach ($member as $m) {
            $m->status = 'expired';
            $m->save();
            $userdb = User::find($m->id_user);
            $userdb->is_member = 0;
            $userdb->save();
            // delete m
            $m->delete();
        }
        
        if($user->user_roles==1){
            $title = 'Dashboard';
            $header = 'Permintaan Berlangganan';
            $member = Members::all();
            $user = User::all();
            return view('user.admin_dashboard', compact('title', 'header', 'member', 'user'));
        }else{
            $title = 'Dashboard';
            $header = 'Status Berlangganan';
            $member = Members::where('id_user', auth()->user()->id)->first();
            return view('user.dashboard', compact('title', 'header', 'member'));
        }
    }
    public function upgrade(Request $request)
    {
        // get id from params
        $id = $request->id;
        // get user from database
        $user = User::find($id);
        // create new member
        $member = new Members;
        $member->id_user = $user->id;
        $member->nama = $user->name;
        $member->email = $user->email;
        $member->expired_at = date('Y-m-d', strtotime('+70 days'));
        $member->save();
        // update user
        $user->is_member = 9;
        $user->save();
        // redirect to index
        return redirect()->route('user.dashboard')->with('success', 'Request upgrade berhasil');
    }
    public function payment(Request $request)
    {
        // get id from params
        $id = $request->id;
        // find where=id_user from member
        $member = Members::where('id_user', $id)->first();
        // save from file input to public/images/bukti
        $file = $request->file('file_upload');
        $file->move('images/bukti', $member->email . '.' . $file->getClientOriginalExtension());
        // update member
        $member->upload_bukti = $member->email . '.' . $file->getClientOriginalExtension();
        $member->save();
        $user = User::find($member->id_user);
        $user->is_member = 8;
        $user->save();
        // redirect to index
        return redirect()->route('user.dashboard')->with('success', 'Upload bukti berhasil');
    }
}
