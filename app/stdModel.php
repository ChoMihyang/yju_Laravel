<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

// 학생 정보를 저장할 stdModel 모델 클래스 생성
class stdModel extends Model{

    // stdModel 을 'studentlist' 테이블과 매핑
    protected $table = "studentlist";

    // Record 등록 시 timestamps 사용 안 함
    public $timestamps = false;
}
