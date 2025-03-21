<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GestionnaireController extends Controller
{
    public function dashboard()
    {
        return view('gestionnaire.dashboard');
    }
}
