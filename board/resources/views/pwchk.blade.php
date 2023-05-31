@extends('layout.layout')

@section('title', 'Pwchk')

@section('contents')
    <h1>비밀번호 확인</h1>
    @include('layout.errorsvalidate')
    <form action="{{route('users.pwchk.post')}}" method="post">
        @csrf
        <input type="password" name="pwchk" id="pwchk">
        <button type="submit">확인</button>
    </form>
@endsection