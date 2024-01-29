<?php

namespace app\models;
use PDFLib;

class RelatorioModel extends Connection
{

    public function buscarDadosRelatorio($codfuncionario) 
    {
        $conn = $this->connect();

        try {
            $stmt = $conn->query('SELECT 
                cliente.nome_cliente,
                cliente.telefone_cliente,
                atendimento.curso_negociado,
                atendimento.descricao_atendimento,
                atendimento.lembrete
            FROM 
                atendimento
            JOIN 
                cliente ON atendimento.codcliente_fk = cliente.codcliente;');
            
            $atendimentos = $stmt->fetchAll();

            return ($atendimentos);
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function relatorioPersonalizado($horaInicio, $horaFim, $data_atendimento, $codfuncionario)
    {
        try {
            $conn = $this->connect();

            $query = "SELECT at.*, cli.nome_cliente, cli.telefone_cliente, func.nome_funcionario
                    FROM atendimento AS at
                    INNER JOIN cliente AS cli ON at.codcliente_fk = cli.codcliente
                    INNER JOIN funcionario AS func ON at.codfuncionario_fk = func.codfuncionario
                    WHERE TIME(at.inicio_atendimento) >= :horaInicio
                    AND TIME(at.fim_atendimento) <= :horaFim
                    AND DATE(at.data_atendimento) = :data";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':horaInicio', $horaInicio, \PDO::PARAM_STR);
            $stmt->bindParam(':horaFim', $horaFim, \PDO::PARAM_STR);
            $stmt->bindParam(':data', $data_atendimento, \PDO::PARAM_STR);
            $stmt->execute();
            $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return $resultados;
        } catch (\PDOException $e) {
            // Tratar a exceção
            return "Erro ao buscar atendimentos: " . $e->getMessage();
        }
    }

}   