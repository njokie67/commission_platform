<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class salesrepregistrationController extends Controller
{
    //
    public function registration($id, Request $request){
        if (! $request->hasValidSignature()) {
            abort(401, 'Invalid URL. Request for a new one');
        }
        
        $user = User::find($id);
        
        if(isset($user)){

        }else{
            abort(403, 'Url invalid. Please try again');
        }

        if($user->level == 0 && $user->status == 0){

        }else{
            abort(403, 'User level is not set');
        }
        session(['user_id' => $user->id]);
        return view('pages.passwordset')->with('user', $user);

    }
    public function setnewpassword($id, Request $request){
        $user = User::find($id);
        if(isset($user)){}else{abort(403, 'User not found');}
        if($user->id == session('user_id')){}else{abort('Information does not match');}
        $this->validate($request, [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect('/login')->with([
            'success' => 'New password set. You can now log in',
        ]);
    }
}
