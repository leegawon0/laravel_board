@extends('layout.layout')

@section('title', 'Login')

@section('contents')
    <h1>Login</h1>
    <div>{!!session()->has('success') ? session('success') : ""!!}</div>
    @include('layout.errorsvalidate')
    <form action="{{route('users.login.post')}}" method="post">
        @csrf
        <label for="email">Email : </label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <br>
        <button type="submit">Login</button>
        <button type="button" onclick="location.href='{{route('users.registration')}}'">Registration</button>
    </form>
@endsection