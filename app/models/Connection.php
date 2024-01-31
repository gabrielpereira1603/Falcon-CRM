<?php

namespace app\models;

abstract class Connection
{
    private $bdname = 'mysql:host=localhost;dbname=falconcrm';
    private $user = 'root';
    private $pass = '';

    protected function connect()
    {
        try {
            $conn = new \PDO($this->bdname, $this->user, $this->pass);
            $conn->exec("set names utf8");
            return $conn; // Retorne a instância do PDO
        } catch (\PDOException $erro) {
            echo $erro->getMessage();
        }
    }
}