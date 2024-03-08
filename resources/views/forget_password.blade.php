@extends('layouts.nav')
@section('title','forget password')
@section('body')
    <div class="container mt-5">
        @if(session()->has('forget_success'))
            <div class="alert alert-success" role="alert">
                {{session('forget_success')}}
            </div>
        @endif
        <div>
            <p class="lead">
                <small>
                    We will send an email to the following address with password reset link
                    please, make sure the email address is valid.
                </small>
            </p>
        </div>
        <form action="{{route('forget_password_post')}}" method="post">
            @csrf
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email">
                @error('email')
                <div  class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
