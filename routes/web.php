<?php

$controller = $_GET['controller'] ?? 'paciente';
$action = $_GET['action'] ?? 'index';

switch($controller){

    case 'paciente':

        require_once __DIR__ . '/../app/controllers/PacienteController.php';
        $ctrl = new PacienteController();

        switch($action){

            case 'index':
                $ctrl->index();
            break;

            case 'crear':
                $ctrl->crear();
            break;

            case 'guardar':
                $ctrl->guardar();
            break;

        }

    break;


    case 'medico':

        require_once __DIR__ . '/../app/controllers/MedicoController.php';
        $ctrl = new MedicoController();

        switch($action){

            case 'index':
                $ctrl->index();
            break;

            case 'crear':
                $ctrl->crear();
            break;

            case 'guardar':
                $ctrl->guardar();
            break;

        }

    break;



    case 'cita':

        require_once __DIR__ . '/../app/controllers/CitaController.php';
        $ctrl = new CitaController();

        switch($action){

            case 'index':
                $ctrl->index();
            break;

            case 'crear':
                $ctrl->crear();
            break;

            case 'guardar':
                $ctrl->guardar();
            break;

            case 'completar':
                $ctrl->completar();
            break;

            case 'cancelar':
                $ctrl->cancelar();
            break;

            case 'eliminar':
                $ctrl->eliminar();
            break;

        }

    break;

    case 'auth':

        require_once __DIR__ . '/../app/controllers/AuthController.php';

        $ctrl = new AuthController();

        switch($action){

        case 'login':
        $ctrl->login();
        break;

        case 'autenticar':
        $ctrl->autenticar();
        break;

        case 'logout':
        $ctrl->logout();
        break;

        }

    break;

    case 'dashboard':

        require_once __DIR__ . '/../app/controllers/DashboardController.php';

        $ctrl = new DashboardController();

        switch($action){

        case 'index':
        $ctrl->index();
        break;

        }

    break;

}