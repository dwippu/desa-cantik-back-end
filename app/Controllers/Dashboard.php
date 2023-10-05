<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index(): string
    {
        if (auth()->user()->inGroup('superadmin')){
            return view('superadmin_pages/superadmin_dashboard');
        }
        else{
            return view('dashboard');
        }
    }
}
