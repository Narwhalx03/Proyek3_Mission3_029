<?php

namespace App\Controllers;


class Home extends BaseController
{
    public function index()
    {
        $data = [
            'title'     => 'Home',
            'content'   => view ('welcome') 
        ];
        // $model = new MahasiswaModel();

        // $data['mahasiswa'] = $model->getMahasiswa();
        return view ('template', $data);
        
        //echo "Hello world";
        // return view('welcome_message');
    }

  
    

}