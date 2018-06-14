<?php

namespace Controllers;

use Repository\meetingRepository;
use Repository\orderRepository;
use Repository\customerRepository;

class AppController {

    function homeAction($twig, $bdd) {
        $meetingRep = new meetingRepository();
        $orderRep = new orderRepository();
        $customerRep = new customerRepository();

        $dailyMeetings = $meetingRep->getDailyMeetings($bdd);
        $monthlyMeetings = $meetingRep->getMonthlyMeetings($bdd);

        $dailyOrders = $orderRep->getDailyOrders($bdd);

        $topCustomers = $customerRep->getTopMonthlyCustomer($bdd);

        echo $twig->render('App/home.html', [
            'dailyMeetings' => $dailyMeetings,
            'monthlyMeetings' => $monthlyMeetings,
            'dailyOrders' => $dailyOrders,
            'topCustomers' => $topCustomers
        ]);
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