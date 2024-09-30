<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class paymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Payment::with('restaurant')->paginate(10);
        return view('payments.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $restaurants = Restaurant::all();
        return view('payments.create', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'date'=>'required',
            'details'=> 'required',
            'pay'=> 'required',
        ],[
            'date.required'=> 'التاريخ مطلوب',
            'details.required'=> 'الرجاء ادخال التفاصيل',
            'pay.required'=> 'الرجاء ادخال عدد الدفعات',
        ]);
        $records = Payment::create($request->all());
        return redirect()->route('payments.index')->with('success','تمت الاضافة بنجاح');
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
        $model = Payment::findOrFail($id);
        return view('payments.edit', compact('model'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = validator()->make($request->all(),[
            'date'=> 'required',
            'pay'=> 'required',
            'details'=> 'required',
        ]);
        $records = Payment::findOrFail($id)->update($request->all());
        return redirect()->route('payments.index')->with('success','تم التعديل بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $records = Payment::findOrFail($id);
        $records->delete();
        return redirect()->back()->with('success','تم الحذف بنجاح');
    }
}
