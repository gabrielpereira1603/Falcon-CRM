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
       // Limpar os cookies
       setcookie('nomeCliente', '', time() - 3600);
       setcookie('telefone', '', time() - 3600);
       setcookie('cursoNegociado', '', time() - 3600);
       setcookie('horarioInicio', '', time() - 3600);
       setcookie('horarioFim', '', time() - 3600);
       setcookie('descricao', '', time() - 3600);
       setcookie('lembrete', '', time() - 3600);
        var_dump($cod_funcionario, $nome_cliente, $telefone_cliente, $curso_negociado, $horario_inicio, $horario_fim, $descricao, $lembrete);

        $atendimentoModel = new AtendimentoModel();
        $success = $atendimentoModel->cadastro($nome_cliente, $telefone_cliente, $curso_negociado, $horario_inicio, $horario_fim, $descricao, $lembrete, $cod_funcionario, $nome_funcionario);
       
        if ($success) { 
            $_SESSION['error_message'] = 'Houve um erro ao enviar a reclamação.';
            header("Location: ?router=Site/cadastrarAtendimento");
        } else {
            $_SESSION['success_message'] = 'Reclamação enviada com sucesso!';
            header("Location: ?router=Site/cadastrarAtendimento");
        }
    }
}