<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Permission::paginate(20);
        return view('permissions.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'routes' => 'required',
        ]);

        Permission::create([
            'name' => $request->name,
            'routes' => $request->routes,
            'guard_name' => 'web'
        ]);

        session()->flash('success', 'تم إضافة الصلاحية بنجاح');
        return redirect()->route('permissions.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = Permission::findOrFail($id);
        return view('permissions.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
            'routes' => 'required',
        ]);

        $record = Permission::findOrFail($id);
        $record->update($request->all());

        session()->flash('success', 'تم تعديل الصلاحية بنجاح');
        return redirect()->route('permissions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Permission::findOrFail($id);
        $record->delete();

        session()->flash('success', 'تم حذف الصلاحية بنجاح');
        return redirect()->route('permissions.index');
    }
}
