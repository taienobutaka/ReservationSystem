<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModalController extends Controller
{
    public function show(Request $request)
    {
        $request->session()->put('showModal', true);
        return redirect()->route('shop.index');
    }

    public function hide(Request $request)
    {
        $request->session()->forget('showModal');
        return redirect()->route('shop.index');
    }
}
