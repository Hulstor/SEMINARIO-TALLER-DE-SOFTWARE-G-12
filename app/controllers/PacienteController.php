<?php

require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../models/Paciente.php';

class PacienteController {

    private $paciente;

    public function __construct(){
        $this->paciente = new Paciente();
    }

    public function index(){

        $pacientes = $this->paciente->obtenerTodos();

        require_once __DIR__ . '/../views/pacientes/index.php';
    }

    public function crear(){

        require_once __DIR__ . '/../views/pacientes/crear.php';
    }

    public function guardar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'nombre' => trim($_POST['nombre']),
                'apellido' => trim($_POST['apellido']),
                'cedula' => trim($_POST['cedula']),
                'telefono' => trim($_POST['telefono']),
                'email' => trim($_POST['email']),
                'fecha_nacimiento' => $_POST['fecha_nacimiento']
            ];

            if(empty($data['nombre']) || empty($data['apellido']) || empty($data['cedula'])){
                $_SESSION['error'] = "Nombre, apellido y cédula son obligatorios.";
                header("Location: index.php?controller=paciente&action=crear");
                exit;
            }

            $this->paciente->crear($data);

            $_SESSION['success'] = "Paciente registrado correctamente.";
            header("Location: index.php?controller=paciente&action=index");
            exit;
        }
    }
}