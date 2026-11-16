<?php

namespace App\Controllers;

class Contact extends BaseController
{
    public function index(){
        $data = [
            'title'    => 'This is My Contacts!',
            'telp'     => '(+62) 81214678646',
            'email'    => 'ananda.farisgr@gmail.com'
        ];
        
        return view('contact', $data);
    }   
}