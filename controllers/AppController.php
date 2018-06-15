<?php

namespace Controllers;

use Repository\meetingRepository;
use Repository\orderRepository;
use Repository\customerRepository;
use Repository\reportRepository;
use Repository\productRepository;

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
        $meetingRep = new meetingRepository();

        $meetings = $meetingRep->getMonthlyMeetings($bdd);

        echo $twig->render('App/agenda.html', ['meetings' => $meetings]);
    }

    function commandAction($twig, $bdd) {
        $orderRep = new orderRepository();

        $orders = $orderRep->getOrders($bdd);

        echo $twig->render('App/command.html', ['orders' => $orders]);
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

    function addCustomer($bdd) {
        $nameCompany = "coca";
        $name = 'lucas';
        $companyStatus = 'SARL';
        $phoneCompany = '06666666';
        $address = '3 rue bidon';
        $addressBilling = '3 rue thunes';
        $phone = '07777777';
        $email = 'oui@gmail.com';
        $prospect = 0;

        $req = $bdd->prepare("
            INSERT INTO
            customer(user_id, name, name_company, location, phone, phone_company, address, address_billing, email, prospect, company_status)
            VALUES (:userId, :name, :nameCompany, :location, :phone, :phoneCompany, :address, :addressBilling, :email, :prospect, :companyStatus)
         ");

        $req->execute([
            'userId' => $_SESSION['user_id'],
            'name' => $name,
            'nameCompany' => $nameCompany,
            'location' => $address,
            'phone' => $phone,
            'phoneCompany' => $phoneCompany,
            'address' => $address,
            'addressBilling' => $addressBilling,
            'email' => $email,
            'prospect' => $prospect,
            'companyStatus' => $companyStatus
        ]);

        return true;
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
        $productRep = new productRepository();

        $products = $productRep->getProducts($bdd);

        echo $twig->render('App/productList.html', [
            'products' => $products
        ]);
    }

}