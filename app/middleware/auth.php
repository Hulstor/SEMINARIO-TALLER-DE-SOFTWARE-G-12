<?php

if(!isset($_SESSION['usuario_id'])){

header("Location: index.php?controller=auth&action=login");
exit;

}