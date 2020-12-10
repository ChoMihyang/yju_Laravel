<?php

namespace App;

use App\Student;
use Illuminate\Database\Eloquent\Model;

class Gpa extends Model
{
    // DB 내 'gpa' 테이블과 매핑
    protected $table = 'gpa';

    // Mass assignment 설정
    // 'id', 'student_id' 필드 이외 모두 수정 허용
    protected $guarded = ['id', 'student_id'];

    // Relationship 관계 설정
    public function student()
    {
        // Gpa 테이블은 Student 테이블에 종속한다.
        return $this->belongsTo(Student::class);
    }
}
