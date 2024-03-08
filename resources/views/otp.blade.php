@extends('layouts.nav')
@section('title','Email Verification')
@section('body')
    <div class="container mt-5">
        @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{session('error')}}
            </div>
        @endif
        @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{session('success')}}
            </div>
            @php
            session()->forget('success');
            @endphp
        @endif
            <div>
                <p class="lead">
                    <small>
                        Please enter the otp we sent to your email address to continue.
                    </small>
                </p>
            </div>
        <form action="{{route('verify_email_post')}}" method="post" class="d-inline">
            @csrf
            <div class="mb-3">
                <input type="hidden" name="otpToken" value="{{$otp}}">
                <input type="text" class="form-control @error('otp') is-invalid @enderror" id="exampleInputOtp1" name="otp" >
                @error('otp')
                <div  class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
            <form action="{{route('resend_email_post')}}" method="post" class="d-inline-block">
                @csrf
            <button type="submit" class="btn btn-secondary">Resend OTP</button>
            </form>
    </div>
@endsection
