<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Contracts\View\View;

class HomeController
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('home');
    }
}
