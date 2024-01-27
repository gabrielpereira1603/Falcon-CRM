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

            return $clientes; // Retorna array de clientes para uso na view
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
}
?>