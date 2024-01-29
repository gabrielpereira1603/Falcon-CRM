<?php

namespace app\controllers;
use app\models\AtendimentoModel;

class AtendimentoController extends AtendimentoModel
{
    public function CadastroAtendimento()
    {
        session_start();
        $cod_funcionario = $_SESSION['codfuncionario'];
        $nome_funcionario = $_SESSION['nome_funcionario'];
        $nome_cliente = $_POST['nomeCliente'];
        $telefone_cliente = $_POST['telefone'];
        $curso_negociado = $_POST['cursoNegociado'];
        $horario_inicio = $_POST['horarioInicio'];
        $horario_fim = $_POST['horarioFim'];
        $descricao = $_POST['descricao'];
        $lembrete = $_POST['lembrete'];
        $dataAtual = date("Y-m-d");

        
       // Limpar os cookies
       setcookie('nomeCliente', '', time() - 3600);
       setcookie('telefone', '', time() - 3600);
       setcookie('cursoNegociado', '', time() - 3600);
       setcookie('horarioInicio', '', time() - 3600);
       setcookie('horarioFim', '', time() - 3600);
       setcookie('descricao', '', time() - 3600);
       setcookie('lembrete', '', time() - 3600);
       var_dump($nome_cliente, $telefone_cliente, $curso_negociado, $horario_inicio, $horario_fim, $dataAtual, $descricao, $lembrete, $cod_funcionario, $nome_funcionario);
       
        $atendimentoModel = new AtendimentoModel();
        $result = $atendimentoModel->cadastro($nome_cliente, $telefone_cliente, $curso_negociado, $horario_inicio, $horario_fim, $dataAtual, $descricao, $lembrete, $cod_funcionario, $nome_funcionario);
        
        // Verifica o tipo de retorno da função
        if ($result === true) {
            $_SESSION['success_message'] = 'Atendimento cadastrado com sucesso!';
        } else {
            $_SESSION['error_message'] = $result; // Mensagem de erro
        }

        // Redireciona para a página adequada
        header("Location: ?router=Site/cadastrarAtendimento");
    }
}

