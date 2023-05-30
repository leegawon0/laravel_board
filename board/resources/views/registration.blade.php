@extends('layout.layout')

@section('title', 'Registration')

@section('contents')
    <h1>Registration</h1>
    @include('layout.errorsvalidate')
    <form action="{{route('users.registration.post')}}" method="post">
        @csrf
        <label for="name">Name : </label>
        <input type="text" name="name" id="name">
        <br>
        <label for="email">Email : </label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <br>
        <label for="passwordchk">PW Check : </label>
        <input type="password" name="passwordchk" id="passwordchk">
        <br>
        <button type="submit">Regist</button>
        <button type="button" onclick="location.href='{{route('users.login')}}'">Cancel</button>
    </form>
@endsection