<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

//models
use App\Models\Award;
use App\Models\User;
use App\Models\StudentDetail;
use App\Models\StudentAward;
use App\Models\ParentGuardian;
use App\Models\Announcement;
use App\Models\Schedule;
use App\Models\SchoolYear;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Grade;
use App\Models\Tuition;
use App\Models\StudentAssessment;
use DB;
class StudentController extends Controller
{
   public function enrollment(){
    if(Auth::user()->is_verified == "0"){
        return redirect('/profile');
    }else{
        $allFees = StudentAssessment::where('student_id', Auth::user()->id)->sum('running_balance');
            $ifActiveSy = SchoolYear::where('is_current', '1')->get();
            $ifOpenSy = SchoolYear::where('is_current', '1')->first();
            if(count($ifActiveSy) != 0){
                $sections = Section::where('section_grade_lvl', Auth::user()->student->grade_lvl)->get();
                $scheds = [];
                return view('student.enrollment', compact('sections', 'scheds', 'ifActiveSy', 'allFees', 'ifOpenSy'));
            }
            else{
                $sections = [];
                $scheds = [];
                return view('student.enrollment', compact('sections', 'scheds', 'ifActiveSy', 'allFees'));
            }
    }
    
   }

   public function selectSection(Request $request){
    $semester = Semester::where('sem_status', '1')->first();
    $ifOpenSy = SchoolYear::where('is_current', '1')->first();
    //get the sy that is set as current
    $ifActiveSy = SchoolYear::where('is_current', '1')->first();
    //show the appropriate section for that matches the user
    $sections = Section::where('section_grade_lvl', Auth::user()->student->grade_lvl)->get();
    //filter the schedule of the selected section with the corresponding current school year
    if(Auth::user()->student->grade_lvl == '11' | Auth::user()->student->grade_lvl == '12'){
      

        $generals = Schedule::join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
        ->where('semester', $semester->semester)
        ->where('sect_id', $request->select_section)
        ->where('year_id', $ifActiveSy->sy_id)
        ->where('semester', $semester->semester)->where('track', 'General Subject(SHS)');

        $scheds = Schedule::join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
        ->where('semester', $semester->semester)
        ->where('sect_id', $request->select_section)
        ->where('year_id', $ifActiveSy->sy_id)
        ->where('semester', $semester->semester)->where('track', $request->select_track)->union($generals)->get();
    }else{
        $scheds = Schedule::join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
        ->where('sect_id', $request->select_section)
        ->where('year_id', $ifActiveSy->sy_id)->get();
    }
    
  
    //check if selected section is full
    DB::statement("SET SQL_MODE=''");
    $selectedSection = Section::where('section_id', $request->select_section)->first();
    $currentSy = SchoolYear::where('is_current', '1')->first();
    $studentCount = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                 ->where('sect_id', $selectedSection->section_id)->where('year_id', $currentSy->sy_id)->groupby('stud_id')->get();
    // $scheds = Schedule::where('sect_id', $request->select_section)->get();
    $allFees = StudentAssessment::where('student_id', Auth::user()->id)->sum('running_balance');
    if(count($studentCount) != $selectedSection->capacity){
    return view('student.enrollment', compact('scheds', 'sections', 'ifActiveSy', 'selectedSection', 'allFees', 'ifOpenSy'));
    }else{
        return redirect('/enrollment')->with('alert',  $selectedSection->section_name . ' section is already full. Please wait for the Admission Officer to make another section');
    }
   }

