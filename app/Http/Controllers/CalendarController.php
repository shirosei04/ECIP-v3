<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
class CalendarController extends Controller
{
    public function viewPlotSched(){
        $allsy = SchoolYear::orderby('school_year')->get();
        $sections = Section::orderBy('section_name')->get();
        $scheds = [];
        $syfilter = "";
        $sectionfilter = "";
        $trackfilter = "";
        $semesterfilter = "";
        return view('principal.schedules.view-plotted', compact('allsy', 'sections', 'scheds', 'syfilter', 'trackfilter', 'semesterfilter', 'sectionfilter'));
    }

    public function filter_plot_scheds(Request $request)
    {
        if ($request->section_filter == "" | $request->sy_filter == ""){
            return redirect('/viewplotsched')->with('alert', 'All filter fields must have some value');
        }
        else
        {
            // dd($request);
            $generals = Schedule::join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
            ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')
            ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
            ->orderby('time_start','asc')
            ->where('section_name', $request->section_filter)->where('school_year', $request->sy_filter)->where('track', 'General Subject(SHS)')->where('semester', $request->semester_filter);

            $scheds = Schedule::join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                            ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')
                            ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                            ->orderby('time_start','asc')
                            ->when($request->section_filter != null | $request->sy_filter != null | $request->track_filter != null | $request->semester_filter != null, function ($q) use ($request) {
                            return $q->where('section_name', $request->section_filter)->where('school_year', $request->sy_filter)->where('track', $request->track_filter)->where('semester', $request->semester_filter);
                             })->union($generals)->get();
            $subjects = Subject::orderBy('subject_name')->get();
            $rooms = Room::orderBy('room_number')->get();
            $sections = Section::orderBy('section_name')->get();
            $teachers = User::orderBy('last_name')->where('role', 'Teacher')->get();
            $syears = SchoolYear::where('is_current', '1')->get();
            $allsy = SchoolYear::orderby('school_year')->get();
            $syfilter = $request->sy_filter;
            $sectionfilter = $request->section_filter;
            $trackfilter = $request->track_filter;
            $semesterfilter = $request->semester_filter;
            return view('principal.schedules.view-plotted', compact('subjects', 'syfilter', 'sectionfilter', 'sections', 'rooms', 'teachers', 'syears', 'allsy', 'scheds', 'trackfilter', 'semesterfilter'));
            
        }
    }
}
