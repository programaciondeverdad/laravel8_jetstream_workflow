<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Vista que permite roles de user y admin
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['user', 'admin']);
        
        // TODOs

        return Inertia::render('Home');
    }

    public function panelControlAdmin(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        return Inertia::render('PanelControlAdmin');
    }
    
}