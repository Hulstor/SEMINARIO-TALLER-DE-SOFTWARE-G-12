<?php

require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../models/Medico.php';

class MedicoController {

    private $medico;

    public function __construct(){
        $this->medico = new Medico();
    }

    public function index(){

        $medicos = $this->medico->obtenerTodos();

        require_once __DIR__ . '/../views/medicos/index.php';
    }

    public function crear(){

        require_once __DIR__ . '/../views/medicos/crear.php';
    }

    public function guardar(){

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $data = [
                'nombre'=>trim($_POST['nombre']),
                'apellido'=>trim($_POST['apellido']),
                'especialidad'=>trim($_POST['especialidad']),
                'telefono'=>trim($_POST['telefono']),
                'email'=>trim($_POST['email'])
            ];

            if(empty($data['nombre']) || empty($data['apellido']) || empty($data['especialidad'])){
                $_SESSION['error'] = "Nombre, apellido y especialidad son obligatorios.";
                header("Location: index.php?controller=medico&action=crear");
                exit;
            }

            $this->medico->crear($data);

            $_SESSION['success'] = "Médico registrado correctamente.";
            header("Location: index.php?controller=medico&action=index");
            exit;
        }
    }
}