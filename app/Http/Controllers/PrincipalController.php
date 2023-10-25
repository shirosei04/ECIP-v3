<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
//requests
use App\Http\Requests\AwardFormRequest;
use App\Http\Requests\FeeFormRequest;
use App\Http\Requests\SubjectFormRequest;
use App\Http\Requests\AnnouncementFormRequest;
use App\Http\Requests\EditUserFormRequest;
use App\Http\Requests\ScheduleFormRequest;
use App\Http\Requests\SyFormRequest;
use App\Http\Requests\Auth\RegistrationFormRequest;
//models
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
use App\Models\Adviser;
use App\Models\Grade;
use App\Models\Grading;
use App\Models\Semester;

use App\Mail\DeleteMail;
use App\Mail\ResetMail;

use Barryvdh\DomPDF\Facade\Pdf;
use File;
use DB;

class PrincipalController extends Controller
{
    public function dashboard(){
        DB::statement("SET SQL_MODE=''");
        $students = Grade::groupby('stud_id')->get();
        dd($students);
        return view('principal.dashboard');
    }

    public function awardIndex(){
        $awards = Award::orderBy('award_name', 'asc')->paginate(12);
        return view('principal.award-index', compact('awards'));
    }

    public function editFee(FeeFormRequest $request, $tf_id){
        
         $data = $request->validated();
         $fee = Tuition::find($tf_id);
         $fee->for_grade_lvl = $data['for_grade_lvl'];
         $fee->tuition_fee = $data['tuition_fee'];
         $fee->misc_fee = $data['misc_fee'];
         $fee->update();
         return redirect('/tuition-fees')->with('message', 'Grade Level Fee Successfully Edited');
    }

    public function awardeesIndex(){
        $awardees = StudentAward::join('users', 'users.id', '=', 'student_awards.id')
                                ->join('awards', 'awards.award_id', '=', 'student_awards.awardId')->paginate(12);
        $awards = Award::all();
        $search_text = "";
        return view('principal.awardees-index', compact('awardees','awards', 'search_text'));
        // orderBy('award_name', 'asc')
    }

    public function principalAnnouncements(){
        $announcements = Announcement::join('users', 'users.id', '=', 'announcements.id')
                                ->orderBy('announcements.created_at', 'desc')->get();
        return view('announcements', compact('announcements'));
    }

    public function saveAward(AwardFormRequest $request){
        $data = $request->validated();
        $award = new Award;
        $award->award_name = $data['award_name'];
        $award->award_desc = $data['award_desc'];
        $award->save();
        return redirect('/awards')->with('message', 'Award Successfully Added');
    }

    public function editAward(AwardFormRequest $request, $award_id){
        $data = $request->validated();
        $award = Award::find($award_id);
        $award->award_name = $data['award_name'];
        $award->award_desc = $data['award_desc'];
        $award->update();
        return redirect('/awards')->with('message', 'Award Successfully Edited');
    }

