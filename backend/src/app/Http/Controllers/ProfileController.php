<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PelamarProfile;

class ProfileController extends Controller
{
    /** GET /profile */
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/')->withErrors(['message' => 'User tidak ditemukan.']);
        }

        $profile = $user->pelamarProfile;

        if (!$profile) {
            // Optional: bisa diarahkan ke form isi profil awal
            return redirect('/')->withErrors(['message' => 'Profil belum dibuat.']);
        }

        return view('frontend.profile', compact('user', 'profile'));
    }

    /** PUT /profile/update */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('/')->withErrors(['message' => 'User tidak ditemukan.']);
        }

        $profile = $user->pelamarProfile;
        if (!$profile) {
            return redirect('/')->withErrors(['message' => 'Profil tidak ditemukan.']);
        }

        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email',
            'phone'            => 'nullable|string|max:20',
            'birth_place'      => 'nullable|string|max:100',
            'birth_date'       => 'nullable|date',
            'gender'           => 'nullable|in:laki-laki,perempuan',
            'id_number'        => 'nullable|string|max:50',
            'education_level'  => 'nullable|in:SMA/sederajat,D3,S1,S2,S3',
            'address'          => 'nullable|string',
            'summary'          => 'nullable|string',
            'work_experience'  => 'nullable|string',
            'achievements'     => 'nullable|string',
            'certifications'   => 'nullable|string',
            'skills'           => 'nullable|string',
            'languages'        => 'nullable|string',
            'interests'        => 'nullable|string',
            'major'            => 'nullable|string|max:255',
            'profile_picture'  => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Helper CSV sanitizer
        $csv = fn(?string $str) => $str
            ? collect(explode(',', $str))->map(fn($v) => trim($v))->filter()->implode(', ')
            : null;

        // Update foto profil jika ada
        if ($request->hasFile('profile_picture')) {
            if ($profile->profile_picture && Storage::disk('public')->exists($profile->profile_picture)) {
                Storage::disk('public')->delete($profile->profile_picture);
            }

            $profile->profile_picture = $request->file('profile_picture')
                                                 ->store('profile_pictures', 'public');
        }

        // Update User
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Update Profile
        $profile->update([
            'phone'           => $request->phone,
            'birth_place'     => $request->birth_place,
            'birth_date'      => $request->birth_date,
            'gender'          => $request->gender,
            'id_number'       => $request->id_number,
            'education_level' => $request->education_level ?: null,
            'address'         => $request->address,
            'summary'         => $request->summary,
            'work_experience' => $request->work_experience,
            'achievements'    => $request->achievements,
            'certifications'  => $request->certifications,
            'skills'          => $csv($request->skills),
            'languages'       => $csv($request->languages),
            'interests'       => $csv($request->interests),
            'major'           => $request->major,
        ]);

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui.');
    }
}