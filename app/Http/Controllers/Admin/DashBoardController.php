<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\Origin;
use App\Models\Brand;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount     = User::count();
        $roleCount     = Role::count();
        $categoryCount = Category::count();
        // $originCount   = Origin::count();
        // $brandCount    = Brand::count();

        return view('admin.dashboard', compact(
            'userCount',
            'roleCount',
            'categoryCount',
            // 'originCount',
            // 'brandCount'
        ));
    }
}
