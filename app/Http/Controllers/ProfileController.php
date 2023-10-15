<?php

namespace App\Http\Controllers;


use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

//form request
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\StudentDetailFormRequest;

//models
use App\Models\ParentGuardian;
use App\Models\StudentDetail;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function addProfileDetail(Request $request){
         $request->validate([
            //student
            'lrn' => 'required|numeric',
            'grade_lvl' => 'required',
            'has_comorbidity' => 'required',
            'vaccine_status' => 'required',
            'hgfrl' => 'required',
            'mogts' => 'required',
            'is_madrasah_enrolled' => 'required',
            'is_4ps_member' => 'required',

             //parent info
            'inputs.*.first_name' => 'required',
            'inputs.*.middle_name' => 'required',
            'inputs.*.last_name' => 'required',
            'inputs.*.relationship' => 'required',
            'inputs.*.occupation' => 'required',
            'inputs.*.contact_no' => 'required',
            'inputs.*.email' => 'required',

         ]);
        //  dd($request);
        //student detail
        $profileDetail = new StudentDetail;
        $profileDetail->id = $request->user_id;
        $profileDetail->lrn =  $request->lrn;
        $profileDetail->grade_lvl =  $request->grade_lvl;
        $profileDetail->past_school =  $request->past_school;
        $profileDetail->past_school_address = $request->past_school_add;
        $profileDetail->past_school_id =  $request->past_school_id;
        $profileDetail->has_comorbidity =  $request->has_comorbidity;
        $profileDetail->illnesses =  $request->illnesses;
        $profileDetail->vaccine_status =  $request->vaccine_status;
        $profileDetail->hgfrl =  $request->hgfrl;
        $profileDetail->mogts =  $request->mogts;
        $profileDetail->is_madrasah_enrolled =  $request->is_madrasah_enrolled;
        $profileDetail->is_4ps_member =  $request->is_4ps_member;
        $profileDetail->save();

        // //dd($request);
        foreach($request->inputs as $key => $value){
            ParentGuardian::create($value);
            // StudentDetail::create($value);
          
        }
        
        // $parentDetail = new ParentGuardian;
        // $parentDetail->id = $data['user_id'];
        // $parentDetail->first_name = $data['fname'];
        // $parentDetail->middle_name = $data['mname'];
        // $parentDetail->last_name = $data['lname'];
        // $parentDetail->suffix = $data['suffix'];
        // $parentDetail->relationship = $data['relationship'];
        // $parentDetail->occupation = $data['occupation'];
        // $parentDetail->contact_no = $data['contact_no'];
        // $parentDetail->email = $data['email'];
        // $parentDetail->fb_account = $data['fb_acc'];
        // $parentDetail->save();

        return redirect('/profile')->with('success', 'Sucessfully Added Student Details. Please wait for the AO to accept your registration');
   
    
    }
}
