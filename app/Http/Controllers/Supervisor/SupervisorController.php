<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index()
    {

        return view('supervisor.home'); // Make sure this view exists
    }

}