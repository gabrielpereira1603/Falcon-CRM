<?php

namespace app\models;
use PDFLib;

class RelatorioModel extends Connection
{

    public function buscarDadosRelatorio() {
        // Lógica para obter os dados necessários para o PDF do banco de dados
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
    
}