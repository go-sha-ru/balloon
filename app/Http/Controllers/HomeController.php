<?php

namespace App\Http\Controllers;

use  Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\View\View;

class HomeController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function index(Request $request): View
    {

        return view('home', [
            'user' => $request->user(),
        ]);
    }
}
