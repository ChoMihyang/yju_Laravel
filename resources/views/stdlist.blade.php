<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>학생 정보 목록</title>
</head>
<body>
<h2>학생 목록 출력 화면</h2>
<table border="1" width="550">
    <tr>
        <td>학번</td>
        <td>이름</td>
        <td>성별</td>
        <td>점수</td>
        <td>충돌키</td>
    </tr>
    @foreach($stdlists as $value)
        <tr>
        <td>{{ $value->id }}</td>
        <td>{{ $value->name }}</td>
        <td>{{ $value->gender }}</td>
        <td>{{ $value->grade }}</td>
        <td>{{ $value->ckey }}</td>
        </tr>
    @endforeach
</table><br>
<fieldset style="width: 520px">
    <form action="{{ url('ggeneration') }}" method="post">
        @csrf
    생성 그룹 수 : <input type="text" name="numOfGroup">
    <button type="submit">그룹생성</button>
    </form>
</fieldset>
</body>
</html>
