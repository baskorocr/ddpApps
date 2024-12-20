<?php

namespace App\Http\Controllers;

use App\Models\line;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function index()
    {
        $lines = line::all();


        if (auth()->check() && auth()->user()->role == 'users') {
            return redirect('users/dashboard');
        }
        if (auth()->check() && auth()->user()->role != 'users') {
            return redirect(auth()->user()->role . '/dashboard');
        } else {
            return view('welcome', compact('lines'));
        }



    }
}