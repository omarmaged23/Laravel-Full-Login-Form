@extends('layouts.nav')
@section('title','home')
@section('body')
    <h1>Welcome to home page : {{auth()->user()->name}}</h1>
@endsection
