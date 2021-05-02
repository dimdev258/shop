<?php
namespace App\Controllers;

class Templates extends BaseController{
    
    public function index($name) {
        $name = str_replace('.', '/', $name);
        echo view('templates/'.$name);
    }
    
}
