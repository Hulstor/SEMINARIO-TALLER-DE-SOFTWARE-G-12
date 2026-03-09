<?php
session_start();

$controller = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;

if(!isset($_SESSION['usuario_id']) && $controller !== 'auth'){
    header("Location: index.php?controller=auth&action=login");
    exit;
}

if(isset($_SESSION['usuario_id']) && !$controller){
    header("Location: index.php?controller=cita&action=index");
    exit;
}

require_once __DIR__ . '/../routes/web.php';