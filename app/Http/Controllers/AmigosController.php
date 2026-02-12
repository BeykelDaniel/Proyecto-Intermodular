<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AmigosController extends Controller
{
    public function index()
    {
        return view('amigos.index');
    }
}