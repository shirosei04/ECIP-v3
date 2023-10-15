<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Models\Adviser;
use App\Models\Award;
use App\Models\User;
use App\Models\StudentDetail;
use App\Models\StudentAward;
use App\Models\ParentGuardian;
use App\Models\Announcement;
use App\Models\SchoolYear;
use App\Models\Tuition;
use App\Models\Curriculum;
use App\Models\Room;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Grading;
use App\Models\Semester;
use App\Models\Grade;
use Illuminate\Http\Request;
use DB;
class TeacherController extends Controller
{
    public function teacherSchedule(){
        $currentYear = SchoolYear::where('is_current', '1')->first();
        $semester = Semester::where('sem_status', '1')->first();
        if(empty($currentYear)){
            $scheds = [];
            return view('teacher.teacher-schedule', compact('scheds'));
        }else{
        $add = Schedule::join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
            ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
            ->where('id', Auth::user()->id)->where('year_id', $currentYear->sy_id)->where('semester', 'Not Applicable');
        $scheds = Schedule::join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                ->where('id', Auth::user()->id)->where('year_id', $currentYear->sy_id)->where('semester', $semester->semester)->union($add)->get();
        return view('teacher.teacher-schedule', compact('scheds'));
        }
    }

    public function classList(){
        // DB::statement("SET SQL_MODE=''");
        // //find out what classes are assigned to teacher
        // $list = Adviser::where('teacher_id', Auth::user()->id)->first();
        // //get all students who are enrolled in the assigned section
        // $students = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
        //             ->join('users', 'users.id', '=', 'student_grades.stud_id')
        //             ->where('sect_id', $list->tsection_id)->groupby('stud_id')->get();
        $syears = SchoolYear::orderby('sy_id', 'desc')->get();
        $students = []; 
        return view('teacher.class-list', compact('syears', 'students'));
    }

    public function selectYear(Request $request){
        DB::statement("SET SQL_MODE=''");
        //find out what classes are assigned to logged in teacher
        $list = Adviser::join('sections', 'sections.section_id', '=', 'advisers.tsection_id')  
                        ->where('teacher_id', Auth::user()->id)
                        ->where('tyear_id', $request->select_year)->get();
        if(count($list) != 0){
            $slist = Adviser::where('teacher_id', Auth::user()->id)
                        ->where('tyear_id', $request->select_year)->first();
            //get all students who are enrolled in the assigned section
            $students = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
            ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')  
            ->join('users', 'users.id', '=', 'student_grades.stud_id')
            ->join('student_details', 'student_details.id', '=', 'users.id')
            ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
            ->where('year_id', $request->select_year)
            ->where('semester', $request->select_sem)
            ->where('sect_id', $slist->tsection_id)->groupby('stud_id')->get();
            $syears = SchoolYear::orderby('sy_id', 'desc')->get();
            $selectedYear = $request->selected_year;
            $semester = $request->select_sem;
            return view('teacher.class-list', compact('syears', 'students', 'selectedYear'))->withYear($selectedYear)->withList($list)->withSemester($semester);
        }else{
            return redirect('class-list')->with('alert', 'No assigned class this year');
        }
       
    }

    public function handledSubjects(){
        $syears = SchoolYear::orderby('sy_id', 'desc')->get();
        $students = []; 
        return view('teacher.handled-subjects', compact('syears', 'students'));
    }

    public function subjectsSelectYear(Request $request){
        
        DB::statement("SET SQL_MODE=''");
        $syears = SchoolYear::orderby('sy_id', 'desc')->get();
        // $students = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
        // ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')  
        // ->join('users', 'users.id', '=', 'student_grades.stud_id')
        // ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
        // ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
        // ->where('schedules.year_id', $request->select_year)
        // ->where('schedules.id', Auth::user()->id)->groupby('sub_id')->get();
        $students = Schedule::join('sections', 'sections.section_id', '=', 'schedules.sect_id')  
                    ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                    ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                    ->where('schedules.year_id', $request->select_year)
                    ->where('schedules.id', Auth::user()->id)->groupby('sub_id')->get();
        // $students = Schedule::where('schedules.id', Auth::user()->id)->get();
        // ->where('id', Auth::user()->id)->get();
        return view('teacher.handled-subjects', compact('syears', 'students'));
    }

    public function viewSubjectStudents($id){
        DB::statement("SET SQL_MODE=''");
        $frst = Grading::where('grading_id', '1')->first();
        $scnd = Grading::where('grading_id', '2')->first();
        $thrd = Grading::where('grading_id', '3')->first();
        $frth = Grading::where('grading_id', '4')->first();
        $students = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                        ->join('users', 'users.id', '=', 'student_grades.stud_id')
                        ->join('student_details', 'student_details.id', '=', 'users.id')
                        ->where('schedule_id', $id)->orderby('last_name')->get();
        $gradelvl = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
        ->join('users', 'users.id', '=', 'student_grades.stud_id')
        ->join('student_details', 'student_details.id', '=', 'users.id')
        ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
        ->where('schedule_id', $id)->orderby('last_name')->groupby('subject_grade_lvl')->first();
        if(count($students) == 0){
            return redirect()->back()->with('alert', 'No students in this subject');
        }else{
        return view('teacher.view-students', compact('students', 'frst', 'scnd', 'thrd', 'frth', 'gradelvl'));
        }
    }

