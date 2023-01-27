<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // Get last project
    public function getDashboardData(){
        return view('dashboard', [
            'lastProject' => Project::latest()->first(),
            'allUsers' => User::all()->count()
        ]);
    }
}
