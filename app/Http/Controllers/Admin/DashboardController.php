<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\Work;

class DashboardController extends Controller
{
    public function index()
    {
        $postsCount = Post::count();
        $worksCount = Work::count();
        $customersCount = Customer::count();
        $usersCount = User::count();

        return view('admin.dashboard', compact('postsCount', 'worksCount', 'customersCount', 'usersCount'));
    }
}
