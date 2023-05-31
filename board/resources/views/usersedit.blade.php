@extends('layout.layout')

@section('title', 'UsersEdit')

@section('contents')
    @if(!(session()->has('chkflg')))
        <script>window.location.href = "{{route('users.pwchk')}}";</script>
    @endif
    <h1>User Edit</h1>
    @include('layout.errorsvalidate')
    <form action="{{route('users.update')}}" method="post">
        @csrf
        <label for="name">Name : </label>
        <input type="text" name="name" id="name" value="{{$data->name}}">
        <br>
        <label for="email">Email : </label>
        <input type="text" name="email" id="email" value="{{$data->email}}" readonly>
        <br>
        <label for="password">Password : </label>
        <input type="password" name="password" id="password">
        <br>
        <label for="passwordchk">PW Check : </label>
        <input type="password" name="passwordchk" id="passwordchk">
        <br>
        <button type="submit">Edit</button>
        <button type="button" onclick="location.href='{{route('boards.index')}}'">Cancel</button>
    </form>
    <button type="button" onclick="withdrawConfirm()">회원탈퇴</button>
    <script>
        function withdrawConfirm() {
            if(confirm('정말 탈퇴하시겠습니까?')) {
                alert('회원 탈퇴가 완료되었습니다.');
                return location.href = "{{route('users.withdraw')}}"
            } else {
                return false;
            }
        }
    </script>
@endsection