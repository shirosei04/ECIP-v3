<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

use App\Models\Award;
use App\Models\User;
use App\Models\StudentDetail;
use App\Models\StudentAward;
use App\Models\StudentAssessment;
use App\Models\ParentGuardian;
use App\Models\Announcement;
use App\Models\SchoolYear;
use App\Models\Tuition;
use App\Models\Curriculum;
use App\Models\Room;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Schedule;
use App\Models\Adviser;
use App\Models\Grade;
use App\Models\Grading;

use App\Mail\DeleteMail;
use App\Mail\ResetMail;

use Barryvdh\DomPDF\Facade\Pdf;
use File;
use DB;

class ReportController extends Controller
{
    public function scheduleReport(Request $request){
        // dd($request);
        $generals = [];
        $year;
        $glvl;
        $section;
        foreach($request->id as $key => $value){
            $general = Schedule::join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
            ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')
            ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
            ->where('sched_id', $value)
            ->orderby('time_start', 'asc')->first();
            $year = $general->school_year;
            $glvl = $general->subject_grade_lvl;
            $section = $general->section_name;
            array_push($generals, $general);
        }

        
        $pdf = Pdf::loadView('reports.schedule-report', compact('generals', 'year', 'glvl', 'section'))->setPaper('a4', 'landscape');
        $pdf->set_base_path("public/css/bootstrap.min.css");
        return $pdf->stream("sched.pdf");
    }

    public function assessmentReport(Request $request){
        
        $assessment = StudentAssessment::join('school_years', 'school_years.sy_id', '=', 'student_fees.year_id')->where('studfee_id',  $request->id)->get();
        $assessmentS = StudentAssessment::join('school_years', 'school_years.sy_id', '=', 'student_fees.year_id')->where('studfee_id',  $request->id)->first();
        $allFees = StudentAssessment::where('student_id', $assessmentS->student_id)->sum('running_balance');
        // $otherBal = intval($allFees->running_balance - $assessment->running_balance);
        $pdf = Pdf::loadView('reports.assessment-report', compact('assessment', 'allFees'))->setPaper('a4', 'portrait');
        $pdf->set_base_path("public/css/bootstrap.min.css");
        return $pdf->stream();

    }

    public function gradeReport(Request $request){
        // dd($request);
        DB::statement("SET SQL_MODE=''");
        $grades = [];
        foreach($request->id as $key => $value){
            $grade = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
            ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
            ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')
            ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
            ->where('sg_id', $value)->first();
            array_push($grades, $grade);

            $gradelvl = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
            ->join('users', 'users.id', '=', 'student_grades.stud_id')
            ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
            ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
            ->where('sg_id', $value)->groupby('subject_grade_lvl')->first();
        }
    
        $average = $request->average;
        $pdf = Pdf::loadView('reports.grade-report', compact('grades', 'gradelvl', 'average'))->setPaper('a4', 'landscape');
        //  $pdf->set_base_path("public/css/bootstrap.min.css");
        return $pdf->stream();
    }

    public function classReport(Request $request){
        DB::statement("SET SQL_MODE=''");
        //find the curent year
        $students = [];
        //find out what classes are assigned to logged in teacher
        foreach($request->id as $key => $value){
            $student = User::where('id', $value )->first();
            array_push($students, $student);
        }

        $pdf = Pdf::loadView('reports.class-report', compact('students'))->setPaper('a4', 'portrait');
        //  $pdf->set_base_path("public/css/bootstrap.min.css");
        return $pdf->stream();
    }
}
