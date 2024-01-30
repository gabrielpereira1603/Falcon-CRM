<?php

namespace app\models;

class CrudModel extends Connection {
    private $conn;
    private $table;

    public function __construct($conn, $table) {
        $this->conn = $conn;
        $this->table = $table;
    }

    // Função para criar um registro
    public function create($data) {
        // Implemente a lógica para inserir os dados no banco de dados
    }

    // Função para ler um registro
    public function read($id) {
        // Implemente a lógica para recuperar um registro com base no ID
    }

    // Função para atualizar um registro
    public function update($id, $data) {
        // Implemente a lógica para atualizar um registro com base no ID
    }

    // Função para excluir um registro
    public function delete($id) {
        // Implemente a lógica para excluir um registro com base no ID
    }
}