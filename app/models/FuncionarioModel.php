<?php

namespace app\models;

class FuncionarioModel extends Connection
{
    public function autenticarUser($login, $senha, $nome_funcionario) 
    {
        if (empty($login) || empty($senha) || empty($nome_funcionario)) {
            $_SESSION['error'] = 'Por favor, preencha todos os campos.';
            return false;
        }
    
        $conn = $this->connect();
        // Converter o nome do funcionário para maiúsculas
        // $nome_funcionario = strtoupper($nome_funcionario);
        try {
            // Consultar se o usuário já existe
            $stmt = $conn->prepare('SELECT  
                codfuncionario, 
                login, 
                nome_funcionario, 
                senha 
            FROM 
                funcionario 
            WHERE 
                login = :login');
    
            if ($stmt === false) {
                throw new \Exception('Houve um erro na preparação da consulta SQL');
            }
    
            $stmt->execute(['login' => $login]);
            $funcionario = $stmt->fetch();
    
            if (!$funcionario) {
                // Se o usuário não existe, criar um novo registro
                $hashSenha = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $conn->prepare('INSERT INTO funcionario (login, senha, nome_funcionario) VALUES (:login, :senha, :nome_funcionario)');
                $stmt->execute(['login' => $login, 'senha' => $hashSenha, 'nome_funcionario' => $nome_funcionario]);
    
                // Recuperar o código do novo usuário
                $codFuncionario = $conn->lastInsertId();
    
                // Armazenar os dados na sessão
                $_SESSION['autenticado'] = true;
                $_SESSION['login'] = $login;
                $_SESSION['nome_funcionario'] = $nome_funcionario;
                $_SESSION['codfuncionario'] = $codFuncionario;
    
                return true;
            } else {
                // Se o usuário já existe, verificar a senha
                if (password_verify($senha, $funcionario['senha'])) {
                    // Armazenar os dados na sessão
                    $_SESSION['autenticado'] = true;
                    $_SESSION['login'] = $login;
                    $_SESSION['nome_funcionario'] = $funcionario['nome_funcionario'];
                    $_SESSION['codfuncionario'] = $funcionario['codfuncionario'];
    
                    return true;
                }
            }
    
            $_SESSION['error'] = 'Login ou senha incorretos.';
            return false;
        } catch (\PDOException $e) {
            die("Erro de conexão: " . $e->getMessage());
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    
        return false;
    }
    
}