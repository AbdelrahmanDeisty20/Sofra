<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class settingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'youtube_link'=>'required',
            'facebook_link'=>'required',
            'twitter_link'=> 'required',
            'instagram_link'=>'required',
            'email'=>'required',
            'phone'=>'required',
            'whatsapp'=>'required',
            'banks'=>'required',
            'commission_details'=>'required'
        ],[
            'youtube_link.required'=>'رابط اليوتيوب مطلوب',
            'facebook_link.required'=>'رابط الفيسبوك مطلوب',
            'twitter_link.required'=>'رابط التويتر مطلوب',
            'instagram_link.required'=>'رابط الانستجرام مطلوب',
            'email.required'=>'البريد الالكتروني مطلوب',
            'phone.required'=>'رقم الهاتف مطلوب',
            'banks.required'=>'البنوك مطلوب',
            'commission_details'=> 'تفاصيل العمواة مطلوبة'
        ]);
        Setting::create($request->all());
        return redirect()->back()->with('success','تمت الاضافة بنجاح');
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
        //
    }
}
