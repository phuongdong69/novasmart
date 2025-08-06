<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    //file này là file controller cho trang about
    public function index()
    {
        return view('user.pages.about');
    }
} 