    public function postGrades(Request $request){
        // dd($request);
        $c = 0;
        foreach($request->inputs as $key => $value){
           $grades = Grade::find($value);
           $grades->frst_grade = $request->frst[$c];
           $grades->scnd_grade = $request->scnd[$c];
           $grades->thrd_grade = $request->thrd[$c];
           $grades->frth_grade = $request->frth[$c];
           $grades->view_status = 0;
           $grades->update();
           $c++;
            
        //    $grades->scnd_grade = $request->scnd;
        //    $grades->thrd_grade = $request->thrd;
        //    $grades->frth_grade = $request->frth;

        }
       
        return redirect()->back()->with('message', 'Successfully Uploaded');
       
    }

    public function bulkPostGrades(Request $request){
        //get what grading is open for grades posting
        $open = Grading::where('status', '1')->first();
        $c = 0;
        $str = $request->grades_long;
        $separates = explode(' ',$str);
   
        
        //count the number of student to the number of grade input
        if(count($request->inputs) != count($separates)){
            return redirect()->back()->with('alert', 'The number of students must match the number of grade inputs!');
        }else{
            if($open->grading_id == '1'){
                foreach($request->inputs as $key => $value){
                        $grades = Grade::where('sg_id', $value)->first();
                        $grades->frst_grade = $separates[$c];
                        $grades->view_status = 0;
                        $grades->update();
                        $c++;
                }
            }
            elseif($open->grading_id == '2'){
                foreach($request->inputs as $key => $value){
                        $grades = Grade::where('sg_id', $value)->first();
                        $grades->scnd_grade = $separates[$c];
                        $grades->view_status = 0;
                        $grades->update();
                        $c++;
                }
            }
            elseif($open->grading_id == '3'){
                foreach($request->inputs as $key => $value){
                        $grades = Grade::where('sg_id', $value)->first();
                        $grades->thrd_grade = $separates[$c];
                        $grades->view_status = 0;
                        $grades->update();
                        $c++;
                }
            }
            elseif($open->grading_id == '4'){
                foreach($request->inputs as $key => $value){
                        $grades = Grade::where('sg_id', $value)->first();
                        $grades->frth_grade = $separates[$c];
                        $grades->view_status = 0;
                        $grades->update();
                        $c++;
                }
            }
            return redirect()->back()->with('message', 'Successfully Uploaded');
        }
        
    }

    public function teacherViewGrades(Request $request){
        // dd($request);
        $studId = $request->student_id;
        DB::statement("SET SQL_MODE=''");
        $mygrades = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                        ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                        ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                        ->join('sections', 'sections.section_id', '=', 'schedules.sect_id') 
                        ->where('stud_id', $studId)
                        ->where('year_id', $request->selectedYear)
                        ->where('semester', $request->semester)
                        ->get();
        $gradelvl = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
        ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
        ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
        ->join('sections', 'sections.section_id', '=', 'schedules.sect_id') 
        ->where('stud_id', $studId)
        ->where('year_id', $request->selectedYear)->groupby('subject_grade_lvl')->first();
        // dd($gradelvl);
        $student = User::where('id', $studId)->get();
        $mystud = User::where('id', $studId)->first();
        $currentYear = SchoolYear::where('is_current', '1')->first();
    
        $selectedSy = SchoolYear::where('sy_id', $request->select_year)->get();   
        return view('teacher.view-grades', compact('mygrades', 'selectedSy', 'studId', 'student', 'gradelvl')); 
    }

    public function promoteStudent($id, $gl){
        if($gl == '1st'){
            $student = StudentDetail::where('id', $id)->first();
            $student->enrollment_status = '0';
            $student->save();    
        }else{
            $student = StudentDetail::where('id', $id)->first();
            $student->grade_lvl = $student->grade_lvl+1;
            $student->enrollment_status = '0';
            $student->save();
        }
        // return redirect()->back()->with('message', 'Successfully Promoted');
    }

    public function demoteStudent($id){
        $student = StudentDetail::where('id', $id)->first();
        $student->grade_lvl = $student->grade_lvl-1;
        $student->update();
        // return redirect()->back()->with('message', 'Successfully Demoted');
    }

    public function retainStudent($id){
        $student = StudentDetail::where('id', $id)->first();
        $student->enrollment_status = '0';
        $student->update();
        // return redirect()->back()->with('message', 'Successfully Demoted');
    }





}
