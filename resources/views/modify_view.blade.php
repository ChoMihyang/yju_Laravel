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
    <title>Student GPA Modify</title>
</head>
<body>
Student GPS Modify
<br>
수정

<form action="{{ url('/student/modify') }}" method="get">
    이름 : <input type="text" name="name" value="{{ $returnStdRecord['name'] }}">
    Phone : <input type="text" name="phone" value="{{ $returnStdRecord['phone'] }}">
    국어 : <input type="text" name="korean" value="{{ $returnStdRecord['korean'] }}">
    수학 : <input type="text" name="math" value="{{ $returnStdRecord['math'] }}">
    영어 : <input type="text" name="english" value="{{ $returnStdRecord['english'] }}">
    {{--ID 값을 hidden으로 전달--}}
    <input type="hidden" name="id" value="{{ $returnStdRecord['id'] }}">
    <input type="submit" value="수정">
    @csrf
</form>
</body>
</html>