    public function searchAward()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/awards');
       }else{
        $awards = Award::where('award_name', 'LIKE', '%'.$search_text.'%')->paginate(10)->withQueryString();
            if(count($awards) == 0){
                return redirect('/awards')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                return view('principal.award-index', compact('awards', 'search_text'));
            }
        }
    }

    public function searchAwardee()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/awardees');
       }else{
        $awardees = StudentAward::join('users', 'users.id', '=', 'student_awards.id')->join('awards', 'awards.award_id', '=', 'student_awards.awardId')->where('first_name', 'LIKE', '%'.$search_text.'%')->orwhere('last_name', 'LIKE', '%'.$search_text.'%')->orwhere('award_name', 'LIKE', '%'.$search_text.'%')->paginate(10)->withQueryString();
            if(count($awardees) == 0){
                return redirect('/awardees')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                return view('principal.awardees-index', compact('awardees', 'search_text'));
            }
        }
    }

    public function editAwardee(Request $request, $awardee_id){
        // $data = $request->validated();
        $awardee = StudentAward::find($awardee_id);
        $awardee->id = $request->id;
        $awardee->awardId = $request->award;
        $awardee->grade_lvl = $request->grade_lvl;
        $awardee->date_awarded = $request->date_awarded;
        $awardee->update();
        return redirect('/awardees')->with('message', 'Award Successfully Edited');
    }

    public function deleteAward($award_id){
        $award = Award::findOrFail($award_id);
        $award->delete();
        
    }

    public function deleteAwardee($awardee_id){
        $awardee = StudentAward::where('id', '=', $awardee_id);
        // $awardee = StudentAward::find($awardee_id);
        $awardee->delete();
        // return response()->json(['status', 'Subject Deleted Successfully']);
    }

    public function studentList(){
        $users = User::join('student_details', 'student_details.id', '=', 'users.id')
                        ->where('role', '=', 'Student')
                        ->where('is_verified', '=', '1')
                        ->where('status', '=', '1')
                        ->orderby('grade_lvl')
                        ->orderby('last_name')
                        ->paginate(18);
        $awards = Award::orderby('award_name', 'asc')->get();
        $gradefilter = "nofilter";
        return view('principal.student-list', compact('users', 'awards', 'gradefilter'));
        // return response()->json(['status', 'Subject Deleted Successfully']);
    }

    public function teacherList(){
       $users = User::where('role', '=', 'Teacher')
                ->where('status', '=', '1')->get();
       return view('principal.teacher-list', compact('users'));
       
    }

    public function aoList(){
        $users = User::where('role', '=', 'Admission Officer')
                    ->where('status', '=', '1')->get();
        $search_text = "";
        return view('principal.ao-list', compact('users', 'search_text'));
      
    }

    public function searchAo()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/ao-list');
       }else{
        $users = User::where('role', 'Admission Officer')->where('first_name', 'LIKE', '%'.$search_text.'%')->orwhere('last_name', 'LIKE', '%'.$search_text.'%')->paginate(10)->withQueryString();
            if(count($users) == 0){
                return redirect('/ao-list')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                return view('principal.ao-list', compact('users', 'search_text'));
            }
        }
    }

    public function principalList(){
        $users = User::where('role', '=', 'Principal')
                 ->where('status', '=', '1')->get();
        return view('principal.principal-list', compact('users'));
    }

    public function searchPrincipal()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/ao-list');
       }else{
        $users = User::where('role', 'Principal')->where('first_name', 'LIKE', '%'.$search_text.'%')->orwhere('last_name', 'LIKE', '%'.$search_text.'%')->paginate(10)->withQueryString();
            if(count($users) == 0){
                return redirect('/principal-list')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                return view('principal.principal-list', compact('users', 'search_text'));
            }
        }
    }

    public function filter_students(Request $request)
    {
        if ($request->grade_filter == 'nofilter' | $request->grade_filter == 'reset' ){
            // $enrollees = User::where('is_verified', '=', '0')
            //                 ->where('role', '=', 'Student')
            //                 ->where('status', '=', '1')
            //                 ->orderBy('date_of_registration', 'asc')->paginate(10);
            // return view('ao.verify-register', compact('enrollees'));
            return redirect('/student-list');
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
            $awards = Award::all();
                    return view('principal.student-list', compact('users', 'gradefilter', 'awards'));
        }
    }

    public function searchStudent()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/student-list');
       }else{
        $users = User::where('role', 'Student')->where('first_name', 'LIKE', '%'.$search_text.'%')->orwhere('last_name', 'LIKE', '%'.$search_text.'%')->paginate(10)->withQueryString();
            if(count($users) == 0){
                return redirect('/student-list')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                $awards = Award::orderby('award_name', 'asc')->get();
                $gradefilter = "";
                return view('principal.student-list', compact('users', 'search_text', 'gradefilter', 'awards'));
            }
        }
    }

    public function searchTeacher()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/teacher-list');
       }else{
        $users = User::where('role', 'Teacher')->where('first_name', 'LIKE', '%'.$search_text.'%')->orwhere('last_name', 'LIKE', '%'.$search_text.'%')->paginate(10)->withQueryString();
            if(count($users) == 0){
                return redirect('/teacher-list')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                return view('principal.teacher-list', compact('users', 'search_text'));
            }
        }
    }

    
    public function searchArchived()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/archived-list');
       }else{
        $users = User::where('status', '0')->where('first_name', 'LIKE', '%'.$search_text.'%')->orwhere('last_name', 'LIKE', '%'.$search_text.'%')->paginate(10)->withQueryString();
            if(count($users) == 0){
                return redirect('/archived-list')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                return view('principal.archived-list', compact('users', 'search_text'));
            }
        }
    }

    public function filter_role(Request $request)
    {
        // dd($request->filter_role);
        if ($request->filter_role == 'nofilter' | $request->filter_role == 'reset' ){
            // $enrollees = User::where('is_verified', '=', '0')
            //                 ->where('role', '=', 'Student')
            //                 ->where('status', '=', '1')
            //                 ->orderBy('date_of_registration', 'asc')->paginate(10);
            // return view('ao.verify-register', compact('enrollees'));
            return redirect('/archived-list');
        }
        else
        {
            $users = User::orderBy('last_name', 'asc')
                            ->where('status', '=', '0')
                            ->when($request->filter_role != null, function ($q) use ($request) {
                            return $q->where('role', $request->filter_role);
                    })->paginate(10);
            $gradefilter = $request->filter_role;
                    return view('principal.archived-list', compact('users', 'gradefilter'));
                    //dd($enrollees, $gradefilter);
        }
    }

    public function giveAward(Request $request){
        $studentaward = new StudentAward;
        $studentaward->id = $request->id;
        $studentaward->awardId = $request->award;
        $studentaward->grade_lvl = $request->grade_lvl;
        $studentaward->date_awarded = $request->date_awarded;
        $studentaward->save();
        return redirect('/student-list')->with('message', 'Award Successfully Given');
        // return response()->json(['status', 'Subject Deleted Successfully']);
    }

    // public function announcements(){
    //     $announcements = Announcement::join('users', 'users.id', '=', 'announcements.id')
    //                             ->orderBy('announcements.created_at', 'desc')->get();
    //     return view('principal.announcements', compact('announcements'));
    // }

    public function saveAnnouncement(AnnouncementFormRequest $request){
        $requestData = $request->validated();
        if( $request->announcement_img != null){
            $fileName = time().$request->file('announcement_img')->getClientOriginalName();
            $path = $request->file('announcement_img')->storeAs('img', $fileName, 'public');
            $requestData["announcement_img"] = '/storage/'.$path;
        }

        Announcement::create($requestData);
        return redirect('/announcements');
        // dd($requestData);
    }

    public function editAnnouncement(AnnouncementFormRequest $request, $announcement_id){
        $requestData = $request->validated();

        $anounce = Announcement::find($announcement_id);
        $anounce->id = $requestData['id'];
        $anounce->announcement_title = $requestData['announcement_title'];
        $anounce->announcement_content = $requestData['announcement_content'];
        if( $request->new_announcement_img != null){
            //prepare img for saving in DB
            $fileName = time().$request->file('new_announcement_img')->getClientOriginalName();
            $path = $request->file('new_announcement_img')->storeAs('img', $fileName, 'public');
            $requestData["new_announcement_img"] = '/storage/'.$path;
            //delete old img
            $oldImage = $anounce->announcement_img;
            $oldImagePath = public_path($oldImage);
            if(File::exists($oldImagePath)){
                File::delete($oldImagePath);
            }
            //set new img as new announcement img
            $anounce->announcement_img = $requestData['new_announcement_img'];
        }
        $anounce->update();
        
        return redirect('/announcements');
     
    }

    public function deleteAnnouncement($announcement_id){
        $announcement = Announcement::find($announcement_id);
        $announcement->delete();
        //delete announcement image from storage after deleting the announcement
        if( $announcement->announcement_img != null){
            $oldImage = $announcement->announcement_img;
            $oldImagePath = public_path($oldImage);
            if(File::exists($oldImagePath)){
                File::delete($oldImagePath);
            }
        }

    }

    public function editUser(Request $request){
        // dd($user_id);
        // $data = $request->validated();
        //basic info
        $user = User::find($request->user_id);
        $user->role =  $request->role;
        $user->sex = $request->sex;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->suffix = $request->suffix;
        $user->birth_date = $request->bdate;
        $user->birth_place = $request->bplace;
        $user->province = $request->province;
        $user->region = $request->region;
        $user->city = $request->city;
        $user->barangay = $request->barangay;
        $user->house_no = $request->street;
        $user->nationality = $request->nationality;
        $user->religion = $request->religion;
        $user->ethnicity = $request->ethnicity;
        $user->mother_tongue = $request->mother_tongue;
        $user->tel_no = $request->tel_no;
        $user->cell_no = $request->cell_no;
        $user->email = $request->email;
        $user->fb_acc = $request->fb_acc;
        $user->update();

        //student info
        if($user->role == 'Student'){
            $userStudentInfo = StudentDetail::find($request->detail_id);
            $userStudentInfo->lrn = $request->lrn;
            $userStudentInfo->grade_lvl = $request->grade_lvl;
            $userStudentInfo->hgfrl = $request->hgfrl;
            $userStudentInfo->past_school = $request->past_school;
            $userStudentInfo->past_school_address = $request->past_school_add;
            $userStudentInfo->past_school_id = $request->past_school_id;
            $userStudentInfo->has_comorbidity = $request->has_comorbidity;
            $userStudentInfo->illnesses = $request->illnesses;
            $userStudentInfo->vaccine_status = $request->vaccine_status;
            $userStudentInfo->mogts = $request->mogts;
            $userStudentInfo->is_madrasah_enrolled = $request->is_madrasah_enrolled;
            $userStudentInfo->is_4ps_member = $request->is_4ps_member;
            $userStudentInfo->update();

            //parent info
            foreach($request->inputs as $key => $value){
            $userParentInfo = ParentGuardian::find($value['parent_id']);
            $userParentInfo->first_name = $value['first_name'];
            $userParentInfo->middle_name = $value['middle_name'];
            $userParentInfo->last_name = $value['last_name'];
            $userParentInfo->suffix = $value['suffix'];
            $userParentInfo->relationship = $value['relationship'];
            $userParentInfo->occupation = $value['occupation'];
            $userParentInfo->contact_no = $value['contact_no'];
            $userParentInfo->email = $value['email'];
            $userParentInfo->fb_account = $value['fb_account'];
            $userParentInfo->update();
            }
        }
        return back()->with('message', 'User Successfully Edited');
            // alert('bruh');
       
    }

    public function addUser(RegistrationFormRequest $request){
        $data = $request->validated();
        $user = User::create([
            'role' => $data['role'],
            'is_verified' => 1,
            'date_of_registration' => now()->toDateString('Y-m-d'),
            'sex' => $data['sex'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'suffix' => $data['suffix'],
            'birth_date' => $data['bdate'],
            'birth_place' => $data['bplace'],
            'region' => $data['region'],
            'province' => $data['province'],
            'city' => $data['city'],
            'barangay' => $data['barangay'],
            'house_no' => $data['street'],
            'nationality' => $data['nationality'],
            'religion' => $data['religion'],
            'ethnicity' => $data['ethnicity'],
            'mother_tongue' => $data['mother_tongue'],
            'tel_no' => $data['tel_no'],
            'cell_no' => $data['cell_no'],
            'email' => $data['email'],
            'fb_acc' => $data['fb_acc'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
        return back()->with('message', 'User Successfully Added');
    }

    public function archivedList(){
        $users = User::where('status', '=', '0')
                         ->orderBy('date_of_registration', 'asc')->get();
                         $gradefilter = "nofilter";
        return view('principal.archived-list', compact('users', 'gradefilter'));
    }

    public function viewArchivedUser($id){
        $enrollee = User::find($id);
        return view('principal.view-archived', compact('enrollee'));
    }

    public function unarchiveUser($id){
        $user = User::find($id);
        $user->status = '1';
        // $user->student->date_of_registration = Carbon\Carbon::now();

        $user->update();
    }

    public function principalDeleteUser($id){
        // dd($id);
        $deleted = User::find($id);
        $deleted->delete();

        $email = $deleted->email;
        $mail = new DeleteMail;
        Mail::to($email)->send($mail);
    }

    public function principal_filter_archived(Request $request)
    {
        if ($request->grade_filter == 'nofilter' | $request->grade_filter == 'reset' ){
            // $enrollees = User::where('is_verified', '=', '0')
            //                 ->where('role', '=', 'Student')
            //                 ->where('status', '=', '1')
            //                 ->orderBy('date_of_registration', 'asc')->paginate(10);
            // return view('ao.verify-register', compact('enrollees'));
            return redirect('/archived-list');
        }
        else
        {
            $users = User::join('student_details', 'student_details.id', '=', 'users.id')
                    ->where('status', '=', '0')
                    ->orderBy('date_of_registration', 'asc')
                    ->when($request->grade_filter != null, function ($q) use ($request) {
                            return $q->where('grade_lvl', $request->grade_filter);
                    })->paginate(10);
            $gradefilter = $request->grade_filter;
                    return view('principal.archived-list', compact('users', 'gradefilter'));
        }
    }

    public function principalArchiveUser($id){
        $user = User::find($id);
        $user->status = '0';
        $user->update();
    }

    public function resetPassword($id){
        $reset = User::find($id);
        $resetpass = Hash::make('1');
        $reset->password = $resetpass;
        $reset->update();

        //automatically send an email to notify the user
        $email =  $reset->email;
        $mail = new ResetMail;
        Mail::to($email)->send($mail);
    }

    //school year
    public function syIndex(){
        $years = SchoolYear::orderBy('is_current', 'desc')->orderBy('school_year', 'asc')->paginate(12);
        $semesters = Semester::all();
        return view('principal.schedules.school-years', compact('years', 'semesters'));
    }

    public function saveSy(SyFormRequest $request){
        $data = $request->validated();
        //check if sy already exist
        $ifExist = SchoolYear::where('school_year', $data['school_year'])->where('type', $data['type'])->get();
        if(count($ifExist) == 0){
            $year = new SchoolYear;
            $year->school_year = $data['school_year'];
            $year->type = $data['type'];
            $year->save();
        }else{
            return redirect('/school-year')->with('alert', 'School Year Already Exists!');
        }
        return redirect('/school-year')->with('message', 'School Year Successfully Added');
    }

    public function editSy(SyFormRequest $request, $sy_id){
        $data = $request->validated();
        $year = SchoolYear::find($sy_id);
        $year->school_year = $data['school_year'];
        $year->type = $data['type'];
        $year->update();
        return redirect('/school-year')->with('message', 'School Year Successfully Edited');
    }

    public function deleteSy($sy_id){
        $year = SchoolYear::find($sy_id);
        $year->delete();
    }

    public function setCurrentSy($sy_id){
        //set all the other years as not current
        SchoolYear::where('is_current', '=', '1')->update(['is_current' => 0]);
        //find if the enrollment is open
        SchoolYear::where('enrollment', '=', '1')->update(['enrollment' => 0]);
        // if(count($open) > 0){
        //     return redirect('school-year')->with('alert', 'Please close the current enrollment first!');
        // } 
        //set selected year as current
        $year = SchoolYear::find($sy_id);
        $year->is_current = '1';
        $year->update();
    }

    public function setNotCurrentSy($sy_id){
        //set selected year as not current
        $year = SchoolYear::find($sy_id);
        $year->is_current = '0';
        $year->update();
    }

    public function openEnroll($sy_id){
        //set selected year as open enrollment
        $year = SchoolYear::find($sy_id);
        $year->enrollment = '1';
        $year->update();
    }

    public function closeEnroll($sy_id){
        //set selected year as closed enrollment
        $year = SchoolYear::find($sy_id);
        $year->enrollment = '0';
        $year->update();
    }
    public function searchSy()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/school-year');
       }else{
        $semesters = Semester::all();
        $years = SchoolYear::where('school_year', 'LIKE', '%'.$search_text.'%')->paginate(12)->withQueryString();
            if(count($years) == 0){
                return redirect('/school-year')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                return view('principal.schedules.school-years', compact('years', 'search_text', 'semesters'));
            }
        }
    }

     //tuition fee
    public function tuitionIndex(){
        $fees = Tuition::all();
        return view('principal.schedules.tuition-fees', compact('fees'));
    }

    public function saveFee(FeeFormRequest $request){
        $data = $request->validated();
        $year = Tuition::create($data);
        return redirect('/tuition-fees')->with('message', 'Grade Level Fee Successfully Added');
    }

    
    public function deleteFee($tf_id){
        $fee = Tuition::find($tf_id);
        $fee->delete();
    }

     //curriculums
    public function curriculumsIndex(){
        $curs = Curriculum::orderBy('curriculum')->paginate(12);
        return view('principal.schedules.curriculums', compact('curs'));
    }

    public function saveCurriculum(Request $request){
        $data = $request->validate([
            'curriculum' => 'required|unique:curriculums',
        ], [
            'curriculum.unique' => 'Curriculum already exists!'
        ]);
        $year = Curriculum::create($data);
        return redirect('/curriculums')->with('message', 'Curriculum Successfully Added');
    }

    public function editCurriculum(Request $request, $cur_id){
        $data = $request->validate([
            'curriculum' => 'required',
        ]);
        $cur = Curriculum::find($cur_id);
        $cur->curriculum = $data['curriculum'];
        $cur->update();
        return redirect('/curriculums')->with('message', 'Curriculum Successfully Edited');
    }

    public function deleteCurriculum($cur_id){
        $fee = Curriculum::find($cur_id);
        $fee->delete();
    }

    public function searchCurriculum()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/curriculums');
       }else{
        $curs = Curriculum::where('curriculum', 'LIKE', '%'.$search_text.'%')->paginate(12)->withQueryString();
            if(count($curs) == 0){
                return redirect('/curriculums')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                return view('principal.schedules.curriculums', compact('curs', 'search_text'));
            }
        }
    }

    //rooms
     public function roomsIndex(){
        $rooms = Room::orderBy('room_number')->paginate(12);
        return view('principal.schedules.rooms', compact('rooms'));
    }

    public function saveRoom(Request $request){
        $data = $request->validate([
            'room_number' => 'required|unique:rooms',
            'room_type' => 'required'
        ],[
            'room_number.unique' => 'Room already exists!'
        ]);
        $year = Room::create($data);
        return redirect('/rooms')->with('message', 'Room Successfully Added');
    }

    public function editRoom(Request $request, $room_id){
        $data = $request->validate([
            'room_number' => 'required',
            'room_type' => 'required'
        ]);
        $room = Room::find($room_id);
        $room->room_number = $data['room_number'];
        $room->room_type = $data['room_type'];
        $room->update();
        return redirect('/rooms')->with('message', 'Room Successfully Edited');
    }

    public function deleteRoom($room_id){
        $fee = Room::find($room_id);
        $fee->delete();
    }

    public function searchRoom()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/rooms');
       }else{
        $rooms = Room::where('room_number', 'LIKE', '%'.$search_text.'%')->paginate(12)->withQueryString();
            if(count($rooms) == 0){
                return redirect('/rooms')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                return view('principal.schedules.rooms', compact('rooms', 'search_text'));
            }
        }
    }

    //sections
     public function sectionsIndex(){
        $sections = Section::orderBy('section_name', 'asc')->paginate(12);
        return view('principal.schedules.sections', compact('sections'));
    }

    public function saveSection(Request $request){
        $data = $request->validate([
            'section_grade_lvl' => 'required',
            'section_name' => 'required|unique:sections',
            'capacity' => 'required'
        ],[
            'section_name.unique' => 'Section already exists!'
        ]);
        $section = Section::create($data);
        return redirect('/sections')->with('message', 'Section Successfully Added');
    }

    public function editSection(Request $request, $section_id){
        $data = $request->validate([
            'section_grade_lvl' => 'required',
            'section_name' => 'required',
            'capacity' => 'required'
        ]);
        $section = Section::find($section_id);
        $section->section_grade_lvl = $data['section_grade_lvl'];
        $section->section_name = $data['section_name'];
        $section->capacity = $data['capacity'];
        $section->update();
        return redirect('/sections')->with('message', 'Section Successfully Edited');
    }

    public function deleteSection($section_id){
        $section = Section::find($section_id);
        $section->delete();
    }

    public function searchSection()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/sections');
       }else{
        $sections = Section::where('section_name', 'LIKE', '%'.$search_text.'%')->orWhere('section_grade_lvl', 'LIKE', '%'.$search_text.'%')->orderby('section_grade_lvl')->paginate(12)->withQueryString();
            if(count($sections) == 0){
                return redirect('/sections')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                return view('principal.schedules.sections', compact('sections', 'search_text'));
            }
        }
    }

    //subjects
    public function subjectsIndex(){
        $subjects = Subject::join('curriculums', 'curriculums.curriculum_id', '=', 'subjects.curriculumId')
                            ->orderBy('curriculum')->orderBy('subject_grade_lvl')->orderBy('subject_name')->paginate(15);
        $curriculums = Curriculum::orderBy('curriculum', 'asc')->get();
        $gradefilter = "";
        $curriculumfilter = "";
        $trackfilter = "";
        return view('principal.schedules.subjects', compact('subjects', 'curriculums', 'curriculumfilter', 'trackfilter', 'gradefilter'));
    }

    public function saveSubject(SubjectFormRequest $request){
        $data = $request->validated();
        // $section = Subject::create($data);
        $searchsubject = Subject::where('subject_name', $data['subject_name'])->where('curriculumId',  $data['curriculumId'])->where('subject_grade_lvl', $data['subject_grade_lvl'])->get();
        $searchresult = count($searchsubject);
        if($searchresult == 0){
             $section = Subject::create($data);
        }else{
            return redirect('/subjects')->with('alert', 'Subject already exists. (Subject:' . $data['subject_name'] . ", Curriculum:" . $data['curriculumId'] . ", " . $data['subject_grade_lvl'] . ')' );
        }
        return redirect('/subjects')->with('message', 'Subject Successfully Added');
    }

    public function editSubject(SubjectFormRequest $request, $subject_id){
        $data = $request->validated();
        // $searchsubject = Subject::where('subject_name', $data['subject_name'])->where('curriculumId',  $data['curriculumId'])->where('subject_grade_lvl', $data['subject_grade_lvl'])->get();
        // $searchresult = count($searchsubject);
        // if($searchresult == 0){
            $subject = Subject::find($subject_id);
            $subject->subject_name = $data['subject_name'];
            $subject->subject_grade_lvl = $data['subject_grade_lvl'];
            $subject->curriculumId = $data['curriculumId'];
            $subject->track = $data['track'];
            $subject->update();
    //    }else{
    //        return redirect('/subjects')->with('alert', 'Subject already exists. (Subject:' . $data['subject_name'] . ", Curriculum:" . $data['curriculumId'] . ", " . $data['subject_grade_lvl'] . ')' );
    //    }
        return redirect('/subjects')->with('message', 'Subject Successfully Edited');
    }

    public function deleteSubject($subject_id){
        $subject = Subject::find($subject_id);
        $subject->delete();
    }

    public function searchSubject()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/subjects');
       }else{
        $subjects = Subject::join('curriculums', 'curriculums.curriculum_id', '=', 'subjects.curriculumId')
        ->where('subject_name', 'LIKE', '%'.$search_text.'%')->paginate(12)->withQueryString();
            if(count($subjects) == 0){
                return redirect('/subjects')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                $curriculumfilter = "";
                $trackfilter = "";
                $curriculums = Curriculum::orderBy('curriculum', 'asc')->get();
                $gradefilter = "";
                return view('principal.schedules.subjects', compact('subjects', 'search_text', 'curriculums', 'gradefilter', 'trackfilter', 'curriculumfilter'));
            }
        }
    }

    public function filter_subjects(Request $request)
    {
        if ($request->grade_filter == "" | $request->track_filter == "" | $request->curriculum_filter == ""){
            return redirect('/subjects')->with('alert', 'All filter fields must have some value');
        }
        else
        {
            // dd($request->curriculum_filter);
            $subjects = Subject::join('curriculums', 'curriculums.curriculum_id', '=', 'subjects.curriculumId')
                            ->orderBy('subject_name')
                            ->when($request->grade_filter != null | $request->track_filter != null | $request->curriculum_filter != null , function ($q) use ($request) {
                            return $q->where('subject_grade_lvl', $request->grade_filter)->where('track', $request->track_filter)->where('curriculum', $request->curriculum_filter);
                    })->paginate(18)->withQueryString();
            $curriculums = Curriculum::orderBy('curriculum', 'asc')->get();
            $gradefilter = $request->grade_filter;
            $curriculumfilter = $request->curriculum_filter;
            $trackfilter = $request->track_filter;
                    return view('principal.schedules.subjects', compact('subjects', 'gradefilter', 'curriculums', 'trackfilter', 'curriculumfilter'));
        }
    }

    //schedules
    public function schedulesIndex(){
        $scheds = Schedule::orderby('sect_id', 'asc')->paginate(15);
        $subjects = Subject::orderBy('subject_name')->get();
        $rooms = Room::orderBy('room_number')->get();
        $sections = Section::orderBy('section_name')->get();
        $teachers = User::orderBy('last_name')->where('role', 'Teacher')->get();
        $allsy = SchoolYear::orderby('school_year')->get();
        $syfilter = "";
        $sectionfilter = "";
        $trackfilter = "";
        $semesterfilter = "";
        return view('principal.set-schedules', compact('scheds', 'allsy', 'subjects', 'rooms', 'sections', 'teachers', 'syfilter', 'sectionfilter', 'trackfilter', 'semesterfilter'));
    }

    public function saveSchedule(ScheduleFormRequest $request){
        $data = $request->validated();
        $arrayToString = implode(',', $request->input('days'));
        //check if sched already exists
        $ifexist = Schedule::where('sub_id', $data['sub_id'])
                            ->where('sect_id', $data['sect_id'])
                            ->where('year_id', $data['year_id'])->first();
        //check if sched conflicts
        if(empty($ifexist)){
                $data['days'] = $arrayToString;
                $schedule = new Schedule;
                $schedule->sub_id = $data['sub_id'];
                $schedule->semester = $data['semester'];
                $schedule->days = $data['days'];
                $schedule->time_start = $data['time_start'];
                $schedule->time_end = $data['time_end'];
                $schedule->id = $data['id'];
                $schedule->sect_id = $data['sect_id'];
                $schedule->year_id = $data['year_id'];
                $schedule->room_id = $data['room_id'];
                $schedule->save();
        }else{
            return redirect('/set-schedules')->with('alert', 'Schedule already exists!');
        }
        return redirect('/set-schedules')->with('message', 'Schedule Successfully Added');
    }

    public function editSchedule(ScheduleFormRequest $request, $sched_id){
        // dd($request);
        $data = $request->validated();
        $arrayToString = implode(',', $request->input('days'));
        // check if sched already exists
        // $ifexist = Schedule::where('subject_id', $data['subject_id'])
        //                     ->where('room_id',  $data['room_id'])
        //                     ->where('sy_id', $data['sy_id'])
        //                     ->where('time_start', $data['time_start'])
        //                     ->where('time_end', $data['time_end'])
        //                     ->where('days', $arrayToString)->get();
        // $ifExistResult = count($ifexist);
        // if($ifExistResult == 0){
            // if($ifConflictResult == 0){
                // dd($request);
                $data['days'] = $arrayToString;
                $sched = Schedule::find($sched_id);
                $sched->sub_id = $data['sub_id'];
                $sched->semester = $data['semester'];
                $sched->days = $data['days'];
                $sched->time_start = $data['time_start'];
                $sched->time_end = $data['time_end'];
                $sched->id = $data['id'];
                $sched->sect_id = $data['sect_id'];
                $sched->year_id = $data['year_id'];
                $sched->room_id = $data['room_id'];
                $sched->update();
            // }else{
            //     return redirect('/set-schedules')->with('alert', 'Schedule is in conflict with other subjects!');
            // }
        // }else{
        //     return redirect('/set-schedules')->with('alert', 'Schedule already exists!');
        // }
        return redirect('/set-schedules')->with('message', 'Schedule Successfully Edited');
    }

    public function deleteSched($sched_id){
        $sched = Schedule::find($sched_id);
        $sched->delete();
    }

    public function searchSched()
    {
       $search_text = $_GET['query'];
       if($search_text == null){
        return redirect('/set-schedules');
       }else{
        // $scheds = Schedule::join('users', 'users.id', '=', 'schedules.id')
        // ->join('subjects', 'subjects.subject_id', '=', 'schedules.subject_id')
        // ->join('school_years', 'school_years.sy_id', '=', 'schedules.sy_id') 
        // ->join('sections', 'sections.section_id', '=', 'schedules.section_id') 
        $scheds = Schedule::join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                            ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')
                            ->where('subject_name', 'LIKE', '%'.$search_text.'%')
                            ->orwhere('section_name', 'LIKE', '%'.$search_text.'%')
                            ->orderby('time_start','asc')
                            ->paginate(15)->withQueryString();
            if(count($scheds) == 0){
                return redirect('/set-schedules')->with('alert', 'No results found for "'.$search_text.'" ');
            }else{
                $subjects = Subject::orderBy('subject_name')->get();
                $rooms = Room::orderBy('room_number')->get();
                $sections = Section::orderBy('section_name')->get();
                $teachers = User::orderBy('last_name')->where('role', 'Teacher')->get();
                $syears = SchoolYear::where('is_current', '1')->get();
                $allsy = SchoolYear::orderby('school_year')->get();
                $syfilter = "";
                $sectionfilter = "";
                $trackfilter = "";
                $semesterfilter = "";
                return view('principal.set-schedules', compact('scheds', 'allsy', 'subjects', 'search_text', 'rooms', 'sections', 'teachers', 'syears', 'syfilter', 'sectionfilter', 'trackfilter', 'semesterfilter'));
            }
        }
    }

    public function filter_scheds(Request $request)
    {
        if ($request->section_filter == "" | $request->sy_filter == "" | $request->track_filter == "" | $request->semester_filter == ""){
            return redirect('/set-schedules')->with('alert', 'All filter fields must have some value');
        }
        else
        {
            // dd($request);
            $generals = Schedule::join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                        ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')
                        ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                        ->orderby('time_start','asc')
                        ->where('section_name', $request->section_filter)->where('school_year', $request->sy_filter)->where('semester', $request->semester_filter)->where('track', 'General Subject(SHS)');

            $scheds = Schedule::join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                            ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')
                            ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
                            ->orderby('time_start','asc')
                            ->when($request->section_filter != null | $request->sy_filter != null | $request->track_filter != "", function ($q) use ($request) {
                            return $q->where('section_name', $request->section_filter)->where('school_year', $request->sy_filter)->where('track', $request->track_filter)->where('semester', $request->semester_filter);
                             })->union($generals)->paginate(12)->withQueryString();
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
            return view('principal.set-schedules', compact('subjects', 'syfilter', 'sectionfilter', 'sections', 'rooms', 'teachers', 'syears', 'allsy', 'scheds', 'generals','trackfilter', 'semesterfilter'));
        }
    }

    public function adviserList(){
        $advisers = Adviser::join('sections', 'sections.section_id', '=', 'advisers.tsection_id')
                            ->join('school_years', 'school_years.sy_id', '=', 'advisers.tyear_id')
                            ->join('users', 'users.id', '=', 'advisers.teacher_id')->orderby('adviser_id', 'desc')->paginate(12);
        $teachers = User::where('role', 'Teacher')->get();
        $years = SchoolYear::all();
        $sections = Section::all();
        return view('principal.assign-advisers', compact('advisers', 'teachers', 'years', 'sections'));
    }

    public function saveAdviser(Request $request){
        $check = Adviser::where('teacher_id', $request->teacher_id)->where('tyear_id', $request->tyear_id)->get();
        if(count($check) == 1){
            return redirect('/advisers')->with('alert', 'Advisers cannot have 2 classes assigned to them in the same school year');
        }else{
            Adviser::create([
                'teacher_id' => $request->teacher_id,
                'tyear_id' => $request->tyear_id,
                'tsection_id' => $request->tsection_id
            ]);
            return redirect('/advisers')->with('message', 'Adviser Successfully Assigned');
        }
       
    }

    public function editAdviser(Request $request, $id){
        $adviser = Adviser::find($id);
        $adviser->teacher_id = $request->teacher_id;
        $adviser->tyear_id = $request->tyear_id;
        $adviser->tsection_id = $request->tsection_id;
        $adviser->update();

        return redirect('/advisers')->with('message', 'Adviser Successfully Edited');
    }

    public function deleteAdviser($id){
        $adviser = Adviser::find($id);
        $adviser->delete();
    }

    public function gradesApproval(){
        DB::statement("SET SQL_MODE=''");
        $subjects = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
        ->join('users', 'users.id', '=', 'schedules.id')  
        ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')  
        ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
        ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
        ->where('view_status', '0')
        ->groupby('sub_id')->get();
        $gradings = Grading::all();
        $semesters = Semester::all();
        // ->where('schedules.year_id', $request->select_year)
        // ->where('schedules.id', Auth::user()->id)
        return view('principal.grades-approval', compact('subjects', 'gradings', 'semesters'));
    }

    public function viewGrades($id){
        // dd($id);
        DB::statement("SET SQL_MODE=''");
        $frst = Grading::where('grading', '1')->get();
        $scnd = Grading::where('grading', '2')->get();
        $thrd = Grading::where('grading', '3')->get();
        $frth = Grading::where('grading', '4')->get();
        $students = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
                        ->join('users', 'users.id', '=', 'student_grades.stud_id')
                        ->join('student_details', 'student_details.id', '=', 'users.id')
                        ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                        ->where('view_status', '0')
                        ->where('schedule_id', $id)->orderby('last_name')->get();
        $subject = Schedule::join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
                            ->where('sched_id', $id)->get();
        $gradelvl = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
        ->join('users', 'users.id', '=', 'student_grades.stud_id')
        ->join('student_details', 'student_details.id', '=', 'users.id')
        ->join('subjects', 'subjects.subject_id', '=', 'schedules.sub_id')
        ->where('schedule_id', $id)->orderby('last_name')->groupby('subject_grade_lvl')->first();
        return view('principal.view-grades', compact('students', 'frst', 'scnd', 'thrd', 'frth', 'subject', 'gradelvl'));
    }

    public function releaseGrades(Request $request){
        // dd($request);
        foreach($request->inputs as $key => $value){
           $grade = Grade::find($value);
           $grade->view_status = '1';
           $grade->update();
        }
        return redirect('grades-approval')->with('message', 'Released Successfully');
    }

    public function saveGrading(Request $request){
        $grading = new Grading;
        $grading->grading = $request->grading;
        $grading->save();

        return redirect()->back()->with('message', 'Success');
    }

    public function editGrading(Request $request, $id){
        $grading = Grading::find($id);
        $grading->grading = $request->grading;
        $grading->update();
        
        return redirect()->back()->with('message', 'Edited Successfully');
    }

    public function changeStatus($id){
        //close the opened grading first
        $open = Grading::where('status', '1')->first();
        if(!empty($open)){
            $open->status = '0';
            $open->save();
        }
        //activate new grading
        $grading = Grading::find($id);

        if($grading->status == '0'){
            $grading->status = '1';
        }
        else{
            $grading->status = '0';
        }
        $grading->save();

        return back()->with('message', 'Grading Succesfully Changed!');
        
    }

    public function changeSemStatus($id){
        //close the opened sem first
        $open = Semester::where('sem_status', '1')->first();
        if(!empty($open)){
            $open->sem_status = '0';
            $open->save();
        }
        //activate new sem
        $sem = Semester::find($id);

        if($sem->sem_status == '0'){
            $sem->sem_status = '1';
        }
        else{
            $sem->sem_status = '0';
        }
        $sem->save();

        return back()->with('message', 'Semester Succesfully Changed!');
        
    }

    public function principalClassList(){
        $sections = Section::orderby('section_name', 'asc')->get();
        $students = []; 
        $selSection = "";
        return view('principal.class-list', compact('sections', 'students', 'selSection'));
    }

    public function principalSelectYear(Request $request){
        DB::statement("SET SQL_MODE=''");
        //find the curent year
        $current = SchoolYear::where('is_current', '1')->first();
        $sections = Section::orderby('section_name', 'desc')->get();
        //find out what classes are assigned to logged in teacher
        $students = Grade::join('schedules', 'schedules.sched_id', '=', 'student_grades.schedule_id')
        ->join('sections', 'sections.section_id', '=', 'schedules.sect_id')  
        ->join('users', 'users.id', '=', 'student_grades.stud_id')
        ->join('student_details', 'student_details.id', '=', 'users.id')
        ->join('school_years', 'school_years.sy_id', '=', 'schedules.year_id')
        ->where('year_id', $current->sy_id)
        ->where('sect_id', $request->select_section)->groupby('stud_id')->orderby('sex', 'asc')->orderby('last_name', 'asc')->get();
        //find the adviser of the section
        $adviser = Adviser::join('users', 'users.id', '=', 'advisers.teacher_id')->where('tsection_id', $request->select_section)->where('tyear_id', $current->sy_id)->first();
        $selSection = $request->select_section;
        return view('principal.class-list', compact('students', 'sections', 'selSection', 'adviser'));
       
       
    }

    

    
}
