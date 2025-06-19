<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the root application request.
     * Redirects authenticated users to their respective dashboards.
     */
    public function index()
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's role
            $role = Auth::user()->role;

            // Redirect based on role
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'owner') {
                return redirect()->route('owner.dashboard');
            } elseif ($role === 'pelanggan') {
                return redirect()->route('pelanggan.dashboard');
            }
        }

        // If not authenticated, redirect to login page (as defined in routes)
        return redirect()->route('login');
    }
}
