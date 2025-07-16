<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\JobCategory;
use App\Models\Application;
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

    public function apply(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // Validasi data form
        $validated = $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'domicile' => 'required|string',
            'profesi' => 'required|string',
            'profesi_lainnya' => 'nullable|string',
            'instansi' => 'nullable|string',
            'education_level' => 'required|string',
            'position_experience' => 'required|string',
            'impactful_project' => 'required|string',
            'cv'    => 'required|file|mimes:pdf|max:2048',  // Memastikan ukuran file CV maksimal 2MB dan formatnya PDF
            'portfolio' => 'required|file|mimes:pdf,ppt,pptx,zip,rar|max:4096',  // Maksimal 4MB untuk Portofolio
            'agree' => 'required|accepted',  // Pastikan user menyetujui Privacy Policy
        ]);

        // Pastikan file CV dan Portofolio diupload
        if ($request->hasFile('cv') && $request->hasFile('portfolio')) {
            // Menyimpan file CV dan Portofolio di folder yang sesuai
            $cvPath        = $request->file('cv')->store('applications/cv', 'public');
            $portfolioPath = $request->file('portfolio')->store('applications/portfolio', 'public');

            // Memastikan file sudah disimpan dengan benar
            Log::info('CV Path: ', ['cv' => $cvPath]);
            Log::info('Portfolio Path: ', ['portfolio' => $portfolioPath]);

            // Menyimpan data lamaran ke dalam database
            Application::create([
                'user_id' => Auth::id(),
                'job_posting_id' => $request->job_posting_id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'domicile' => $request->domicile,
                'profesi' => $request->profesi,
                'profesi_lainnya' => $request->profesi_lainnya,
                'instansi' => $request->instansi,
                'education_level' => $request->education_level,
                'position_experience' => $request->position_experience,
                'impactful_project' => $request->impactful_project,
                'cv_file' => $cvPath,
                'portfolio_file' => $portfolioPath,
                'status' => 'Dikirim',
            ]);

            // Mengembalikan respons sukses
            return response()->json(['message' => 'Lamaran berhasil dikirim.']);
        } else {
            // Jika file tidak ada
            return response()->json(['message' => 'File CV atau Portofolio tidak ditemukan.'], 400);
        }
    }
}