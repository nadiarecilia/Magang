<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class ApplicationLogController extends Controller
{
     public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('application.status', ['auth' => 'login']);
            }

        $applications = Application::with(['jobPosting', 'logs'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('frontend.status', compact('applications'));
    }
}
