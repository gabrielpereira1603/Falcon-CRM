<?php

namespace app\models;

class AuxiliarModel extends Connection
{
    public function getContatos()
    {
        $conn = $this->connect();

        try {
            $stmt = $conn->query('SELECT nome_cliente, telefone_cliente, LEFT(nome_cliente, 1) AS primeira_letra FROM cliente');
            $clientes = $stmt->fetchAll();

            return $clientes;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function getRetornos()
    {
        $conn = $this->connect();
    
        try {
            // Consulta SQL para obter os retornos com informações adicionais
                $query = "SELECT 
                CONCAT(DATE_FORMAT(a.data_retorno, '%d-%m-%Y'), ' ', TIME_FORMAT(a.data_retorno, '%H:%i')) AS data_hora_retorno_formatada,
                c.nome_cliente,
                c.telefone_cliente,
                GROUP_CONCAT(co.nome_curso SEPARATOR ', ') AS cursos_relacionados
            FROM 
                atendimento a
            INNER JOIN 
                cliente c ON a.codcliente_fk = c.codcliente
            LEFT JOIN 
                atendimento_curso ac ON a.codatendimento = ac.codatendimento
            LEFT JOIN 
                curso co ON ac.codcurso = co.codcurso
            GROUP BY 
                a.data_retorno,
                c.nome_cliente,
                c.telefone_cliente
            ORDER BY 
                a.data_retorno ASC LIMIT 0, 25;";
    
            // Preparar e executar a consulta
            $stmt = $conn->prepare($query);
            $stmt->execute();
    
            // Obter os resultados
            $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
            // Retorna os resultados
            return $resultados;
        } catch (\PDOException $e) {
            // Se ocorrer um erro, capture a exceção e retorne a mensagem de erro
            return "Erro ao obter retornos: " . $e->getMessage();
        }
    }

    public function getRelatorio() 
    {                               
        $conn = $this->connect();

        try {
            $codFuncionario = $_SESSION['codfuncionario'];

            $stmt = $conn->prepare("SELECT 
                cliente.nome_cliente,
                cliente.telefone_cliente,
                funcionario.nome_funcionario,
                atendimento.data_atendimento,
                atendimento.descricao_atendimento,
                GROUP_CONCAT(curso.nome_curso SEPARATOR ', ') AS cursos_relacionados
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
                atendimento.codfuncionario_fk = 1
            GROUP BY 
                atendimento.codatendimento;
            ");

            $stmt->bindParam(':codFuncionario', $codFuncionario, \PDO::PARAM_INT);
            $stmt->execute();

            $relatorio = $stmt->fetchAll();

            return $relatorio;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }

    }

    public function getTipoAtendimento() 
    {
        $conn = $this->connect();

        try {
            $stmt = $conn->query('SELECT * FROM tipo_atendimento');
            $tipo_atendimento = $stmt->fetchAll();

            return $tipo_atendimento;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function getCursos() 
    {
        $conn = $this->connect();

        try {
            $stmt = $conn->query('SELECT * FROM curso');
            $cursos = $stmt->fetchAll();

            return $cursos;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function countAtendimento() 
    {
        $conn = $this->connect();
    
        try {
            $query = "SELECT 
                        ta.nome_tipo, 
                        COUNT(a.codatendimento) AS total_atendimentos_tipo
                     FROM 
                        atendimento a
                     INNER JOIN 
                        tipo_atendimento ta ON a.codtipo_atendimento_fk = ta.codtipo_atendimento
                     GROUP BY 
                        ta.nome_tipo";
    
            $stmt = $conn->prepare($query);
            $stmt->execute();
    
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
            // Obtenha o total geral de atendimentos
            $queryTotal = "SELECT COUNT(*) AS total_atendimentos FROM atendimento";
            $stmtTotal = $conn->prepare($queryTotal);
            $stmtTotal->execute();
            $totalGeral = $stmtTotal->fetchColumn();
    
            // Adicione o total geral à matriz de resultados
            $result[] = array('nome_tipo' => 'Total Geral', 'total_atendimentos_tipo' => $totalGeral);
    
            return $result;
        } catch (\PDOException $e) {
            return "Erro ao contar atendimentos: " . $e->getMessage();
        }
    }
    
    public function countAtendimentoDiaAtual() 
    {
        $conn = $this->connect();

        try {
            // Obtenha a data atual
            $dataAtual = date('Y-m-d');

            // Consulta para contar o número de atendimentos de cada tipo no dia atual
            $query = "SELECT 
                        ta.nome_tipo, 
                        COUNT(a.codatendimento) AS total_atendimentos_tipo
                    FROM 
                        atendimento a
                    INNER JOIN 
                        tipo_atendimento ta ON a.codtipo_atendimento_fk = ta.codtipo_atendimento
                    WHERE 
                        DATE(a.data_atendimento) = :data_atual
                    GROUP BY 
                        ta.nome_tipo";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':data_atual', $dataAtual);
            $stmt->execute();

            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            // Consulta para contar o número total de atendimentos no dia atual
            $queryTotal = "SELECT COUNT(*) AS total_atendimentos FROM atendimento WHERE DATE(data_atendimento) = :data_atual";
            $stmtTotal = $conn->prepare($queryTotal);
            $stmtTotal->bindParam(':data_atual', $dataAtual);
            $stmtTotal->execute();
            $totalGeral = $stmtTotal->fetchColumn();

            // Adicione o total geral à matriz de resultados
            $result[] = array('nome_tipo' => 'Total Geral', 'total_atendimentos_tipo' => $totalGeral);

            return $result;
        } catch (\PDOException $e) {
            return "Erro ao contar atendimentos: " . $e->getMessage();
        }
    }
    
}
?>