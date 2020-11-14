<?php
namespace App\Http\Controllers;

use App\stdModel;
use Illuminate\Http\Request;

class FileUploadController extends Controller{

    // 파일 업로드 화면 출력
    public function fileUpload(){
        return view('fileUpload');
    }

    // 업로드 파일 처리
    public function fileUploadPost(Request $request)
    {

        // 클라이언트로부터 넘어온 파일 획득
        $lines = file($request->file('file')->getPathname());

        // 한 줄 단위로 처리
        foreach ($lines as $line_num => $line) {
            // 각 라인을 ','  단위로 분리 후 배열에 저장
            $fields = explode(",", $line);

            // 학생 정보 배열 생성 후 데이터 삽입
            $stdList = [];

            if ($line_num != 0) {
                $stdList[$line_num] = [
                    'id'    => $fields[0],
                    'name'  => $fields[1],
                    'gender'=> $fields[2],
                    'grade' => $fields[3],
                    'ckey'  => $fields[4]
                ];
                // 데이터를 DB 내 삽입하기 위한 메서드 호출
                $this->insert($stdList);
            }
        }
    }

    // 파싱된 각 학생 정보 데이터를 DB에 삽입
    public function insert($request){
        foreach ($request as $key){
            // 'studentlist' 테이블을 객체로 매핑
            $newRecord = new stdModel();

            // 각 객체에 학생 정보 저장
            $newRecord->id      = $key['id'];
            $newRecord->name    = $key['name'];
            $newRecord->gender  = $key['gender'];
            $newRecord->grade   = $key['grade'];
            $newRecord->ckey    = $key['ckey'];

            // DBMS 저장
            $newRecord->save();
        }
    }
}

