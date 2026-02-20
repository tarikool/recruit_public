<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('dashboard.recruiter');
        }

        if ($user->candidate) {
            return redirect()->route('candidates.show', $user->candidate->id);
        }

        return redirect("profile/{$user->name}");
    }
}
