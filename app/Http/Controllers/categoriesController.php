<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class categoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records= Category::all();
        return view('categories.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator= validator()->make($request->all(),[
            'name'=>'required',
        ],[
            'name.required'=>'الاسم مطلوب',
        ]);
        Category::create($request->all());
        return redirect()->route('categories.index')->with('success','تمت الاضافة بنجاح');

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
        $model= Category::findOrFail($id);
        return view('categories.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator= validator()->make($request->all(),[
            'name'=>'required',
        ],[
            'name.required'=>'الاسم مطلوب',
        ]);
        $model= Category::findOrFail($id);
        $model->update($request->all());
        return redirect()->route('categories.index')->with('success','تمت التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Category::findOrFail($id);
        $record->delete();
        return redirect()->route('categories.index')->with('success','تمت الحذف بنجاح');
    }
}
