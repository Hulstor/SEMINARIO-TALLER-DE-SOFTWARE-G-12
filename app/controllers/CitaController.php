<?php

require_once __DIR__ . '/../middleware/auth.php';
require_once __DIR__ . '/../models/Cita.php';
require_once __DIR__ . '/../models/Paciente.php';
require_once __DIR__ . '/../models/Medico.php';

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
            $_SESSION['error'] = "Todos los campos obligatorios deben completarse.";
            header("Location: index.php?controller=cita&action=crear");
            exit;
        }

        if(strtotime($fecha) < strtotime(date("Y-m-d"))){
            $_SESSION['error'] = "No se pueden crear citas en fechas pasadas.";
            header("Location: index.php?controller=cita&action=crear");
            exit;
        }

        if(strlen($motivo) > 200){
            $_SESSION['error'] = "El motivo no puede superar los 200 caracteres.";
            header("Location: index.php?controller=cita&action=crear");
            exit;
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
            $_SESSION['error'] = "El médico ya tiene una cita en ese horario.";
            header("Location: index.php?controller=cita&action=crear");
            exit;
        }

        $_SESSION['success'] = "La cita fue registrada correctamente.";
        header("Location: index.php?controller=cita&action=index");
        exit;
    }

    public function completar(){

        $id = intval($_GET['id'] ?? 0);

        if(!$id){
            $_SESSION['error'] = "ID de cita inválido.";
            header("Location: index.php?controller=cita&action=index");
            exit;
        }

        $this->cita->actualizarEstado($id,'completada');
        $_SESSION['success'] = "La cita fue marcada como completada.";

        header("Location: index.php?controller=cita&action=index");
        exit;
    }

    public function cancelar(){

        $id = intval($_GET['id'] ?? 0);

        if(!$id){
            $_SESSION['error'] = "ID de cita inválido.";
            header("Location: index.php?controller=cita&action=index");
            exit;
        }

        $this->cita->actualizarEstado($id,'cancelada');
        $_SESSION['info'] = "La cita fue cancelada.";

        header("Location: index.php?controller=cita&action=index");
        exit;
    }

    public function eliminar(){

        if(($_SESSION['usuario_rol'] ?? '') != 'admin'){
            $_SESSION['error'] = "No tienes permiso para eliminar citas.";
            header("Location: index.php?controller=cita&action=index");
            exit;
        }

        $id = intval($_GET['id'] ?? 0);

        if(!$id){
            $_SESSION['error'] = "ID de cita inválido.";
            header("Location: index.php?controller=cita&action=index");
            exit;
        }

        $this->cita->eliminar($id);
        $_SESSION['success'] = "La cita fue eliminada correctamente.";

        header("Location: index.php?controller=cita&action=index");
        exit;
    }
}