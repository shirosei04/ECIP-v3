<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Http\Requests\RejectEmailRequest;

use App\Mail\ApproveMail;
use App\Mail\DeleteMail;


use App\Models\User;
use App\Models\StudentDetail;
use App\Models\ParentGuardian;
use App\Models\StudentAssessment;
use App\Models\Audit;
use App\Models\Grade;
use App\Models\SchoolYear;
use App\Models\Schedule;
use App\Models\Section;
use DB;
class AdmissionController extends Controller
{
    public function registryApproval(){
        $enrollees = User::where('is_verified', '=', '0')
                         ->where('role', '=', 'Student')
                         ->where('status', '=', '1')
                         ->orderBy('date_of_registration', 'asc')->paginate(18);
        $gradefilter = "nofilter";
        return view('ao.verify-register', compact('enrollees', 'gradefilter'));
    }

    public function searchNewEnrollee()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/registryApproval');
       }else{
        $gradefilter = "";
        $enrollees = User::where('role', '=', 'Student')->where('is_verified', '0')->where('id', 'LIKE', '%'.$search_text.'%')->paginate(10)->withQueryString();
                return view('ao.verify-register', compact('enrollees', 'search_text', 'gradefilter'));
        }
    }

    public function archivedUsers(){
        $enrollees = User::where('status', '=', '0')->where('is_verified', '0')->where('role', 'Student')
                         ->orderBy('date_of_registration', 'asc')->get();
                         $gradefilter = "nofilter";
        return view('ao.archived-users', compact('enrollees', 'gradefilter'));
    }

    public function searchArchived()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/archived-users');
       }else{
        $gradefilter = "";
        $enrollees = User::where('status', '0')->where('role', 'Student')->where('id', 'LIKE', '%'.$search_text.'%')->paginate(10)->withQueryString();
        return view('ao.archived-users', compact('enrollees', 'search_text', 'gradefilter'));
        }
    }

    public function approve($id){
        $accepted = User::find($id);
        $accepted->is_verified = '1';
        $accepted->update();
        //if user is already verified, automatically send an email to notify the user
        $email = $accepted->email;
        $mail = new ApproveMail;
        Mail::to($email)->send($mail);
    }

    public function reject($id, RejectEmailRequest $request){
        $data = $request->validated();

        //delete student detail
        $studDetail = StudentDetail::where('id', '=', $id);
        $studDetail->delete();

        //delete parent detail
        $parentDetail = ParentGuardian::where('id', '=', $id);
        $parentDetail->delete();
        
        //compose email using the data from the modal(request)
        $user = User::find($id);
        $email = $user->email;
        $mail_data = [
            'recipient' => $email,
            'from' => 'sadacjas101@gmail.com',
            'body' => $data['message'],
        ];
        //send email
        \Mail::send('email.rejected', $mail_data, function($message) use ($mail_data){
            $message->to($mail_data['recipient'])
                    ->from($mail_data['from'])
                    ->subject('Educare College Inc. Registry Verification');
        });
        return redirect('registryApproval');
    }

    public function viewDetails($id){
        $enrollee = User::find($id);
        return view('ao.view-details', compact('enrollee'));
    }

    public function archiveUser($id){
        $user = User::find($id);
        $user->status = '0';
        $user->update();
    }

    public function unarchiveUser($id){
        $user = User::find($id);
        $user->status = '1';
        // $user->student->date_of_registration = Carbon\Carbon::now();

        $user->update();
    }

    public function deleteUser($id){
        $deleted = User::findorFail($id);
        $deleted->delete();

        $email = $deleted->email;
        $mail = new DeleteMail;
        Mail::to($email)->send($mail);
    }

    public function filter_enrollees(Request $request)
    {
        if ($request->grade_filter == 'nofilter' | $request->grade_filter == 'reset' ){
            // $enrollees = User::where('is_verified', '=', '0')
            //                 ->where('role', '=', 'Student')
            //                 ->where('status', '=', '1')
            //                 ->orderBy('date_of_registration', 'asc')->paginate(10);
            // return view('ao.verify-register', compact('enrollees'));
            return redirect('/registryApproval');
        }
        else
        {
            $enrollees = User::join('student_details', 'student_details.id', '=', 'users.id')
                    ->where('is_verified', '=', '0')
                    ->where('role', '=', 'Student')
                    ->where('status', '=', '1')
                    ->orderBy('date_of_registration', 'asc')
                    ->when($request->grade_filter != null, function ($q) use ($request) {
                            return $q->where('grade_lvl', $request->grade_filter);
                    })->paginate(18)->withQueryString();
            $gradefilter = $request->grade_filter;
                    return view('ao.verify-register', compact('enrollees', 'gradefilter'));
        }
    }

    public function filter_archived(Request $request)
    {
        if ($request->grade_filter == 'nofilter' | $request->grade_filter == 'reset' ){
            // $enrollees = User::where('is_verified', '=', '0')
            //                 ->where('role', '=', 'Student')
            //                 ->where('status', '=', '1')
            //                 ->orderBy('date_of_registration', 'asc')->paginate(10);
            // return view('ao.verify-register', compact('enrollees'));
            return redirect('/archived-users');
        }
        else
        {
            $enrollees = User::join('student_details', 'student_details.id', '=', 'users.id')
                    ->where('status', '=', '0')
                    ->orderBy('date_of_registration', 'asc')
                    ->when($request->grade_filter != null, function ($q) use ($request) {
                            return $q->where('grade_lvl', $request->grade_filter);
                    })->paginate(18)->withQueryString();
            $gradefilter = $request->grade_filter;
                    return view('ao.archived-users', compact('enrollees', 'gradefilter'));
        }
    }

    public function studentList(){
        $users = User::join('student_details', 'student_details.id', '=', 'users.id')
        ->where('role', 'Student')->where('is_verified', '1')->orderby('grade_lvl')->orderby('last_name')->paginate(18);
        $gradefilter = "";
        return view('ao.student-list', compact('users', 'gradefilter'));
    }

    public function manageAssessment(){
        $fees = StudentAssessment::join('users', 'users.id', '=', 'student_fees.student_id')
                                ->join('school_years', 'school_years.sy_id', '=', 'student_fees.year_id')
                                ->join('student_details', 'student_details.id', '=', 'users.id')->orderby('running_balance', 'desc')->paginate(12);
        return view('ao.assessments', compact('fees'));

    }

    public function processAsessment(Request $request, $id){
        $fee = StudentAssessment::where('studfee_id', $id)->first();
        // $fee->payment_desc = $request->description;
        // $fee->payment_amount = $request->amount;
        if($request->type == "Add"){
            $fee->running_balance = $fee->running_balance + $request->amount;
        }else{
            $fee->running_balance = $fee->running_balance - $request->amount;
        }
        $fee->update();

        $audit = Audit::create([
            'transaction_id' => $fee->studfee_id,
            'transaction_description' => $request->description,
            'transaction_amount' => $request->amount,
            'transaction_date' => now()->toDateString('Y-m-d'),
            'transaction_type' => $request->type,
        ]);
        return redirect()->back()->with('message', 'Transaction Successfully Processed');
    }


    public function viewAssessment($id){
        DB::statement("SET SQL_MODE=''");
        $myFees = StudentAssessment::join('school_years', 'school_years.sy_id', '=', 'student_fees.year_id')
                                   ->where('student_id', '=', $id)->orderby('created_at', 'desc')->get();
        $allFees = StudentAssessment::where('student_id', $id)->sum('running_balance');
        $student = User::where('id', $id)->get();
       // $allFees = StudentAssessment::where('student_id', '=', Auth::user()->id)->sum('running')
       return view('student.assessment', compact('myFees', 'allFees', 'student'));
    }


    public function filter_students(Request $request)
    {
        if ($request->grade_filter == 'nofilter' | $request->grade_filter == 'reset' ){
            return redirect('ao-student-list');
        }
        else
        {
            $users = User::join('student_details', 'student_details.id', '=', 'users.id')
                            ->where('role', '=', 'Student')
                            ->where('is_verified', '=', '1')
                            ->orderBy('grade_lvl', 'asc')
                            ->orderBy('last_name', 'asc')
                            ->when($request->grade_filter != null, function ($q) use ($request) {
                            return $q->where('grade_lvl', $request->grade_filter);
                    })->paginate(18)->withQueryString();
            $gradefilter = $request->grade_filter;
            return view('ao.student-list', compact('users', 'gradefilter'));
        }
    }

    public function searchStudent()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/ao-student-list');
       }else{
        $users = User::where('role', 'Student')->where('last_name', 'LIKE', '%'.$search_text.'%')->paginate(10)->withQueryString();
            if(count($users) == 0){
                return redirect('/ao-student-list')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                $gradefilter = "";
                return view('ao.student-list', compact('users', 'search_text', 'gradefilter'));
            }
        }
    }

    public function grades($id){
        // $grades = StudentGrades::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
         DB::statement("SET SQL_MODE=''");
        $grades = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                        ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                        ->where('stud_id', $id)->groupBy('year_id')->get();
        $studId = $id;
        $student = User::where('id', $id)->get();
        $selYear = "";
        $selSem = "";
        return view('student.grades', compact('grades', 'studId', 'student', 'selYear', 'selSem'));
    }

    public function filtered_grades(Request $request){
        // $grades = StudentGrades::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
        $studId = $request->id;
        DB::statement("SET SQL_MODE=''");
        $mygrades = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                        ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                        ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                        ->join('sections', 'sections.section_id', '=', 'schedules.sect_id') 
                        ->where('stud_id', $studId)
                        ->where('year_id', $request->select_year)
                        ->where('semester', $request->select_sem)->get();     
        
      
        // dd($ave);
        $mysection = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                            ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                            ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                            ->join('sections', 'sections.section_id', '=', 'schedules.sect_id') 
                            ->where('stud_id', $studId)
                            ->where('year_id', $request->select_year)->groupby('sect_id')->first();

        
        $grades = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                    ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                    ->where('stud_id', $studId)->groupBy('year_id')->get();
        $student = User::where('id', $studId)->get();
        $mystud = User::where('id', $studId)->first();
        $currentYear = SchoolYear::where('is_current', '1')->first();
        $schedules = Schedule::join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                            ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')
                            ->where('year_id', $currentYear->sy_id)
                            ->where('sect_id', $mysection->sect_id)->get();
        $sections = Section::where('section_grade_lvl', $mystud->student->grade_lvl)->get();
        $selectedSy = SchoolYear::where('sy_id', $request->select_year)->get();    

        $gradelvl = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
        ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
        ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
        ->where('stud_id', $studId)
        ->where('year_id', $request->select_year)->groupby('subject_grade_lvl')->first();

        $selYear = $request->select_year;
        $selSem =  $request->select_sem;
       if(count($mygrades) == 0){
            return redirect()->back()->with('alert', 'No grades found');
       }else{
        return view('student.grades', compact('mygrades', 'grades', 'selectedSy', 'studId', 'student', 'schedules', 'sections', 'gradelvl', 'selYear', 'selSem'));
       }
    
    }

    public function deleteGrade($id){
        $grade = Grade::find($id);
        $grade->delete();
    }

    public function enrollNewSub(Request $request){
       Grade::create([
            'stud_id' => $request->student_id,
            'schedule_id' => $request->sched_id,
       ]);
       return redirect()->back()->with('message', 'Subject Successfully Added');
    }

    public function transferSection(Request $request){
        $request->validate([
            'section_id' => 'required',
        ]);
        //find current sy
        $currentYear = SchoolYear::where('is_current', '1')->first();
       //find and remove all current schedules of selected student
        $studGrades = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                            ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                            ->where('year_id', $currentYear->sy_id)
                            ->where('stud_id', $request->student_id)
                            ->where('frst_grade', null);
                            // ->where('scnd_grade', '=', '')
                            // ->where('thrd_grade', '=', '')
                            // ->where('frth_grade', '=', '');
        $studGrades->delete();
        //enroll all subjects of selected section
        $scheds = Schedule::where('sect_id', $request->section_id)->where('year_id', $currentYear->sy_id)->get();
        foreach($scheds as $sched){
            Grade::create([
                'stud_id' => $request->student_id,
                'schedule_id' => $sched->sched_id,
            ]);
        }

    }

}
