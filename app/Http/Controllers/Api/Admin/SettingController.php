<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function show()
    {
        $settings = Setting::first();
        return new SettingResource($settings);
    }

    public function update(Request $request)
    {
        $settings = Setting::firstOrCreate(['id' => 1]);
        $settings->update($request->all());
        return new SettingResource($settings);
    }
}
