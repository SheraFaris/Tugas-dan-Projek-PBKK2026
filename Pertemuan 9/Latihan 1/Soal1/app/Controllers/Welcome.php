<?php

namespace App\Controllers;

class Welcome extends BaseController
{
    public function index(){
        $data = [
            'title'     => 'Welcome to my page',
            'name'      => 'Ananda Faris Ghazi Ramadhan',
            'ID'        => '5025231280',
            'Class'     => 'PBKK D'
        ];
        
        return view('welcome', $data);
    }
}