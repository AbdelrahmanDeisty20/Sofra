<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class usersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = User::all();
        return view("users.index", compact("records"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|unique:users",
            "password" => "required|confirmed",
            'roles_list' => 'required'
        ],[
            'name.required'=> 'الاسم مطلوب',
            'email.required'=> 'الايميل مطلوب',
            'password.required'=> 'كلمة المرور مطلوبة',
            'password.confirmed'=> 'كلمة المرور لاتطابق',
            'roles_list.required'=> 'الصلاحية مطلوبة'
        ]);
        $user = User::create($request->except('roles_list', 'permission_list'));
        $user->roles()->attach($request->input('roles_list'));
        session()->flash('success', 'تم اضافة مستخدم بنجاح');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "name" => "required|unique:users,name,$id",
            "email" => "required",
            "password" => "confirmed",
            'roles_list' => 'required'
        ]);
        $user = User::findOrFail($id);
        $user->roles()->sync((array) $request->input('roles_list'));
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }
        $update = $user->update($request->except('password'));
        session()->flash('success', 'تم تعديل المستخدم بنجاح');
        return redirect()->route('users.edit',$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = User::findOrFail($id);
        $model->delete();
        return redirect()->back()->with('success','تم الحذف بنجاح');
    }
}
