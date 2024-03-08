@extends('layouts.nav')
@section('title','login')
@section('body')
    <div class="container mt-5">
        @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{session('success')}}
            </div>
        @endif
    <form action="{{route('login.post')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" >
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
        <div class="mb-2">
            <input type="checkbox" name="remember" id="remembertoken" value=0>
            <label>Remember Me</label>
        </div>
        <a href="{{route('forget_password_page')}}" class="d-block mb-3">Forgot password?</a>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>
    <script>
        const token = document.getElementById('remembertoken');
        if(token.checked){
            token.value=1;
        }
    </script>
@endsection
