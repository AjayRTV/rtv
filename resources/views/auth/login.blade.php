@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="wrapper">
            @foreach ($adminData  as $adminimag)
            @endforeach
            <div class="logo"> <img src="{{ asset('admin/img/' . $adminimag->image) }}" alt="logo"> </div>
            <div class="text-center mt-4 name"> Login </div>
            <form class="p-3 mt-3 loginbtn"  method="post" action="{{ route('login') }}">
                @csrf
                <!-- <div class="card-body"> -->
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                            @php
                                Session::forget('success');
                            @endphp
                        </div>
                    @endif
                    <div class="form-group  align-items-center">
                        {{-- <i class="fa fa-user"></i>  --}}
                        <input type="text" name="email" id="userName" placeholder="Username" class=" @error('email') is-invalid @enderror">
                        {{-- {!! $errors->first('email', '<small class="text-danger">:message</small>') !!} --}}
                        <span id="adminEmail" style="color: red;" ></span>
                    </div >
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="form-group  align-items-center">
                        {{-- <span class="fas fa-key"></span>  --}}
                        <input type="password" name="password" id="adminpassword" placeholder="Password" class="
                        @error('password') is-invalid @enderror">
                        {{-- {!! $errors->first('password', '<small class="text-danger">:message</small>') !!} --}}
                        <span id="adminpasswords" style="color: red;"></span>
                    </div>
                    {{-- <button class="btn mt-3">Login</button> --}}
                    <button type="submit" name="submit" class="btn mt-3" id="loginbtn">
                        <b>{{ __('Login') }}</b>
                    </button>
                <!-- </div>     -->
            </form>
            <div class="text-center fs-6">
                <a href="#">Forget password?</a> or <a href="#">Sign up</a>
            </div>
        </div>
</div>
@endsection
