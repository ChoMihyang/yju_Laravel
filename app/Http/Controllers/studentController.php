<?php
namespace App\Http\Controllers;

use App\stdModel;
use Illuminate\Http\Request;

class studentController extends Controller
{
    // 학생 목록 출력
    public function list()
    {
        // 출력을 위해 Eloquent ORM 을 이용하여 테이블 내 모든 레코드 반환
        $stdRecords = stdModel::all();

        // 테이블 내 조회된 레코드들을 view 로 전달
        // stdlist.blade.php 로 이동하면서 'stdlists' 라는 키값으로 $stdRecords 정보를 함께 넘겨준다.
        return view('stdlist', ['stdlists' => $stdRecords]);
    }


    // 조 편성 결과 출력 메서드
    public function createGroup(Request $request)
    {
        // Eloquent ORM 을 이용하여 테이블 내 모든 레코드 반환
        $stdList = stdModel::all();

        // view 에서 생성 그룹 수를 입력하여 저장된 변수를 호출
        $numOfGroup = $request->input('numOfGroup');

        // 남, 여, 총학생 수 반환값 저장
        $numOfStd = $this->numOfStd($stdList);

        while(true) {
            // 남학생 조 편성 결과 반환값 저장
            $resultOfMaleGroup = $this->groupOfMales($stdList, $numOfGroup);

            // 여학생 조 편성 후 최종 그룹 저장
            $resultOfAllGroup = $this->groupOfFemales($stdList, $resultOfMaleGroup, $numOfGroup);

            // 충돌키 중복 확인
            $ckeyCheck = $this->checkCkey($resultOfAllGroup);
            // 충돌 여부 없을 시 조편성 반복문 탈출, 최종 그룹 배정!
            if($ckeyCheck) break;
        }

        // view 로 조 편성 데이터 전달
        return view(
            'ggeneration',
            [
                'numOfGroup'    => $numOfGroup,
                'numOfStd'      => $numOfStd,
                'resultOfGroup' => $resultOfAllGroup
            ]);
    }


    // 남학생, 여학생, 총 학생 수 획득 메서드
    public function numOfStd($argStdList)
    {
        $numOfStd = ["totalNum" => 0, "numOfFemale" => 0, "numOfMale" => 0];

        // 남학생, 여학생 수 count
        foreach ($argStdList as $argStd) {
            if ($argStd->gender == "MALE") $numOfStd['numOfMale']++;
            else                           $numOfStd['numOfFemale']++;
        }

        // 총 학생 수 count = 남학생 수 + 여학생 수
        $numOfStd['totalNum'] = $numOfStd['numOfMale'] + $numOfStd['numOfFemale'];

        // 학생 수 정보가 저장된 배열 반환
        return $numOfStd;
    }


    // 남학생 조 편성 메서드
    public function groupOfMales($argStdList, $numOfGroup)
    {
        // 남학생 정보를 저장하는 배열 생성
        $listOfMale = [];
        foreach ($argStdList as $argStd) {
            if ($argStd['gender'] == "MALE") array_push($listOfMale, $argStd);
        }

        // 그룹 배열 생성
        $groups        = [];
        // 남학생 일정 배정 시 각 조별 라인 수(= 학생 수) 저장
        // 총 11명을 4조로 배정할 경우 우선 일정하게 배정하면 한 조에 2명이 된다.
        $lineOfGroup   = (int)(count($listOfMale) / $numOfGroup);

        // 생성 그룹 수만큼 그룹 배열 생성
        //todo
        // php 에서 배열은 길이가 정해져 있지 않지만 아래 내용이 없으면 parameter 에러 발생
        // --> why??
        for ($i = 0; $i < $numOfGroup; $i++) {
            array_push($groups, []);
        }

        // <<-- 남학생들을 일정하게 우선 배정 시작
        for ($i = 0 ; $i < $lineOfGroup ; $i++){
            // 매번 랜덤 GroupId를 생성
            $ranGroupIdArr = $this->getGroupId($numOfGroup);
            // GroupId 를 순회하며 남학생 레코드를 차례대로 저장
            for ($j = 0 ; $j < $numOfGroup ; $j++){
                array_push($groups[$ranGroupIdArr[$j]], $listOfMale[$i * $numOfGroup + $j]);
            }
        }
        // -->> 일정하게 우선 배정 끝

        // <<-- 남은 남학생들 배정 시작
        // 점수 기준으로 오름차순된 그룹 배열
        $remainGroup = $this->sortGroup($groups, $numOfGroup);

        // 일정하게 배정 후 남은 남학생 수
        // 총 11명을 4조로 배정할 경우 2명씩 일정 배정되고 2명이 남는다.
        $numOfRemainStds = count($listOfMale) % $numOfGroup;

        // 남은 학생들 중 첫 인덱스
        // 오름차순으로 정렬된 그룹 배열에 남학생 배열의 $indexRemainStd 차례부터 배정한다.
        $indexRemainStd = $lineOfGroup * $numOfGroup;

        // 남은 남학생 배정
        for ($i = 0 ; $i < $numOfRemainStds ; $i++){
                array_push($remainGroup[$i], $listOfMale[$indexRemainStd + $i]);
        }
        // -->> 남은 남학생 배정 끝

        // 다음으로 여학생 배정을 위해 반환
        return $remainGroup;
    }


