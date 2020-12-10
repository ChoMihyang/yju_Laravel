<?php

namespace App\Http\Controllers;

use App\Gpa;
use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // 학생 목록을 모두 출력하는 메서드
    public function list()
    {
        // 학생 수 획득
        $lenOfStudents = Student::all()->count();
        // 최종 반환할 학생 배열 생성
        $studentList = [];

        // 학생 수만큼 각각의 레코드 생성
        for ($count = 1; $count <= $lenOfStudents; $count++) {

            // 학생 테이블 조회
            $stdInfo = Student::find($count);
            // 성적 테이블 조회
            $gpaOfStdInfo = $stdInfo->gpa;

            // 해당 학생의 성적 레코드가 비어있을 경우 출력하지 않음
            if (empty($gpaOfStdInfo)) continue;

            // 학생 배열 하나씩 저장
            $studentList[] = [
                "id" => $stdInfo->id,
                "name" => $stdInfo->name,
                "korean" => $gpaOfStdInfo->korean,
                "math" => $gpaOfStdInfo->math,
                "english" => $gpaOfStdInfo->english,
                "sum" => $gpaOfStdInfo->sum,
                "avg" => $gpaOfStdInfo->avg
            ];
        }
        // 모든 학생 정보 -> stdlist 로 전달
        return view('stdlist', ['stdList' => $studentList]);
    }


    // 학생 정보와 성적 데이터를 DB 내 삽입하는 메서드
    public function insert(Request $request)
    {
        // <<-- 학생 레코드 삽입 시작
        $newStdRecord = new Student();
        $newStdRecord->name = $request->get('name');
        $newStdRecord->email = $request->get('email');
        $newStdRecord->phone = $request->get('phone');

        // DB 내 저장
        $newStdRecord->save();
        // 학생 레코드 삽입 끝 -->>

        // <<-- 성적 레코드 삽입 시작
        $newGpaRecord = new Gpa();

        // 합계, 평균 연산
        $sumOfGpa
            = $request->get('korean')
            + $request->get('english')
            + $request->get('math');

        $avgOfGpa = $sumOfGpa / 3;

        $newGpaRecord->korean = $request->get('korean');
        $newGpaRecord->english = $request->get('english');
        $newGpaRecord->math = $request->get('math');
        $newGpaRecord->sum = $sumOfGpa;
        $newGpaRecord->avg = $avgOfGpa;

        // DB 내 저장
        $newStdRecord->gpa()->save($newGpaRecord);
        // 성적 레코드 삽입 끝 -->>

        // 학생 목록 출력
        return $this->list();
    }


    // 한 명의 학생을 수정하기 위해 ID 값을 획득하는 메서드
    public function getStdInfo(Request $request)
    {
        // 입력한 학생 ID 값 획득
        $stdId = $request->get('id');
        // 해당 학생의 레코드 조회
        $stdRecord = Student::find($stdId);
        $gpaRecord = $stdRecord->gpa;

        // 해당 학생의 정보를 배열로 저장
        $returnStdRecord = [
            "id" => $stdRecord->id,
            "name" => $stdRecord->name,
            "phone" => $stdRecord->phone,
            "korean" => $gpaRecord->korean,
            "math" => $gpaRecord->math,
            "english" => $gpaRecord->english
        ];

        // 해당 학생 정보 -> modify_view 로 전달
        return view('modify_view', ['returnStdRecord' => $returnStdRecord]);
    }

    // 수정 페이지에서 입력한 데이터를 DB 내 업데이트하는 메서드
    public function modify(Request $request)
    {
        // 해당 학생의 ID 값으로 레코드 획득
        $stdRecord = Student::find($request->get('id'));

        // 해당 학생의 '이름', '전화번호' 필드 값 수정
        $stdRecord->name = $request->get('name');
        $stdRecord->phone = $request->get('phone');
        // DB 업데이트
        $stdRecord->push();

        // 합계, 평균 연산
        $sumOfGpa
            = $request->get('korean')
            + $request->get('english')
            + $request->get('math');

        $avgOfGpa = $sumOfGpa / 3;

        // 해당 학생의 성적 레코드 수정
        $gpaRecord = $stdRecord->gpa;

        // 해당 학생의 '국어', '수학', '영어' 점수 필드 값 수정
        $gpaRecord->korean = $request->get('korean');
        $gpaRecord->math = $request->get('math');
        $gpaRecord->english = $request->get('english');
        $gpaRecord->sum = $sumOfGpa;
        $gpaRecord->avg = $avgOfGpa;
        // DB 업데이트
        $gpaRecord->push();

        // 학생 정보 목록 출력
        return $this->list();
    }


    // 한 명의 학생 성적 레코드를 삭제하는 메서드
    public function delete(Request $request)
    {
        // 해당 학생의 ID 값으로 레코드 획득
        $stdRecord = Student::find($request->get('id'));
        // 해당 학생의 성적 레코드 삭제
        $stdRecord->gpa()->delete();

        // 학생 정보 목록 출력
        return $this->list();
    }
}
