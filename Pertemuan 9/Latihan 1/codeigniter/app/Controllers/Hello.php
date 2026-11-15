<?php

namespace App\Controllers;

class Hello extends BaseController
{
    public function index($name = null)
    {
        $data = [
            'title'    => 'Hello, CodeIgniter!',
            'message'   => 'This page is rendered using a View.',
            'name'      => 'Faris'
        ];

        $data['name'] = $name ?? $data['name'];

        return view('hello', $data);
    }
}
