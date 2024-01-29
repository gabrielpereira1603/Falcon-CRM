<?php

namespace app\controllers;

use app\models\FuncionarioModel;

class FuncionarioController extends FuncionarioModel
{
    public function login()
    {
        session_start();
        $nome_funcionario = $_POST['nome'];
        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $funcionarioModel = new FuncionarioModel();
        $autenticado = $funcionarioModel->autenticarUser($login, $senha, $nome_funcionario);

        if ($autenticado) {
            header("Location:?router=Site/home");
        } else {
            $_SESSION['error_admin'] = 'Dados inválidos';
            header("Location:?router=Site/login");
        }

    }

    public function logout() 
    {
        session_start();
        session_destroy();
        header("Location: ?router=Site/login"); // redireciona para a página de login de aluno
        exit;
    }
}