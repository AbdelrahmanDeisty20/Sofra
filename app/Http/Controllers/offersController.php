<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class offersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = Offer::with('restaurant')->paginate(10);
        return view('offers.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $records = Offer::findOrFail($id)->delete();
        return redirect()->back()->with('success','تم الحذف بجاح');
    }
}
