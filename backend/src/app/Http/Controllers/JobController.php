<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\JobCategory;
use App\Models\Application;
use App\Models\ApplicationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobPosting::with('category', 'user')->where('status', 'Aktif')->get();
        $categories = JobCategory::all();
        return view('frontend.job', compact('jobs', 'categories'));
    }

     public function submitFromModal(Request $request)
{
    $request->validate([
        'posisi' => 'required|string',
        'nama' => 'required|string|max:255',
        'email' => 'required|email',
        'telepon' => 'required|string|max:20',
        'domisili' => 'required|string|max:255',
        'profesi' => 'required|string',
        'profesi_lainnya' => 'nullable|string|max:255',
        'instansi' => 'nullable|string|max:255',
        'pendidikan' => 'required|string',
        'pengalaman' => 'required|in:<1 tahun,1-2 tahun,3-5 tahun,>5 tahun',
        'proyek' => 'required|string',
        'cv' => 'required|mimes:pdf|max:2048',
        'portfolio' => 'required|mimes:pdf,ppt,pptx,zip,rar|max:5120',
    ]);

    $jobPosting = JobPosting::where('title', $request->posisi)->firstOrFail();

    $cvPath = $request->file('cv')->store('applications/cv', 'public');
    $portfolioPath = $request->file('portfolio')->store('applications/portfolio', 'public');

    $application = Application::create([
        'user_id' => Auth::id(), 
        'job_posting_id' => $jobPosting->id,
        'name' => $request->nama,
        'email' => $request->email,
        'phone' => $request->telepon,
        'domicile' => $request->domisili,
        'profesi' => $request->profesi,
        'profesi_lainnya' => $request->profesi === 'Lainnya' ? $request->profesi_lainnya : null,
        'instansi' => $request->instansi,
        'education_level' => $request->pendidikan,
        'position_experience' => $request->pengalaman,
        'impactful_project' => $request->proyek,
        'cv_file' => $cvPath,
        'portfolio_file' => $portfolioPath,
    ]);

    ApplicationLog::create([
        'application_id' => $application->id,
        'user_id' => Auth::id(),
        'action' => 'Lamaran Dikirim',
        'message' => 'Lamaran berhasil dikirim oleh pelamar.',
    ]);

    return response()->json(['success' => true, 'message' => 'Lamaran berhasil dikirim']);
}
}