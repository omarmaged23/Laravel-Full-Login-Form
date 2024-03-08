@extends('layouts.nav')
@section('title','register')
@section('body')
    <div class="container mt-5">
        <form action="{{route('register.post')}}" method="post">
            @csrf
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
                <label for="exampleInputName1" class="form-label">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputName1" name="name" value="{{old('name')}}">
                @error('name')
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
                <input type="password" class="form-control" id="exampleInputConfirmPassword1" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
