<?php
session_start();

require_once 'vendor/autoload.php';

use Controllers\AppController;
use Controllers\AuthController;

// BDD
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=bliss;charset=utf8', 'root', '');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

// Twig
$loader = new Twig_Loader_Filesystem('views/');
$twig = new Twig_Environment($loader, array(
    'cache' => false,
));

// Test if connected
$connected = false;
if(isset($_SESSION['connected']) && $_SESSION['connected'] === true) {
    $connected = true;
} else {
    $controller = new AuthController();
    if(isset($_GET['action']) && $_GET['action'] === 'register') {
        $controller->registerAction($twig, $bdd);
    } else {
        $controller->loginAction($twig, $bdd);
    }
}

// Router
if($connected) {
    if(isset($_GET['action'])) {
        $action = $_GET['action'] . "Action";
        switch ($action) {
            case 'loginAction':
            case 'registerAction':
                $controller = new AuthController();
                $controller->{$action}($twig, $bdd);
                break;

            case 'homeAction':
                $controller = new AppController();
                $controller->{$action}($twig, $bdd);
                break;
        }
    } else {
        $controller = new AppController();
        $controller->homeAction($twig, $bdd);
    }
}
