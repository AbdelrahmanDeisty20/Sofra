<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Street;
use Illuminate\Http\Request;

class regionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Street::all();
        return view('regions.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::all();
        return view('regions.create',compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = validator()->make($request->all(),[
            'name' => 'required',
            'city_id'=>'required'
        ],[
            'name.required'=>'الاسم مطلوب',
            'city_id.required'=>'المدينة مطلوبة'
        ]);
        Street::create($request->all());
        return redirect()->route('regions.index')->with('success','تمت الاضافة بنجاح');
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
        $model = Street::findOrFail($id);
        return view('regions.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = validator()->make($request->all(),[
            'name' => 'required',
        ],[
            'name.required'=>'الاسم مطلوب',
        ]);
        Street::findOrFail($id)->update($request->all());
        return redirect()->route('regions.index')->with('success','تمت التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = Street::findOrFail($id);
        $record->delete();
        return redirect()->route('regions.index')->with('success','تمت الحذف بنجاح');
    }
}
