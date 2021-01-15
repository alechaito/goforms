<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Patient;
use App\User;
use Auth;


class UserController extends Controller
{

    public function edit_get() {
        $user = User::find(Auth::id());
        return view('user.edit', compact('user'));
    }

    public function edit_post(Request $request) {
        $user = User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return redirect()->back()->with('message-data', 'Dados atualizados com sucesso!');
    }

    public function edit_password(Request $request) {
        if($request->password == $request->confirm_password) {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->back()->with('message-password', 'Senha atualizada com sucesso!');
        }
        return redirect()->back()->with('message-password-error', 'Senhas nao coincidem!');
    }

}
