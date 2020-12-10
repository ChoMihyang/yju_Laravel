<?php

use Illuminate\Database\Seeder;
use App\Student;
use App\Gpa;


class CreateExamData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numOfStudent = 5;   // 학생 수

        $faker = Faker\Factory::create(); // Fake 객체 생성

        $korean_records = [100, 50, 30, 90, 40];
        $math_records = [80, 60, 20, 80, 50];
        $english_records = [90, 60, 70, 80, 60];

        // products 테이블 내 MOCK 레코드 생성 : 5개
        for ($count = 0; $count < $numOfStudent; $count++) {
            $record = [
                'name' => $faker->firstName,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'created_at' => $faker->dateTimeBetween($startDate = '-2 year', $endDate = '-1 year'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now')
            ];
            App\Student::create($record);

            $sum = ($korean_records[$count] + $math_records[$count] + $english_records[$count]);
            $avg = $sum / 3;

            $record = [
                'student_id' => $count + 1,
                'korean' => $korean_records[$count],
                'math' => $math_records[$count],
                'english' => $english_records[$count],
                'sum' => $sum,
                'avg' => $avg,
                'created_at' => $faker->dateTimeBetween($startDate = '-2 year', $endDate = '-1 year'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-1 year', $endDate = 'now')
            ];

            App\Gpa::create($record);

        }
    }
}
