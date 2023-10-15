@extends('layouts.master')
@section('content')
<div class="container align-self-center">
    @if (session('message'))
     <div class="alert alert-success mt-5" role="alert">
        <h5>{{ session('message') }}</h5>
    </div>
     @endif
<form action="{{url('save-change-password')}}" method="POST">
    @csrf
    @method('PUT')
    <div class="row mt-5">
        <div class="col-4"></div>
        <div class="col">
            <label for="" class="col-form-label text-start fw-bold">{{ __('New Password') }}</label>
            <input id="" type="password" class="form-control form-control-sm" name="password"  value="{{old('password')}}" >
            {{-- <div id="fbHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, leave blank</div> --}}
            @if($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class="col-4"></div>

    </div>
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <label for="" class="col-form-label text-start fw-bold">{{ __('Confirm New Password') }}</label>
            <input id="" type="password" class="form-control form-control-sm" name="password_confirmation"  value="{{old('password_confirmation')}}" >
            {{-- <div id="fbHelp" class="form-text"><i class="fas fa-exclamation-circle"></i> If none, leave blank</div> --}}
            @if($errors->has('password_confirmation'))
                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
            @endif
        </div>
        <div class="col-4"></div>
    </div>
    <div class="row">
        <div class="col-4"></div>
        <div class="col">
            <div class="mt-2">
                <div class="form-check justify-content-center">
                    <input class="form-check-input" type="checkbox" id="checkTwo">
                    <label class="form-check-label text-center" for="flexCheckDefault">
                        Let me change my password
                    </label>
                </div>
            </div>
        </div>
        <div class="col-4"></div>
    </div>
    <div class="row">
        <div class="col-4">
            
        </div>
        <div class="col-4">
            <input type="hidden" value="{{Auth::user()->id}}" class="delete_val" name="user_id">
            <button type="submit" class="btn btn-primary changePassButton mt-2" id="changePassButton">Change Password</button>
        </div>
        <div class="col-4"></div>
    </div>
</form>
</div>
   
@endsection

@section('scripts')
<script>
   // CHANGE PASSWORD BUTTON
var checkerTwo = document.getElementById('checkTwo');
var changebtn = document.getElementById('changePassButton');
changebtn.disabled = true;
checkerTwo.onchange = function() {
        if(this.checked){
            changebtn.disabled = false;
        } else {
            changebtn.disabled = true;
        }
    }
</script>
@endsection