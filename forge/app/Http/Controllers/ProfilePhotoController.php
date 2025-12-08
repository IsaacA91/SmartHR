<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Employee;
use App\Models\Admin;

class ProfilePhotoController extends Controller
{
    public function uploadEmployeePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $employee = Auth::guard('employee')->user();

        // Delete old photo if exists
        if ($employee->profilePhoto && Storage::disk('public')->exists($employee->profilePhoto)) {
            Storage::disk('public')->delete($employee->profilePhoto);
        }

        // Store new photo
        $path = $request->file('photo')->store('profile_photos', 'public');

        // Update employee record
        $employee->update(['profilePhoto' => $path]);

        return redirect()->back()->with('success', 'Profile photo updated successfully!');
    }

    public function uploadAdminPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $admin = Auth::guard('admin')->user();

        // Delete old photo if exists
        if ($admin->profilePhoto && Storage::disk('public')->exists($admin->profilePhoto)) {
            Storage::disk('public')->delete($admin->profilePhoto);
        }

        // Store new photo
        $path = $request->file('photo')->store('profile_photos', 'public');

        // Update admin record
        $admin->update(['profilePhoto' => $path]);

        return redirect()->back()->with('success', 'Profile photo updated successfully!');
    }

    public function deleteEmployeePhoto()
    {
        $employee = Auth::guard('employee')->user();

        if ($employee->profilePhoto && Storage::disk('public')->exists($employee->profilePhoto)) {
            Storage::disk('public')->delete($employee->profilePhoto);
            $employee->update(['profilePhoto' => null]);
        }

        return redirect()->back()->with('success', 'Profile photo deleted successfully!');
    }

    public function deleteAdminPhoto()
    {
        $admin = Auth::guard('admin')->user();

        if ($admin->profilePhoto && Storage::disk('public')->exists($admin->profilePhoto)) {
            Storage::disk('public')->delete($admin->profilePhoto);
            $admin->update(['profilePhoto' => null]);
        }

        return redirect()->back()->with('success', 'Profile photo deleted successfully!');
    }
}
