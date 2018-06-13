<?php

namespace Controllers;

class AppController {

    function homeAction($twig, $bdd) {
        echo $twig->render('App/home.html');
    }

}