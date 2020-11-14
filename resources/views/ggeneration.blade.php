<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>그룹 생성 페이지</title>
    <style>body{font-size: 20px;}</style>
</head>
<body>

{{--생성 그룹 갯수 출력--}}
생성 그룹 갯수 : {{ $numOfGroup }}<br><br>

{{--남, 여, 총학생 수 출력--}}
남학생 수 : {{ $numOfStd['numOfMale'] }}<br>
여학생 수 : {{ $numOfStd['numOfFemale'] }}<br>
총 학생 수 : {{ $numOfStd['totalNum'] }}<br>


{{--조 편성 결과 출력--}}
<br><b>조 편성 결과</b><br>
@for($i = 0; $i < $numOfGroup ; $i++)
    <br>{{$i + 1}}조 멤버 목록<br>
    @php $lineCount = 0; @endphp
    @foreach($resultOfGroup[$i] as $argStd)
            {{ ++$lineCount }})
            학번 : {{ $argStd->id }}
            이름 : {{ $argStd->name }}
            성별 : {{ $argStd->gender }}
            <br>
    @endforeach
@endfor

{{--충돌키 출력--}}
{{--
<br><br><b>충돌키 확인</b><br>
@for($i = 0; $i < $numOfGroup ; $i++)
    <br>{{$i + 1}}조 멤버 목록<br>
    @php $lineCount = 0; @endphp
    @foreach($resultOfGroup[$i] as $group)
        {{ ++$lineCount }}) 번 학생의 충돌키 : {{ $group->ckey }}<br>
    @endforeach
@endfor
--}}
</body>
</html>
