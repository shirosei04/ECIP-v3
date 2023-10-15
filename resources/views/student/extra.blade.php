{{-- FIRST TERM --}}
@foreach($frst as $f)
{{-- KUNG INOPEN NG PRINCIPAL ANG ONE, DAPAT VIEWABLE + EDITABLE UNG GRADE --}}
@if($f->status == "1")
<td><input style="width: 40px; text-align:center" name="frst[]frst" type="text" value="{{$student->frst_grade}}"></td>
@else
 {{-- KUNG CLOSED ANG ONE, DAPAT VIEWABLE LANG UNG GRADE --}}
<input style="width: 40px; text-align:center" name="frst[]frst" type="hidden" value="{{$student->frst_grade}}">
<td>{{$student->frst_grade}}</td>
@endif
@endforeach

{{-- SECOND TERM --}}
@foreach($scnd as $sc)
@if($sc->status == "1")
<td><input style="width: 40px; text-align:center" name="scnd[]scnd" type="text" value="{{$student->scnd_grade}}"></td>
@else
<input style="width: 40px; text-align:center" name="scnd[]scnd" type="hidden" value="{{$student->scnd_grade}}">
<td>{{$student->scnd_grade}}</td>
@endif
@endforeach

{{-- KUNG HINDI PANG GRADE 11 OR TWELVE UNG SUB --}}
@if($gradelvl->subject_grade_lvl != "Grade 11" && $gradelvl->subject_grade_lvl != "Grade 12")
{{-- THIRD TERM --}}
@foreach($thrd as $th)
    @if($th->status == "1")
    <td><input style="width: 40px; text-align:center" name="thrd[]" type="text" value="{{$student->thrd_grade}}"></td>
    @else
    <input style="width: 40px; text-align:center" name="thrd[]" type="hidden" value="{{$student->thrd_grade}}">
    <td>{{$student->thrd_grade}}</td>
    @endif
@endforeach

{{-- FOURTH TERM --}}
@foreach($frth as $fr)
    @if($fr->status == "1")
    <td><input style="width: 40px; text-align:center" name="frth[]" type="text" value="{{$student->frth_grade}}"></td>
    @else
    <input style="width: 40px; text-align:center" name="frth[]" type="hidden" value="{{$student->frth_grade}}">
    <td>{{$student->frth_grade}}</td>
    @endif
@endforeach

{{-- KUNG MAY FOURTH GRADE NA, CALCULATE AVERAGE --}}
@if (!empty($student->frth_grade))
    <td>{{round(($student->frst_grade + $student->scnd_grade + $student->thrd_grade + $student->frth_grade) / 4)}}</td>
    @else
    {{-- KUNG WALA PANG FOURTH GRADE, TD MUNA --}}
    <td></td>
@endif

{{-- KUNG MAY FOURTH GRADE NA, CALCULATE KUNG PASADO OR BAGSAK --}}
@if(!empty($student->frth_grade) & !empty($student->frst_grade) & !empty($student->scnd_grade) & !empty($student->thrd_grade))
    @if(round(($student->frst_grade + $student->scnd_grade + $student->thrd_grade + $student->frth_grade) / 4) >= 75)
    <td>PASSED</td>
    @else
    <td>FAILED</td>
    @endif
{{-- KUNG WALA PANG FOURTH GRADE, TD MUNA --}}
@else
    <td></td>
@endif
@else
<input style="width: 40px; text-align:center" name="thrd[]" type="hidden" value="{{$student->thrd_grade}}">
<input style="width: 40px; text-align:center" name="frth[]" type="hidden" value="{{$student->frth_grade}}">
@if (!empty($student->scnd_grade))
<td>{{round(($student->frst_grade + $student->scnd_grade) / 2)}}</td>
@else
<td></td>
@endif
@if(!empty($student->frst_grade) & !empty($student->scnd_grade))
    @if(round(($student->frst_grade + $student->scnd_grade ) / 2) >= 75)
    <td>PASSED</td>
    @else
    <td>FAILED</td>
    @endif
@else
    <td></td>
@endif
@endif

@if($student->view_status == 1)
<td>Yes</td>
@else
<td>No</td>
@endif