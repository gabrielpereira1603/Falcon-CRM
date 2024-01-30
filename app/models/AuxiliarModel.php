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

    public function getAtendimentos()
    {
        $conn = $this->connect();

        try {
            $stmt = $conn->query('SELECT 
                cliente.nome_cliente,
                cliente.telefone_cliente,
                atendimento.curso_negociado,
                atendimento.lembrete
            FROM 
                atendimento
            JOIN 
                cliente ON atendimento.codcliente_fk = cliente.codcliente;');
            
            $atendimentos = $stmt->fetchAll();

            return $atendimentos;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        }
    }

    public function getRelatorio() 
    {                               
        $conn = $this->connect();

        try {
            $codFuncionario = $_SESSION['codfuncionario'];

            $stmt = $conn->prepare('SELECT 
                                        cliente.nome_cliente,
                                        cliente.telefone_cliente,
                                        atendimento.curso_negociado,
                                        atendimento.lembrete,
                                        atendimento.descricao_atendimento
                                    FROM 
                                        atendimento
                                    JOIN 
                                        cliente ON atendimento.codcliente_fk = cliente.codcliente
                                    WHERE 
                                        atendimento.codfuncionario_fk = :codFuncionario');

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
            $query = "SELECT ta.nome_tipo, COUNT(a.codatendimento) AS total_atendimentos 
                      FROM atendimento a
                      INNER JOIN tipo_atendimento ta ON a.codtipo_atendimento_fk = ta.codtipo_atendimento
                      GROUP BY ta.nome_tipo";
    
            $stmt = $conn->prepare($query);
            $stmt->execute();
    
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
            return $result;
        } catch (\PDOException $e) {
            return "Erro ao contar atendimentos: " . $e->getMessage();
        }
    }
    
}
?>