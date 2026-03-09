<?php

require_once __DIR__ . '/../models/Cita.php';
require_once __DIR__ . '/../models/Paciente.php';
require_once __DIR__ . '/../models/Medico.php';
require_once __DIR__ . '/../middleware/auth.php';

class CitaController {

    private $cita;

    public function __construct(){
        $this->cita = new Cita();
    }

    public function index(){

        $citas = $this->cita->obtenerTodas();

        require_once __DIR__ . '/../views/citas/index.php';
    }


    public function crear(){

        $pacienteModel = new Paciente();
        $medicoModel = new Medico();

        $pacientes = $pacienteModel->obtenerTodos();
        $medicos = $medicoModel->obtenerTodos();

        require_once __DIR__ . '/../views/citas/crear.php';
    }


public function guardar(){

    if($_SERVER['REQUEST_METHOD'] !== 'POST'){
        header("Location: index.php?controller=cita&action=index");
        exit;
    }

    $paciente_id = intval($_POST['paciente_id']);
    $medico_id = intval($_POST['medico_id']);
    $fecha = $_POST['fecha'];
    $hora_inicio = $_POST['hora_inicio'];
    $motivo = trim($_POST['motivo']);

    if(!$paciente_id || !$medico_id || empty($fecha) || empty($hora_inicio)){
        echo "Todos los campos obligatorios deben completarse.";
        return;
    }

    if(strtotime($fecha) < strtotime(date("Y-m-d"))){
        echo "No se pueden crear citas en fechas pasadas.";
        return;
    }

    if(strlen($motivo) > 200){
        echo "El motivo es demasiado largo.";
        return;
    }

    $hora_fin = date("H:i:s", strtotime($hora_inicio . " +30 minutes"));

    $data = [
        'paciente_id'=>$paciente_id,
        'medico_id'=>$medico_id,
        'fecha'=>$fecha,
        'hora_inicio'=>$hora_inicio,
        'hora_fin'=>$hora_fin,
        'motivo'=>$motivo
    ];

    $resultado = $this->cita->crear($data);

    if($resultado == "ocupado"){
        echo "El médico ya tiene una cita en ese horario.";
        return;
    }

    header("Location: index.php?controller=cita&action=index");
    exit;
}


    public function completar(){

        $id = $_GET['id'];

        $this->cita->actualizarEstado($id,'completada');

        header("Location: index.php?controller=cita&action=index");
        exit;
    }


    public function cancelar(){

        $id = $_GET['id'];

        $this->cita->actualizarEstado($id,'cancelada');

        header("Location: index.php?controller=cita&action=index");
        exit;
    }


    public function eliminar(){

        session_start();

        if($_SESSION['usuario_rol'] != 'admin'){
        echo "No tienes permiso para eliminar citas.";
        exit;
        }

        $id = $_GET['id'];

        $this->cita->eliminar($id);

        header("Location: index.php?controller=cita&action=index");
        exit;

    }

}