<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Boards;
use Illuminate\Support\Facades\Validator;

class ApiListController extends Controller
{
    function getlist($id) {
        $boards = Boards::find($id);
        return response()->json($boards, 200);
    }

    function postlist(Request $req) {
        // 유효성 체크 필요
        $boards = new Boards([
            'title' => $req->title
            , 'content' => $req->content
        ]);
        $boards->save();
        $arr['errorcode'] = '0';
        $arr['msg'] = 'success';
        $arr['data'] = $boards->only('id', 'title');
        return $arr;
    }

    function putlist(Request $request, $id) {
        $arrData = [
            'code' => '0'
            ,'msg' => ''
        ];
        // 유효성 체크
        $arr = ['id' => $id];
        $request->request->add($arr);
        $validator = Validator::make(
            $request->only('id', 'title', 'content')
            ,[
                'title' => 'required|between:3,20'
                ,'content' => 'required|max:1000'
                ,'id' => 'required|integer|exists:boards'
            ]
        );
        if($validator->fails()) {
            $arrData['code'] ='E01';
            $arrData['msg'] = 'Validation Error';
            $arrData['errmsg'] = $validator->errors()->all();
            return $arrData;
        } else {
            // 업데이트
            $boards = Boards::find($id);
            $boards->title = $request->title;
            $boards->content = $request->content;
            $boards->save();

            $arrData['code'] = '0';
            $arrData['msg'] = 'success';
            return $arrData;
        }
    }

    function deletelist($id) {
        $arrData = [
            'code' => '0'
            ,'msg' => ''
        ];
        // 유효성 체크
        $arr = ['id' => $id];
        $validator = Validator::make(
            $arr
            ,[
                'id' => 'required|integer|exists:boards'
            ]
        );
        if($validator->fails()) {
            $arrData['code'] ='E01';
            $arrData['msg'] = 'Validation Error';
            $arrData['errmsg'] = $validator->errors()->all();
            return $arrData;
        } else {
            // 업데이트
            $boards = Boards::find($id);
            if($boards){
                $boards->delete();
                $arrData['code'] = '0';
                $arrData['msg'] = 'success';
                $arrData['id'] = $id;
            } else {
                $arrData['code'] = 'E02';
                $arrData['msg'] = 'the field is already deleted';
            }

            return $arrData;
        }
    }
}
