<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class changePasswordController extends Controller
{
    public function index()
    {
        return view('change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed',
        ], [
            'current_password.required' => 'كلمة المرور القديمة مطلوبة',
            'new_password.required' => 'كلمة المرور الجديدة مطلوبة',
            'new_password.confirmed' => 'كلمة المرور الجديدة لا تتطابق',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور القديمة غير صحيحة']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with('success','تم تغيير كلمة المرور بنجاح');
    }
}
