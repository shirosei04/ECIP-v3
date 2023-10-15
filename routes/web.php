<?php
// Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(['middleware' => 'prevent-back-history'],function(){
    Route::get('/', [GeneralController::class, 'index'])->name('index');
    
    //students routes
    Route::group(['middleware' => ['auth', 'role:Student']], function() {
        Route::get('enrollment', [StudentController::class, 'enrollment']);
        Route::get('select-section', [StudentController::class, 'selectSection']);
        Route::post('enroll-student', [StudentController::class, 'enrollStudent']);
        Route::post('select-subject', [StudentController::class, 'selectSubject']);
        Route::get('grades', [StudentController::class, 'grades']);
        Route::get('filtered-grades', [StudentController::class, 'filtered_grades']);
        Route::get('assessment', [StudentController::class, 'assessment']);

    });

    Route::group(['middleware' => ['auth', 'role:Teacher']], function() {
        Route::get('teacher-schedule', [TeacherController::class, 'teacherSchedule']);
        Route::get('class-list', [TeacherController::class, 'classList']);
        Route::get('select-year', [TeacherController::class, 'selectYear']);
        Route::get('handled-subjects', [TeacherController::class, 'handledSubjects']);
        Route::get('subject-select-year', [TeacherController::class, 'subjectsSelectYear']);
        Route::get('view-students/{id}', [TeacherController::class, 'viewSubjectStudents']);
        Route::post('post-grades', [TeacherController::class, 'postGrades']);
        Route::post('bulk-post-grades', [TeacherController::class, 'bulkPostGrades']);
        Route::post('teacher-view-grades', [TeacherController::class, 'teacherViewGrades']);
        Route::post('promote-student/{id}/{gl}', [TeacherController::class, 'promoteStudent']);
        Route::get('demote-student/{id}', [TeacherController::class, 'demoteStudent']);
        Route::get('retain-student/{id}', [TeacherController::class, 'retainStudent']);
    });

    Route::group(['middleware' => ['auth', 'role:Admission Officer']], function() {
        Route::get('registryApproval', [AdmissionController::class, 'registryApproval']);
        Route::get('searchNewEnrollee', [AdmissionController::class, 'searchNewEnrollee']);
        Route::get('filter-enrollees', [AdmissionController::class, 'filter_enrollees']);
        Route::get('archived-users', [AdmissionController::class, 'archivedUsers']);
        Route::get('filter-archived', [AdmissionController::class, 'filter_archived']);
        Route::put('/view-details/accept-user/{id}', [AdmissionController::class, 'approve']);
        Route::post('/view-details/reject-user/{id}', [AdmissionController::class, 'reject']);
        Route::get('view-details/{id}', [AdmissionController::class, 'viewDetails']);
        Route::get('/view-details/archive-user/{id}', [AdmissionController::class, 'archiveUser']);
        Route::get('/view-details/unarchive-user/{id}', [AdmissionController::class, 'unarchiveUser']);
        Route::delete('/view-details/delete-user/{id}', [AdmissionController::class, 'deleteUser']);
        Route::get('ao-student-list', [AdmissionController::class, 'studentList']);
        Route::get('manage-assessment', [AdmissionController::class, 'manageAssessment']);
        Route::put('process-assessment/{id}', [AdmissionController::class, 'processAsessment']);
        Route::get('view-assessment/{id}', [AdmissionController::class, 'viewAssessment']);
        Route::get('ao-filter-students', [AdmissionController::class, 'filter_students']);
        Route::get('aosearchstudent', [AdmissionController::class, 'searchStudent']);
        Route::get('search-archived', [AdmissionController::class, 'searchArchived']);
        Route::get('ao-grades/{id}', [AdmissionController::class, 'grades']);
        Route::get('ao-filtered-grades', [AdmissionController::class, 'filtered_grades']);
        Route::delete('delete-grade/{id}', [AdmissionController::class, 'deleteGrade']);
        Route::post('enroll-new-sub', [AdmissionController::class, 'enrollNewSub']);
        Route::post('transfer-section', [AdmissionController::class, 'transferSection']);

    });

    Route::group(['middleware' => ['auth', 'role:Principal']], function() {
        //awards
        Route::get('awards', [PrincipalController::class, 'awardIndex']);
        Route::get('awardees', [PrincipalController::class, 'awardeesIndex']);
        Route::post('save-award', [PrincipalController::class, 'saveAward']);
        Route::put('edit-award/{award_id}', [PrincipalController::class, 'editAward']);
        Route::delete('delete-award/{award_id}', [PrincipalController::class, 'deleteAward']);
        Route::get('searchaward', [PrincipalController::class, 'searchAward']);
        Route::get('searchawardee', [PrincipalController::class, 'searchAwardee']);
        //awardee
        Route::put('edit-awardee/{awardee_id}', [PrincipalController::class, 'editAwardee']);
        Route::delete('delete-awardee/{awardee_id}', [PrincipalController::class, 'deleteAwardee']);
        Route::post('give-award', [PrincipalController::class, 'giveAward']);
        //user list
        Route::get('student-list', [PrincipalController::class, 'studentList']);
        Route::get('teacher-list', [PrincipalController::class, 'teacherList']);
        Route::get('ao-list', [PrincipalController::class, 'aoList']);
        Route::get('principal-list', [PrincipalController::class, 'principalList']);
        Route::get('filter-students', [PrincipalController::class, 'filter_students']);
        Route::get('archived-filter-role', [PrincipalController::class, 'filter_role']);
        Route::get('archived-list', [PrincipalController::class, 'archivedList']);
        Route::get('view-archived/{id}', [PrincipalController::class, 'viewArchivedUser']);
        Route::get('/view-archived/unarchive-user/{id}', [PrincipalController::class, 'unarchiveUser']);
        Route::delete('/view-archived/delete-user/{id}', [PrincipalController::class, 'principalDeleteUser']);
        Route::get('principal-filter-archived', [PrincipalController::class, 'principal_filter_archived']);
        Route::get('/principal-archive-user/{id}', [PrincipalController::class, 'principalArchiveUser']);
        Route::put('/reset-password/{id}', [PrincipalController::class, 'resetPassword']);
        Route::get('searchao', [PrincipalController::class, 'searchAo']);
        Route::get('searchprincipal', [PrincipalController::class, 'searchPrincipal']);
        Route::get('searchstudent', [PrincipalController::class, 'searchStudent']);
        Route::get('searchteacher', [PrincipalController::class, 'searchTeacher']);
        Route::get('searcharchived', [PrincipalController::class, 'searchArchived']);
        //announcements
        Route::get('announcements', [PrincipalController::class, 'principalAnnouncements']);
        Route::post('save-announcement', [PrincipalController::class, 'saveAnnouncement']);
        Route::put('edit-announcement/{announcement_id}', [PrincipalController::class, 'editAnnouncement']);
        Route::delete('delete-announcement/{announcement_id}', [PrincipalController::class, 'deleteAnnouncement']);
        //edit user profile
        Route::put('edit-user', [PrincipalController::class, 'editUser']);

        // CRUD
        //add new user
        Route::post('add-user', [PrincipalController::class, 'addUser']);
        //school-years
        Route::get('school-year', [PrincipalController::class, 'syIndex']);
        Route::post('save-sy', [PrincipalController::class, 'saveSy']);
        Route::put('edit-sy/{sy_id}', [PrincipalController::class, 'editSy']);
        Route::delete('delete-sy/{sy_id}', [PrincipalController::class, 'deleteSy']);
        Route::get('set-current/{sy_id}', [PrincipalController::class, 'setCurrentSy']);
        Route::get('set-not-current/{sy_id}', [PrincipalController::class, 'setNotCurrentSy']);
        Route::get('searchSy', [PrincipalController::class, 'searchSy']);
        Route::get('open-enroll/{sy_id}', [PrincipalController::class, 'openEnroll']);
        Route::get('close-enroll/{sy_id}', [PrincipalController::class, 'closeEnroll']);
        //tuition-fees
        Route::get('tuition-fees', [PrincipalController::class, 'tuitionIndex']);
        Route::post('save-fee', [PrincipalController::class, 'saveFee']);
        Route::put('edit-fee/{tf_id}', [PrincipalController::class, 'editFee']);
        Route::delete('delete-fee/{tf_id}', [PrincipalController::class, 'deleteFee']);
        //curriculums
        Route::get('curriculums', [PrincipalController::class, 'curriculumsIndex']);
        Route::post('save-curriculum', [PrincipalController::class, 'saveCurriculum']);
        Route::put('edit-curriculum/{cur_id}', [PrincipalController::class, 'editCurriculum']);
        Route::delete('delete-curriculum/{cur_id}', [PrincipalController::class, 'deleteCurriculum']);
        Route::get('searchCurriculum', [PrincipalController::class, 'searchCurriculum']);
        //rooms
        Route::get('rooms', [PrincipalController::class, 'roomsIndex']);
        Route::post('save-room', [PrincipalController::class, 'saveRoom']);
        Route::put('edit-room/{room_id}', [PrincipalController::class, 'editRoom']);
        Route::delete('delete-room/{room_id}', [PrincipalController::class, 'deleteRoom']);
        Route::get('searchRoom', [PrincipalController::class, 'searchRoom']);
        //sections
        Route::get('sections', [PrincipalController::class, 'sectionsIndex']);
        Route::post('save-section', [PrincipalController::class, 'saveSection']);
        Route::put('edit-section/{section_id}', [PrincipalController::class, 'editSection']);
        Route::delete('delete-section/{section_id}', [PrincipalController::class, 'deleteSection']);
        Route::get('searchSection', [PrincipalController::class, 'searchSection']);
        //subjects
        Route::get('subjects', [PrincipalController::class, 'subjectsIndex']);
        Route::post('save-subject', [PrincipalController::class, 'saveSubject']);
        Route::put('edit-subject/{subject_id}', [PrincipalController::class, 'editSubject']);
        Route::delete('delete-subject/{subject_id}', [PrincipalController::class, 'deleteSubject']);
        Route::get('searchSubject', [PrincipalController::class, 'searchSubject']);
        Route::get('filter-subjects', [PrincipalController::class, 'filter_subjects']);
        //set-schedules
        Route::get('set-schedules', [PrincipalController::class, 'schedulesIndex']);
        Route::post('save-schedule', [PrincipalController::class, 'saveSchedule']);
        Route::put('edit-sched/{sched_id}', [PrincipalController::class, 'editSchedule']);
        Route::delete('delete-sched/{sched_id}', [PrincipalController::class, 'deleteSched']);
        Route::get('searchSched', [PrincipalController::class, 'searchSched']);
        Route::get('filter-schedules', [PrincipalController::class, 'filter_scheds']);
        //plotted sched
        Route::get('viewplotsched', [CalendarController::class, 'viewPlotSched']);
        Route::get('filter-plot-schedules', [CalendarController::class, 'filter_plot_scheds']);
        //set advisers
        Route::get('advisers', [PrincipalController::class, 'adviserList']);
        Route::post('save-adviser', [PrincipalController::class, 'saveAdviser']);
        Route::put('edit-adviser/{id}', [PrincipalController::class, 'editAdviser']);
        Route::delete('delete-adviser/{id}', [PrincipalController::class, 'deleteAdviser']);
        //grades approval
        Route::get('grades-approval', [PrincipalController::class, 'gradesApproval']);
        Route::get('view-grades/{id}', [PrincipalController::class, 'viewGrades']);
        Route::post('release-grades', [PrincipalController::class, 'releaseGrades']);
        //gradings
        Route::get('gradings', [PrincipalController::class, 'gradings']);
        Route::get('grading/{id}', [PrincipalController::class, 'changeStatus']);
        //sem
        Route::get('sem/{id}', [PrincipalController::class, 'changeSemStatus']);
        //class list
        Route::get('principal-class-list', [PrincipalController::class, 'principalClassList']);
        Route::get('principal-select-year', [PrincipalController::class, 'principalSelectYear']);
        Route::post('class-list-report', [ReportController::class, 'classReport']);
    });

    //general routes
    Route::group(['middleware' => ['auth']], function() {
        Route::get('/profile', [GeneralController::class, 'profile'])->name('profile');
        Route::post('addProfileDetail', [ProfileController::class, 'addProfileDetail']);
        // Route::get('announcements', [GeneralController::class, 'announcements']);
        Route::get('/dashboard', [GeneralController::class, 'dashboard']);
        Route::get('change-password', [GeneralController::class, 'changePassIndex']);
        Route::put('save-change-password', [GeneralController::class, 'saveChangePass']);
        Route::get('schedule', [GeneralController::class, 'schedule']);
        Route::post('schedule-report', [ReportController::class, 'scheduleReport']);
        Route::post('assessment-report', [ReportController::class, 'assessmentReport']);
        Route::post('grade-report', [ReportController::class, 'gradeReport']);
    });
});
require __DIR__.'/auth.php';
