<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarController extends Controller
{
    function info(){
        // view helper를 이용하여 'bar.blade.php' view파일 획득
        return view('bar');
    }
}
