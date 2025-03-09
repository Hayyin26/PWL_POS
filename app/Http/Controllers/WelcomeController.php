<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() 
    {
        $breadcrumb = (object) [
            'title' => 'Selamat Datang',
            'list' => ['Home', 'Welcome']
        ];

        $activeMenu = 'dasboard';
        
        return view('welcome', ['breadcrum' => $breadcrumb, 'activeMenu' => $activeMenu]);
    }
}
