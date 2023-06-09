<?php
/************************************************
 * 프로젝트명   : laravel_board
 * 디렉토리     : Controllers
 * 파일명       : BoardsController.php
 * 이력         : v001 0526 GW.Lee new
 *              v002 0530 GW.Lee 유효성 체크 추가
 ************************************************/

// v002 del
// v002 update start
// v002 update end

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\Boards;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // v002 add
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BoardsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 로그인 체크
        if(auth()->guest()) {
            return redirect()->route('users.login');
        }

        $result = Boards::select(['id', 'title', 'hits', 'created_at', 'updated_at'])->orderBy('hits', 'desc')->get();
        return view('list')->with('data', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('write');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        // v002 add start
        $req->validate([
            'title' => 'required|between:3,20'
            ,'content' => 'required|max:1000'
        ]);
        // v002 add end
        
        $boards = new Boards([
            'title' => $req->input('title')
            , 'content' => $req->input('content')
        ]);
        $boards->save();
        return redirect('/boards');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $boards = Boards::find($id);
        $boards->hits++;
        $boards->save();
        return view('detail')->with('data', Boards::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $boards = Boards::find($id);
        return view('edit')->with('data', $boards);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // ***** v002 add start *****
        $arr = ['id' => $id];
        // $request->merge($arr);
        $request->request->add($arr);
        $request->validate([
            'title' => 'required|between:3,20'
            ,'content' => 'required|max:1000'
            ,'id' => 'required|integer'
        ]);
        // ***** v002 add end *****

        // 유효성 검사 방법 2
        // $validator = Validator::make(
        //     $request->only('id', 'title', 'content')
        //     ,[
        //         'title' => 'required|between:3,20'
        //         ,'content' => 'required|max:1000'
        //         ,'id' => 'required|integer'
        //     ]
        // );
        // if($validator->fails()) {
        //     return redirect()
        //     ->back()
        //     ->withErrors($validator)
        //     ->withInput($request->only('title', 'content'));
        // }

        // $boards = DB::table('boards')
        // ->where('id', $id)
        // ->update(['title' => $request->title, 'content' => $request->content]);
        $boards = Boards::find($id);
        $boards->title = $request->title;
        $boards->content = $request->content;
        $boards->save();
        // return redirect('/boards/'.$id)->with('data', Boards::findOrFail($id));
        return redirect()->route('boards.show', ['board' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $boards = DB::table('boards')
        // ->where('id', $id)
        // ->update(['deleted_at' => now()]);
        // $boards = Boards::find($id)->delete();
        $boards = Boards::destroy($id);
        return redirect('/boards');
    }
}
