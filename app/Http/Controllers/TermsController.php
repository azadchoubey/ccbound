<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TermsController extends Controller
{

    public function terms()
    {
        return Inertia::render('Terms');
    }

    public function privacy()
    {
        return Inertia::render('Privacy');
    }
}
