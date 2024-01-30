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
        $nome_cliente = isset($_POST['nomeCliente']) ? $_POST['nomeCliente'] : '';
        $telefone_cliente = isset($_POST['telefone']) ? $_POST['telefone'] : '';
        $curso_negociado = isset($_POST['browser']) ? $_POST['browser'] : [];
        $horario_inicio = $_POST['horarioInicio'];
        $horario_fim = $_POST['horarioFim'];
        $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
        $dataAtual = date("Y-m-d");
        $data_retorno = isset($_POST['agendarRetorno']) ? $_POST['agendarRetorno'] : '';
        $tipo_atendimentoSelecionado = isset($_POST['tipo_atendimento']) ? $_POST['tipo_atendimento'] : [];
        $tipo_atendimento = implode(', ', $tipo_atendimentoSelecionado);
    

        // Limpar os cookies
        setcookie('nomeCliente', '', time() - 3600);
        setcookie('telefone', '', time() - 3600);
        setcookie('cursoNegociado', '', time() - 3600);
        setcookie('horarioInicio', '', time() - 3600);
        setcookie('horarioFim', '', time() - 3600);
        setcookie('descricao', '', time() - 3600);
        setcookie('lembrete', '', time() - 3600);
        setcookie('agendarRetorno', '', time() - 3600);

        // Tratar os cursos negociados
        if (!empty($curso_negociado)) {
            $atendimentoModel = new AtendimentoModel();
            $result = $atendimentoModel->cadastro(
                $nome_cliente,
                $telefone_cliente,
                $curso_negociado,
                $horario_inicio,
                $horario_fim,
                $dataAtual,
                $descricao,
                $cod_funcionario,
                $nome_funcionario,
                $tipo_atendimento,
                $data_retorno
            );
    
            // Verifica o tipo de retorno da função
            if ($result === true) {
                $_SESSION['success_message'] = 'Atendimento cadastrado com sucesso!';
            } else {
                $_SESSION['error_message'] = $result; // Mensagem de erro
            }
        } else {
            $_SESSION['error_message'] = 'Nenhum curso negociado selecionado!';
        }
    
        // Redireciona para a página adequada
        header("Location: ?router=Site/cadastrarAtendimento");
    }
}
