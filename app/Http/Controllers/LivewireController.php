<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LivewireController extends Controller
{
    public function handle(Request $request)
    {
        $component = $request->route()->getAction('component');
        return app()->call($component);
    }
}
