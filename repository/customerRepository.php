<?php

namespace Repository;

class customerRepository {

    function getTopMonthlyCustomer($bdd) {
        $req = $bdd->prepare("
            SELECT
                c.id customer_id, c.name customer_name, o.id order_id, op.quantity product_quantity
            FROM
                order_products op
            JOIN
                orders o
            ON
                op.order_id = o.id
            JOIN
                customer c
            ON
                o.customer_id = c.id
            WHERE
                MONTH(o.date) = MONTH(NOW())
            AND
                o.user_id = :userId
            AND 
                o.state = 'SENT'
        ");

        $req->execute(['userId' => $_SESSION['user_id']]);

        $customers = [];

        while ($row = $req->fetch())
        {
            $exist = false;
            foreach ($customers as $customer) {
                if($customer['id'] == $row['customer_id']) {
                    $exist = array_search($customer, $customers);
                    break;
                }
            }

            if($exist !== false) {
                $customers[$exist]['products'] += $row['product_quantity'];
            } else {
                $customer = [];
                $customer['name'] = $row['customer_name'];
                $customer['id'] = $row['customer_id'];
                $customer['products'] = $row['product_quantity'];
                $customers[] = $customer;
            }
        }

        $products = [];
        foreach ($customers as $key => $customer) {
            $products[$key] = $customer['products'];
        }

        array_multisort($products, SORT_DESC, $customers);

        $customers = array_splice($customers, 0, 2);

        foreach ($customers as $key => $customer) {
            $customers[$key]['restocking'] = $this->getRestockingByClient($bdd, $customer['id']);
        }

        return $customers;
    }

    function getRestockingByClient($bdd, $id) {
        $req = $bdd->prepare("
            SELECT
                c.id customer_id, c.name customer_name, o.id order_id, op.quantity product_quantity
            FROM
                order_products op
            JOIN
                orders o
            ON
                op.order_id = o.id
            JOIN
                customer c
            ON
                o.customer_id = c.id
            WHERE
                MONTH(o.date) = MONTH(NOW())
            AND
                o.user_id = :userId
            AND 
                o.state = 'PENDING'
            AND
                c.id = :customerId
        ");

        $req->execute(['userId' => $_SESSION['user_id'], 'customerId' => $id]);

        $products = 0;

        while ($row = $req->fetch())
        {
            $products = $products + intval($row['product_quantity']);
        }

        return $products;
    }

}