   public function enrollStudent(Request $request){
    
    //dd($request->inputs);
    //check if section has slots
    // DB::statement("SET SQL_MODE=''");
    // $selectedSection = Section::where('section_id', $request->selected_section)->first();
    // $currentSy = SchoolYear::where('is_current', '1')->first();
    // $studentCount = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
    //              ->where('sect_id', $selectedSection->section_id)->where('year_id', $currentSy->sy_id)->groupby('stud_id')->get();
    // // dd(count($studentCount));
    
    // if(count($studentCount) != $selectedSection->capacity){
    //     $scheds = Schedule::where('sched_id', '=', $request->section_id)->get();
    //     $c = 0;
    //     foreach($request->inputs as $key => $value){
    //         Grade::create([
    //             'stud_id' => $request->stud_id,
    //             'schedule_id' => $request->inputs[$c],
    //             'frst_grade' => null,
    //             'scnd_grade' => null,
    //             'thrd_grade' => null,
    //             'frth_grade' => null,
    //         ]);
    //         $c++;
    //     }
    //     //update student enrollment status to 1
    //     $student = StudentDetail::where('id', $request->stud_id)->first();
    //     $student->enrollment_status = '1';
    //     $student->update();
    
    //     //calculate the assessment
    //     $fee = Tuition::where('for_grade_lvl', Auth::user()->student->grade_lvl)->first();
    //     $year = SchoolYear::where('is_current', '1')->first();
    //     $studentFee = StudentAssessment::create([
    //         'student_id' => $request->stud_id,
    //         'year_id' => $year->sy_id,
    //         'payment_desc' => 'Full Tuition',
    //         'payment_amount' => $fee->tuition_fee + $fee->misc_fee,
    //         'payment_type' => 'Addition',
    //         'payment_date' => now()->toDateString('Y-m-d'),
    //         'running_balance' => $fee->tuition_fee + $fee->misc_fee,
    //     ]);
    //     return redirect('/enrollment')->with('message', 'Successfully Enrolled');
    // }else{
    //     return redirect('/enrollment')->with('alert', 'This section is already full');
    // }
        $c = 0;
        foreach($request->inputs as $key => $value){
            Grade::create([
                'stud_id' => $request->stud_id,
                'schedule_id' => $request->inputs[$c],
                'frst_grade' => null,
                'scnd_grade' => null,
                'thrd_grade' => null,
                'frth_grade' => null,
            ]);
            $c++;
        }
        //update student enrollment status to 1
        $student = StudentDetail::where('id', $request->stud_id)->first();
        $student->enrollment_status = '1';
        $student->update();
    
        //calculate the assessment
        $fee = Tuition::where('for_grade_lvl', Auth::user()->student->grade_lvl)->first();
        $year = SchoolYear::where('is_current', '1')->first();
        $studentFee = StudentAssessment::create([
            'student_id' => $request->stud_id,
            'year_id' => $year->sy_id,
            'payment_desc' => 'Full Tuition',
            'payment_amount' => $fee->tuition_fee + $fee->misc_fee,
            'payment_type' => 'Addition',
            'payment_date' => now()->toDateString('Y-m-d'),
            'running_balance' => $fee->tuition_fee + $fee->misc_fee,
        ]);
        return redirect('/enrollment')->with('message', 'Successfully Enrolled');
   }

   public function selectSubject(Request $request){
    if(empty($request->inputs)){
        return redirect()->back()->with('alert', 'No selected subject. Cannot procede with enrollment');
    }else{
    //find and return all the selected subjects
        $scheds = [];
        foreach($request->inputs as $key => $value){
            $selected = Schedule::where('sched_id', $value)->get();
            array_push($scheds, $selected);
        }
        $selectedSection = $request->selected_section;
        return view('student.selected-subjects', compact('scheds', 'selectedSection'));
        }
    }
   
   public function assessment(){
    if(Auth::user()->is_verified == "0"){
        return redirect('/profile');
    }else{
    DB::statement("SET SQL_MODE=''");
     $myFees = StudentAssessment::join('school_years', 'school_years.sy_id', '=', 'student_fees.year_id')
                                ->where('student_id', '=', Auth::user()->id)->orderby('payment_date', 'desc')->get();
     $allFees = StudentAssessment::where('student_id', Auth::user()->id)->sum('running_balance');
    // $allFees = StudentAssessment::where('student_id', '=', Auth::user()->id)->sum('running')
    return view('student.assessment', compact('myFees', 'allFees'));
    }
   }

   public function grades(){
    if(Auth::user()->is_verified == "0"){
        return redirect('/profile');
    }else{
        // $grades = StudentGrades::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
        DB::statement("SET SQL_MODE=''");
        $grades = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                        ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                        ->where('stud_id', Auth::user()->id)->groupBy('year_id')->get();

                        
        $studId = "";
        return view('student.grades', compact('grades', 'studId'));
    }
   }

   public function filtered_grades(Request $request){
    // $grades = StudentGrades::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
    DB::statement("SET SQL_MODE=''");
    $mygrades = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                    ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                    ->join('sections', 'sections.section_id', '=', 'schedules.sect_id') 
                    ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                    ->where('stud_id', Auth::user()->id)
                    ->where('year_id', $request->select_year)
                    ->where('semester', $request->select_sem)
                    ->get();

    $grades = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                ->where('stud_id', Auth::user()->id)->groupBy('year_id')->get();

    $gradelvl = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
    ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
    ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
    ->where('stud_id', Auth::user()->id)
    ->where('year_id', $request->select_year)->groupby('subject_grade_lvl')->first();

    // $gl = 
    // dd($gl);
    $studId = "";
    $selectedSy = SchoolYear::where('sy_id', $request->select_year)->get();    
        if(count($mygrades) == 0){
            return redirect()->back()->with('alert', 'No grades found');
    }else{
        return view('student.grades', compact('mygrades', 'grades', 'selectedSy', 'studId', 'gradelvl'));
   }
   }


   

//    private function updateEnrollmentStatus($stud_id){
//     $student = StudentDetail::where('id', $stud_id);
//     $student->enrollment_status = '1';
//     $student->update();
//     return redirect('/enrollment')->with('Successfully Enrolled');
//    }
}
