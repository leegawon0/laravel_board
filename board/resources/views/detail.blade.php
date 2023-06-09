<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
</head>
<body>
    <div>
        글번호 : {{$data->id}}
        <br>
        등록일자 : {{$data->created_at}}
        <br>
        수정일자 : {{$data->updated_at}}
        <br>
        조회수 : {{$data->hits}}
        <br>
        제목 : {{$data->title}}
        <br>
        내용 : {{$data->content}}
    </div>
    <button type="button" onclick="location.href='{{route('boards.index')}}'">돌아가기</button>
    <button type="button" onclick="location.href='{{route('boards.edit', ['board' => $data->id])}}'">수정</button>
    <form action="{{route('boards.destroy', ['board' => $data->id])}}" method="post">
    @csrf
    @method('delete')
    <button type="submit">삭제</button>
    </form>
</body>
</html>