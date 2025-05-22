<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // misal return view dashboard admin
        return view('admin.dashboard');
    }
}
