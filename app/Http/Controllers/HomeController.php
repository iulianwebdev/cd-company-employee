<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Won't abstract this ones
     * but should be in the repos.
     */
    public function displayCounts()
    {
        return response([
            'company_counts' => Company::count(),
            'employee_counts' => Employee::count(),
        ], 200);
    }
}
