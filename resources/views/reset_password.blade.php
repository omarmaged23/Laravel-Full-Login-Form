@extends('layouts.nav')
@section('title','forget password')
@section('body')
    <div class="container mt-5">
        <form action="{{route('reset_password_post')}}" method="post">
            @csrf
            <input type="hidden" name="token" value="{{$token}}">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{old('email')}}">
                @error('email')
                <div  class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="exampleInputPassword1" name="password">
                @error('password')
                <div  class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleInputConfirmPassword1" class="form-label">Confirm Password</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="exampleInputConfirmPassword1" name="password_confirmation">
                @error('password_confirmation')
                <div  class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
