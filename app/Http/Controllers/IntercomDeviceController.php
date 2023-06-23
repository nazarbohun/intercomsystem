<?php

namespace App\Http\Controllers;

use App\Models\IntercomDevice;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IntercomDeviceController extends Controller
{
    public function index(): View
    {
        $intercomDevices = IntercomDevice::all();
        return view('IntercomDevice',compact('intercomDevices'));
    }
}
