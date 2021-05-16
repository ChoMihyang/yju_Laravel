# yju_Laravel

### 2020-10-19

#### Laravel 동작 절차

#### 컨트롤러 생성(직접 추가, Artisan 이용)

#### Artisan

### 2020-12-10

### 기말고사 - 학생성적관리프로그램

### Migration & Seeding

- students 테이블과 gpa 테이블을 생성
- MOCK DATA 삽입

### Model
- 두 테이블 1:1 관계 설정
- Mass assignment 설정 (guarded) 
- 파일     
    - Student.php
    - Gpa.php

### Controller
- list() - 학생 목록 출력
- insert() - 학생 정보 및 성적 입력 -> 학생 목록 출력
- getStdId() - 학생 ID 획득 -> 수정 페이지 출력
- modify() - 학생 수정값 DB 업데이트 -> 학생 목록 출력 
- delete() - 학생 성적 레코드 삭제 -> 학생 목록 출력

### View
- stdlist.blade.php - 전체 학생 목록 출력, 입력, 수정, 삭제 기능 페이지
- modify_view.php - 학생 정보 및 성적 수정 페이지

### Route
- Controller 구조와 동일 


