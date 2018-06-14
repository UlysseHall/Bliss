<?php

namespace Controllers;

use Repository\meetingRepository;
use Repository\orderRepository;
use Repository\customerRepository;
use Repository\reportRepository;

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
        $customerRep = new customerRepository();
        $reportRep = new reportRepository();
        $orderRep = new orderRepository();

        $customer = $customerRep->getCustomerDetails($bdd, $_GET['id']);
        $reports = $reportRep->getCustomerReport($bdd, $_GET['id']);
        $orders = $orderRep->getDailyCustomerOrders($bdd, $_GET['id']);

        echo $twig->render('App/customerDetail.html', [
            'customer' => $customer,
            'reports' => $reports,
            'orders' => $orders
        ]);
    }

    function customerListAction($twig, $bdd) {
        $customerRep = new customerRepository();

        $customersList = $customerRep->getAllCustomers($bdd);
        $prospectsList = $customerRep->getAllProspects($bdd);

        echo $twig->render('App/customerList.html', [
            'customers' => $customersList,
            'prospects' => $prospectsList
        ]);
    }

    function productDetailAction($twig, $bdd) {
        echo $twig->render('App/productDetail.html');
    }

    function productListAction($twig, $bdd) {
        echo $twig->render('App/productList.html');
    }

}