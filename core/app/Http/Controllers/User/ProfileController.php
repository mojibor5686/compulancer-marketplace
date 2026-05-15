<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function profile()
    {
        $pageTitle = "Profile Setting";
        $user = auth()->user();
        return view('Template::user.profile_setting', compact('pageTitle', 'user'));
    }

    public function submitProfile(Request $request)
    {
        $imageValidation = ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])];


        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'designation' => 'required|string|max:40',
            'about_me'    => 'required|string',
            'image'       => $imageValidation,
            'bg_image'    => $imageValidation,
        ], [
            'firstname.required' => 'The first name field is required',
            'lastname.required' => 'The last name field is required'
        ]);

        $user = auth()->user();

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->designation = $request->designation;
        $user->about_me    = $request->about_me;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;

        if ($request->hasFile('image')) {
            $user->image = fileUploader($request->file('image'), getFilePath('userProfile'), getFileSize('userProfile'), @$user->image);
        }
        if ($request->hasFile('bg_image')) {
            $user->bg_image = fileUploader($request->file('bg_image'), getFilePath('userBgImage'), getFileSize('userBgImage'), @$user->bg_image);
        }
        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword()
    {
        $pageTitle = 'Change Password';
        return view('Template::user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request)
    {

        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', $passwordValidation]
        ]);

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changed successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }

    public function referralCommission()
    {
        $pageTitle = "Referral Commission";
        $user = auth()->user();

        // Get referred users
        $referredUsers = User::where('ref_by', $user->id)->get();

        // Get referral commissions transactions
        $referralCommissions = Transaction::where('user_id', $user->id)
            ->where('remark', 'referral_commission')
            ->latest()
            ->paginate(getPaginate());

        return view('Template::user.referral_commission', compact('pageTitle', 'user', 'referredUsers', 'referralCommissions'));
    }
}
