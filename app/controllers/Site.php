<?php

namespace app\controllers;

class Site
{
    public function home() 
    {
        require_once __DIR__ . '/../views/home.php';
    }

    public function login() 
    {
        require_once __DIR__ . '/../views/login.php';
    }
    
    public function cadastrarAtendimento() 
    {
        require_once __DIR__ . '/../views/cadastrarAtendimento.php';
    }
}