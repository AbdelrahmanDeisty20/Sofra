<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class citiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = City::all();
        return view('cities.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required',
        ],[
            'name.required' => 'الاسم مطلوب',
        ]);
        City::create($request->all());
        return redirect()->route('cities.index')->with('success', 'تم إضافة المدينة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $model = City::findOrFail($id);
        return view('cities.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required',
        ],[
            'name.required' => 'الاسم مطلوب',
        ]);
        $model = City::findOrFail($id)->update($request->all());
        return redirect()->route('cities.index')->with('success', 'تم تعديل المدينة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = City::findOrFail($id);
        $record->delete();
        return redirect()->route('cities.index')->with('success', 'تم حذف المدينة بنجاح');
    }
}
