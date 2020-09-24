<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function book1(){
        return view('/book1');
    }

    public function book2(){
        return view('/book2');
    }

    public function book3(){
        return view('/book3');
    }

    public function book4(){
        return view('/book4');
    }

    public function book5(){
        return view('/book5');
    }
}
