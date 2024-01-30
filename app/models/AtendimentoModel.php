<?php

namespace app\models;

class AtendimentoModel extends Connection
{
    public function cadastro($nome_cliente, $telefone_cliente, $curso_negociado, $horario_inicio, $horario_fim, $dataAtual, $descricao, $cod_funcionario, $nome_funcionario, $tipo_atendimento, $data_retorno) 
    {
        $conn = $this->connect();
    
        try {
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
    
            // Inserir o atendimento
            $query = "INSERT INTO atendimento (
                inicio_atendimento, 
                fim_atendimento, 
                data_atendimento, 
                data_retorno, 
                descricao_atendimento, 
                codcliente_fk, 
                codfuncionario_fk, 
                codtipo_atendimento_fk
            ) VALUES (
                :inicio_atendimento, 
                :fim_atendimento, 
                :data_atendimento, 
                :data_retorno, 
                :descricao_atendimento, 
                :codcliente_fk, 
                :codfuncionario_fk, 
                :codtipo_atendimento_fk
            )";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':inicio_atendimento', $horario_inicio);
            $stmt->bindParam(':fim_atendimento', $horario_fim);
            $stmt->bindParam(':data_atendimento', $dataAtual);
            $stmt->bindParam(':data_retorno', $data_retorno);
            $stmt->bindParam(':descricao_atendimento', $descricao);
            $stmt->bindParam(':codcliente_fk', $cod_cliente);
            $stmt->bindParam(':codfuncionario_fk', $cod_funcionario);
            $stmt->bindParam(':codtipo_atendimento_fk', $tipo_atendimento);
            $stmt->execute();
    
            // Lidar com a tabela de associação entre atendimento e curso
            $cod_atendimento = $conn->lastInsertId();
            foreach ($curso_negociado as $curso) {
                // Verificar se o curso já existe
                $query = "SELECT codcurso FROM curso WHERE nome_curso = :nome_curso";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':nome_curso', $curso);
                $stmt->execute();
                $resultCurso = $stmt->fetch();
    
                if ($resultCurso) {
                    $cod_curso = $resultCurso['codcurso'];
                } else {
                    // Trate a situação em que o curso não existe
                    // Aqui você pode optar por inserir o curso na tabela de cursos, se necessário
                }
    
                // Insere na tabela de associação
                $query = "INSERT INTO atendimento_curso (codatendimento, codcurso) VALUES (:codatendimento, :codcurso)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':codatendimento', $cod_atendimento);
                $stmt->bindParam(':codcurso', $cod_curso);
                $stmt->execute();
            }
    
            // Retorna true se a inserção for bem-sucedida
            return true;
        } catch (\PDOException $e) {
            // Se ocorrer um erro, capture a exceção e retorne a mensagem de erro
            return "Erro ao inserir atendimento: " . $e->getMessage();
        }
    }
    
}