    // 여학생 조 편성 메서드
    public function groupOfFemales($argStdList, $resultOfGroup, $numOfGroup){

        // 여학생 정보를 저장하는 배열 생성
        $listOfFemale = [];

        foreach ($argStdList as $argStd){
            if ($argStd['gender'] == "FEMALE") array_push($listOfFemale, $argStd);
        }

        // <<-- 여학생 조 편성 시작 (Round Robin)
        $groupId = 0;
        foreach ($listOfFemale as $stdStd) {
            // 각 그룹 번호를 지정
            // 총 7명을 4조로 배정할 경우 $tempGroupId 는 차례대로 0 1 2 3 을 반복한다.
            $tempGroupId = ($groupId++) % $numOfGroup;
            // 해당 그룹 배열에 여학생 추가
            array_push($resultOfGroup[$tempGroupId], $stdStd);

        }
        // -->> 여학생 조 편성 끝

        // 여학생까지 모두 저장한 그룹 배열 반환
        return $resultOfGroup;
    }


    // 남학생 랜덤 배정을 위한 groupId 값 획득
    // 생성 그룹이 4일 경우 [0, 2, 1, 3] or [2, 3, 0, 1] 등 반환
    public function getGroupId($numOfGroup)
    {
        $tempGroupId = [];

        for ($i = 0; $i < $numOfGroup; $i++) {
            // 중복 판단 변수
            $check   = false;
            // 0부터 ($numOfGroup - 1) 까지의 랜덤 정수 저장
            $groupId = rand(0, $numOfGroup - 1);

            // 중복 판단을 위한 조건 - 첫번째는 무조건 배열에 저장하기
            if ($i == 0) {
                array_push($tempGroupId, $groupId);

                // 두 번째부터는 이전 값들과 비교하며 중복 여부 판단하기
            } else {
                foreach ($tempGroupId as $value) {
                    if ($value == $groupId) {
                        $check = true;
                        $i--;
                        break;
                    }
                }
                // 중복인 경우가 없으면 배열에 저장하기
                if (!$check) array_push($tempGroupId, $groupId);
            }
        }
        // 랜덤으로 저장된 그룹 순서 배열 반환
        return $tempGroupId;
    }


    // 총점을 기준으로한 그룹 오름차순 정렬 메서드
    public function sortGroup($groups, $numOfGroup){
        // 남은 남학생들을 그룹 내 학생들의 총점이 낮은 순으로
        // 저장하기 위한 배열
        $orderGrade = [];

        for($i = 0 ; $i < count($groups) ; $i++){
            $sumGradeInGrp = 0;

            foreach ($groups[$i] as $argStd) {
                $sumGradeInGrp += $argStd->grade;
            }
            array_push($orderGrade, $sumGradeInGrp);
        }

        // 점수 기준으로 오름차순 정렬 (Bubble Sorting)
        // 해당 그룹도 함께 정렬
        for ($i = 0 ; $i < $numOfGroup ; $i++){
            for ($j = 0 ; $j < $numOfGroup - $i - 1 ; $j++) {
                if ($orderGrade[$j] > $orderGrade[$j + 1]) {
                    // 점수 정렬
                    $tempGrade          = $orderGrade[$j];
                    $orderGrade[$j]     = $orderGrade[$j + 1];
                    $orderGrade[$j + 1] = $tempGrade;

                    // 그룹 정렬
                    $tempGroup          = $groups[$j];
                    $groups[$j]         = $groups[$j + 1];
                    $groups[$j + 1]     = $tempGroup;
                }
            }
        }
        // 정렬된 그룹 배열 반환
        return $groups;
    }


    // 각 그룹 내 충돌키 중복 판단 메서드
    public function checkCkey($argGroup){

        for($i = 0 ; $i < count($argGroup) ; $i++){
            // 충돌키 count 초기화
            $countOfC1 = 0;
            $countOfC2 = 0;
            // 학생 배열 순회하며 충돌키 중복 판단
            foreach ($argGroup[$i] as $argStd) {
                // 만일 충돌키가 'C1' 이라면 해당 변수에 +1 증가
                if (trim($argStd->ckey) == "C1"){
                    $countOfC1 += 1;
                    // 만일 충돌키가 'C2' 이라면 해당 변수에 +1 증가
                }else if(trim($argStd->ckey) == "C2"){
                    $countOfC2 += 1;
                }
            }
            // 각 그룹 내 충돌키 중복 판단
            if($countOfC1 == 2 || $countOfC2 == 2){
                return false;
            }
        }
        return true;
    }
}
