<?php

namespace app\models;
use PDFLib;

class RelatorioModel extends Connection
{

    public function buscarDadosRelatorio($codfuncionario) 
    {
        $conn = $this->connect();

        try {
            $stmt = $conn->prepare('SELECT 
                                        cliente.nome_cliente,
                                        cliente.telefone_cliente,
                                        funcionario.nome_funcionario,
                                        atendimento.descricao_atendimento,
                                        GROUP_CONCAT(curso.nome_curso SEPARATOR \', \') AS cursos_relacionados
                                    FROM 
                                        atendimento
                                    JOIN 
                                        cliente ON atendimento.codcliente_fk = cliente.codcliente
                                    JOIN 
                                        funcionario ON atendimento.codfuncionario_fk = funcionario.codfuncionario
                                    LEFT JOIN 
                                        atendimento_curso ON atendimento.codatendimento = atendimento_curso.codatendimento
                                    LEFT JOIN 
                                        curso ON atendimento_curso.codcurso = curso.codcurso
                                    WHERE 
                                        atendimento.codfuncionario_fk = :codFuncionario
                                    GROUP BY 
                                        atendimento.codatendimento');

            $stmt->bindParam(':codFuncionario', $codfuncionario, \PDO::PARAM_INT);
            $stmt->execute();
            $atendimentos = $stmt->fetchAll();

            return $atendimentos;
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