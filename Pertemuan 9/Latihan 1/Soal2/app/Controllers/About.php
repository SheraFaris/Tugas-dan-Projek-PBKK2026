<?php

namespace App\Controllers;

class About extends BaseController
{
    public function index(){
        $data = [
            'title' => 'About Me',
            'msg'   => 'Mahasiswa ITS yang berusaha memperbaiki dirinya sendiri'
        ];
        
        return view('about', $data);
    }    
}