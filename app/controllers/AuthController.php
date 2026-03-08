<?php

require_once __DIR__ . '/../models/Usuario.php';

class AuthController {

    public function login(){

        require_once __DIR__ . '/../views/login.php';
    }


    public function autenticar(){

        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $usuarioModel = new Usuario();

        $usuario = $usuarioModel->buscarPorEmail($email);

        if(!$usuario){
            echo "Usuario no encontrado";
            return;
        }

        if(!password_verify($password,$usuario['password'])){
            echo "Contraseña incorrecta";
            return;
        }

        session_start();

        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        $_SESSION['usuario_rol'] = $usuario['rol'];

        header("Location: index.php");
        exit;

    }


    public function logout(){

        session_start();
        session_destroy();

        header("Location: index.php?controller=auth&action=login");
        exit;

    }

}