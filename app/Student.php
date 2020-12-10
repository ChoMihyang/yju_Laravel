<?php

namespace App;

use App\Gpa;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // DB 내 'students' 테이블과 매핑
    protected $table = 'students';

    // Mass assignment 설정
    // id' 필드 이외 모두 수정 허용
    protected $guarded = ['id'];

    // Relationship 관계 설정
    public function gpa()
    {
        // students 테이블은 Gpa 테이블을 종속시킨다.
        return $this->hasOne(Gpa::class);
    }
}
