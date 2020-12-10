<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th {
            text-align: center;
        }
    </style>
    <title>Student GPA list</title>
</head>
<body>
Student GPS List

<table>
    <tr>
        <td>ID</td>
        <td>Name</td>
        <td>Korean</td>
        <td>Math</td>
        <td>English</td>
        <td>Sum</td>
        <td>Avg</td>
    </tr>

    {{--전달받은 학생 배열 내 데이터 출력--}}
    @foreach($stdList as $value)
        <tr>
            <td>{{ $value['id'] }}</td>
            <td>{{ $value['name'] }}</td>
            <td>{{ $value['korean'] }}</td>
            <td>{{ $value['math'] }}</td>
            <td>{{ $value['english'] }}</td>
            <td>{{ $value['sum'] }}</td>
            <td>{{ $value['avg'] }}</td>
        </tr>
    @endforeach
</table>
<br>

성적입력
<form method="post" action="{{url('/student/insert')}}">
    이름 : <input type="text" name="name" value="test 1">
    email : <input type="text" name="email" value="test_1@abc.com">
    Phone : <input type="text" name="phone" value="123-456-7890">
    국어 : <input type="text" name="korean" value="60">
    영어 : <input type="text" name="english" value="70">
    수학 : <input type="text" name="math" value="90">
    <input type="submit" value="입력">
    {{--위조 요청 방지 토큰 설정--}}
    @csrf
</form>
<br>
성적수정
<form method="get" action="{{ url('/student/modify_view')}}">
    학생 ID : <input type="text" name="id">
    <input type="submit" value="수정">
    @csrf
</form>

<br>
성적삭제
<form method="post" action="{{ url('/student/delete') }}">
    학생 ID : <input type="text" name="id">
    <input type="submit" value="삭제">
    @csrf
</form>
</body>
</html>
