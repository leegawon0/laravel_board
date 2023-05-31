<?php

/************************************************
 * 프로젝트명   : laravel_board
 * 디렉토리     : Controllers
 * 파일명       : UserController.php
 * 이력         : v001 0530 GW.Lee new
 ************************************************/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class UserController extends Controller
{
    function login() {
        return view('login');
    }

    function loginpost(Request $req) {
        // 유효성 체크
        $req->validate([
            'email'     => 'required|email|max:100'
            ,'password' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);

        // 유저정보 습득
        $user = User::where('email', $req->email)->first();
        if(!$user || !(Hash::check($req->password, $user->password))) {
            $error = '아이디와 비밀번호를 확인해 주세요.';
            return redirect()->back()->with('error', $error);
        }

        // 유저 인증작업
        Auth::login($user);
        if(Auth::check()) {
            session($user->only('id')); // 세션에 인증된 회원 pk 등록
            return redirect()->intended(route('boards.index'));
        } else {
            $error = '인증작업 에러';
            return redirect()->back()->with('error', $error);
        }
    }

    function registration() {
        return view('registration');
    }

    function registrationpost(Request $req) {
        // 유효성 체크
        $req->validate([
            'name'      => 'required|regex:/^[가-힣]+$/|min:2|max:30'
            ,'email'    => 'required|email|max:100'
            ,'password' => 'required_with:passwordchk|same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);

        $data['name'] = $req->name;
        $data['email'] = $req->email;
        $data['password'] = Hash::make($req->password);

        $user = User::create($data);
        if(!$user) {
            $error = '시스템 에러가 발생하여 회원가입에 실패했습니다.<br>잠시 후에 다시 시도해 주십시오.';
            return redirect()->route('users.registration')
                ->with('error', $error);
        }

        // 회원가입 완료 로그인 페이지로 이동
        return redirect()->route('users.login')->with('success', '회원가입을 완료 했습니다.<br>가입하신 아이디와 비밀번호로 로그인 해 주세요.');
    }

    function logout() {
        Session::flush(); // 세션 파기
        Auth::logout(); // 로그아웃
        return redirect()->route('users.login');
    }

    function withdraw() {
        $id = session('id');
        $result = User::destroy($id);
        Session::flush();
        Auth::logout(); // 에러처리(laravel error handling) 2차프로젝트에서 작성
        return redirect()->route('users.login');
    }

    function edit() {
        $id = session('id');
        $users = User::find($id);
        return view('usersedit')->with('data', $users);
    }

    public function update(Request $request)
    {
        $id = session('id');
        $chklist = [
            'name'      => 'required|regex:/^[가-힣]+$/|min:2|max:30'
            ,'password' => 'required_with:passwordchk|same:passwordchk|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ];
        if(strlen($request['password']) === 0) {
            $request->validate([
                'name'      => $chklist['name']
            ]);
            $users = User::find($id);
            $users->name = $request->name;
            $users->save();
        } else {
            $request->validate([
                'name'      => $chklist['name']
                ,'password' => $chklist['password']
            ]);
            $users = User::find($id);
            $users->name = $request->name;
            $users->password = Hash::make($request->password);
            $users->save();
        }
        return redirect()->route('boards.index');
    }

    public function pwchk() {
        return view('pwchk');
    }

    public function pwchkpost(Request $req) {
        // 유효성 체크
        $req->validate([
            'pwchk' => 'required|regex:/^(?=.*[a-zA-Z])(?=.*[!@#$%^*-])(?=.*[0-9]).{8,20}$/'
        ]);
        // 유저정보 습득
        $id = session('id');
        $users = User::find($id);
        if(!$users || !(Hash::check($req->pwchk, $users->password))) {
            $error = '비밀번호를 다시 확인해 주세요.';
            return redirect()->back()->with('error', $error);
        }
        session(['chkflg' => '1']);
        return redirect()->route('users.edit');
    }
}
