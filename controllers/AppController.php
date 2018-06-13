<?php

namespace Controllers;

class AppController {

    function homeAction($twig, $bdd) {
        echo $twig->render('App/home.html');
    }

    function agendaAction($twig, $bdd) {
        echo $twig->render('App/agenda.html');
    }

    function commandAction($twig, $bdd) {
        echo $twig->render('App/command.html');
    }

    function customerDetailAction($twig, $bdd) {
        echo $twig->render('App/customerDetail.html');
    }

    function customerListAction($twig, $bdd) {
        echo $twig->render('App/customerList.html');
    }

    function productDetailAction($twig, $bdd) {
        echo $twig->render('App/productDetail.html');
    }

    function productListAction($twig, $bdd) {
        echo $twig->render('App/productList.html');
    }

}