<?php

namespace app\models;

class AtendimentoModel extends Connection
{
    public function cadastro($nome_cliente, $telefone_cliente, $curso_negociado, $horario_inicio, $horario_fim, $descricao, $lembrete, $cod_funcionario, $nome_funcionario) 
    {
        $conn = $this->connect();

        // Verificar se o cliente já existe
        $query = "SELECT codcliente FROM cliente WHERE nome_cliente = :nome_cliente AND telefone_cliente = :telefone_cliente";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nome_cliente', $nome_cliente);
        $stmt->bindParam(':telefone_cliente', $telefone_cliente);
        $stmt->execute();
        $result = $stmt->fetch();

        if ($result) {
            $cod_cliente = $result['codcliente'];
        } else {
            // Se o cliente não existir, criar um novo cliente
            $query = "INSERT INTO cliente (nome_cliente, telefone_cliente) VALUES (:nome_cliente, :telefone_cliente)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':nome_cliente', $nome_cliente);
            $stmt->bindParam(':telefone_cliente', $telefone_cliente);
            $stmt->execute();

            // Obter o código do novo cliente
            $cod_cliente = $conn->lastInsertId();
        }

        // Criar o novo atendimento
        $query = "INSERT INTO atendimento (inicio_atendimento, fim_atendimento, curso_negociado, descricao_atendimento, lembrete, codcliente_fk, codfuncionario_fk) VALUES (:inicio_atendimento, :fim_atendimento, :curso_negociado, :descricao_atendimento, :lembrete, :codcliente_fk, :codfuncionario_fk)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':inicio_atendimento', $horario_inicio);
        $stmt->bindParam(':fim_atendimento', $horario_fim);
        $stmt->bindParam(':curso_negociado', $curso_negociado);
        $stmt->bindParam(':descricao_atendimento', $descricao);
        $stmt->bindParam(':lembrete', $lembrete);
        $stmt->bindParam(':codcliente_fk', $cod_cliente);
        $stmt->bindParam(':codfuncionario_fk', $cod_funcionario);
        $stmt->execute();
    }
}
