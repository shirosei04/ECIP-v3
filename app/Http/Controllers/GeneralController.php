<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\Award;
use App\Models\User;
use App\Models\StudentDetail;
use App\Models\StudentAward;
use App\Models\ParentGuardian;
use App\Models\Announcement;
use App\Models\Schedule;
use App\Models\Semester;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Grade;
use App\Models\Grading;
use App\Models\Tuition;
use App\Models\StudentAssessment;
use File;

use DB;

class GeneralController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(){
        return view('auth.login');
    }

    public function dashboard(){
        if(Auth::user()->is_verified == '0'){
                    return redirect('/profile');
                }else{
                    $announcements = Announcement::join('users', 'users.id', '=', 'announcements.id')
                    ->orderBy('announcements.created_at', 'desc')->get();
                    return view('announcements', compact('announcements'));
                }
        
        // if(Auth::user()->role == 'Principal'){
        //     //students chart
        //     $users = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        //             ->whereYear('created_at', date('Y'))
        //             ->where('role', 'Student')
        //             ->groupby('month')
        //             ->orderby('month')
        //             ->get();
                    
        //     $labels = [];
        //     $data = [];
        //     $colors = ['#FF6384', '#FA6384', '#FC6384', '#FB6384', '#FF6284', '#FF6344', '#FF6300', '#CF6384', '#EF6384', '#FF6384', '#FF6584' ];

        //     for($i=0; $i <= 12; $i++){
        //         $month = date('F',mktime(0,0,0,$i,1));
        //         $count = 0;

        //         foreach($users as $user){
        //             if($user->month == $i){
        //                 $count = $user->count;
        //                 break;
        //             }
        //         }

        //         array_push($labels, $month);
        //         array_push($data, $count);
        //     }
            
        //     $datasets = [
        //         [
        //         'label' => 'Students of '.date("Y"),
        //         'data' => $data,
        //         'backgroundColor' => $colors
        //         ]
        //     ];

        //     //gradings
        //     $syear = SchoolYear::where('is_current', '1')->first();
        //     $gradings = Grading::all();
        //     $sections = Section::count();
        //     $fees = Tuition::count();

        //     return view('principal.dashboard', compact('datasets', 'labels', 'gradings', 'sections', 'syear', 'fees'));
        // }
        // else{
        //     if(Auth::user()->is_verified == '0'){
        //         return redirect('/profile');
        //     }else{
        //         $announcements = Announcement::join('users', 'users.id', '=', 'announcements.id')
        //         ->orderBy('announcements.created_at', 'desc')->get();
        //         return view('announcements', compact('announcements'));
        //     }
        // }

    }

    public function profile(){
        $users = User::where('id', '=', Auth::user()->id)->get();
        $awards = StudentAward::join('awards', 'awards.award_id', '=', 'student_awards.awardId')
                              ->where('id', '=', Auth::user()->id)->get();
        return view('profile', compact('users', 'awards'));
    }

    public function changePassIndex(){
        return view('change-password');
    }

    public function saveChangePass(Request $request){
        // dd($request);
        $data = $request->validate([
            'password' => 'required|confirmed',
        ]);
        // dd($data['password']);
        $user = User::find($request->user_id);
        $user->password = Hash::make($data['password']);
        $user->update();
        return redirect('/change-password')->with('message', 'Your password was successfully changed!');

    }
    // public function announcements(){
    //     $announcements = Announcement::join('users', 'users.id', '=', 'announcements.id')
    //                             ->orderBy('announcements.created_at', 'desc')->get();
    //     return view('announcements', compact('announcements'));
    // }
    
    public function schedule(){
        if(Auth::user()->role == "Student" & Auth::user()->is_verified == "0"){
            return redirect('/profile');
        }else{
            if(Auth::user()->role == 'Student' && Auth::user()->student->enrollment_status == '1'){
                $currentYear = SchoolYear::where('is_current', '1')->first();
                $semester = Semester::where('sem_status', '1')->first();
                if(empty($currentYear)){
                    $scheds = [];
                    return view('schedule', compact('scheds'));
                }else{
                    $add = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                    ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                    ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')
                    ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                    ->where('stud_id', Auth::user()->id)->where('year_id', $currentYear->sy_id)
                    ->where('semester', 'Not Applicable');

                    $scheds = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                            ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                            ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')
                            ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                            ->where('stud_id', Auth::user()->id)->where('year_id', $currentYear->sy_id)->where('semester', $semester->semester)->union($add)->get();
                            return view('schedule', compact('scheds'));
                }
            }
            elseif(Auth::user()->role == 'Student' && Auth::user()->student->enrollment_status == '0'){
                $scheds = [];
                return view('schedule', compact('scheds'));
            }
        }
    }

    //private functions
    private function studentDetailChecker(){
        $user = StudentDetail::where('id', '=', Auth::user()->id)->get();
        if(count($user) == 0){
            //0 meaning there WAS NO student detail found
            return '0';
        }else{
            //1 meaning there IS a student detail found
            return '1';
        }
    }

    private function parentGuardianChecker(){
        $user = ParentGuardian::where('id', '=', Auth::user()->id)->get();
        if(count($user) == 0){
            //0 meaning there WAS NO student detail found
            return '0';
        }else{
            //1 meaning there IS a student detail found
            return '1';
        }
    }
   
}
