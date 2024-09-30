<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class rolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records= Role::paginate(20);
        return view('roles.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission_list' => 'required|array',
        ]);
        $record=Role::create($request->all());
        $record->permissions()->attach($request->permission_list);
        session()->flash('success','تم اضافة الرتبة بنجاح');
        return redirect()->route('roles.index');
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
        $model= Role::findOrFail($id);
        return view('roles.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission_list' => 'required|array',
        ]);
        $records= Role::findOrFail($id);
        $records->update($request->all());
        $records->permissions()->sync($request->permission_list);
        session()->flash('success','تم تعديل الرتبة بنجاح');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $records= Role::find($id);
        if(!$records)
        {
            session()->flash('error','هذه الرتبة غير موجودة');
        }
        $records->delete();
        session()->flash('success','تم حذف الرتبة بنجاح');
        return redirect()->route('roles.index');
    }
}
