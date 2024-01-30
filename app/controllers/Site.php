<?php

namespace app\controllers;

use app\models\AuxiliarModel;

class Site extends AuxiliarModel
{
    public function home() 
    {
        session_start();
        if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            $_SESSION['error'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/login");
            exit();
        }

        require_once __DIR__ . '/../views/home.php';
    }

    public function login() 
    {
        require_once __DIR__ . '/../views/login.php';
    }
    
    public function cadastrarAtendimento() 
    {
        session_start();
        if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            $_SESSION['error'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/login");
            exit();
        }
        $buscarTipoAtendimento = $this->getTipoAtendimento();
        $buscarCursos = $this->getCursos();
        $contarAtendimento = $this->countAtendimento();
        $contarAtendimentoDiaAtual = $this->countAtendimentoDiaAtual();
        require_once __DIR__ . '/../views/cadastrarAtendimento.php';
    }

    public function agenda() 
    {
        session_start();
        if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            $_SESSION['error'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/login");
            exit();
        }
        $buscarRetornos = $this->getRetornos();
        require_once __DIR__ . '/../views/agenda.php';
    }

    public function contatos() 
    {
        session_start();
        if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            $_SESSION['error'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/login");
            exit();
        }
        $BuscarContatos = $this->getContatos();
        require_once __DIR__ . '/../views/contatos.php';
    }

    public function relatorio() 
    {
        session_start();
        if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            $_SESSION['error'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/login");
            exit();
        }
        $buscarRelatorio = $this->getRelatorio();
        require_once __DIR__ . '/../views/relatorio.php';
    }

    public function resultadoRelatorio() 
    {
        session_start();
        if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== true) {
            $_SESSION['error'] = 'Voçê não tem permissão para acessar!';            
            header("Location:?router=Site/login");
            exit();
        }

        require_once __DIR__ . '/../views/resultadoRelatorio.php';
    }
    
}