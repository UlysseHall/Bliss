<?php

namespace Repository;

class orderRepository {

    function getDailyOrders($bdd) {
        $req = $bdd->prepare("
            SELECT
                o.sending_ref, o.sending_date, o.state, c.name
            FROM
                orders o
            JOIN customer c ON
                o.customer_id = c.id
            WHERE
                o.user_id = :userId AND DATE(o.date) = DATE(NOW())
        ");

        $req->execute(['userId' => $_SESSION['user_id']]);

        $orders = [];

        while ($row = $req->fetch())
        {
            $order = [];
            $order['name'] = $row['name'];
            $order['state'] = $row['state'];
            $order['date'] = $row['sending_date'];
            $order['reference'] = $row['sending_ref'];
            $orders[] = $order;
        }

        return $orders;
    }

    function getDailyCustomerOrders($bdd, $id) {
        $req = $bdd->prepare("
            SELECT
                o.sending_ref, o.sending_date, o.state, c.name
            FROM
                orders o
            JOIN customer c ON
                o.customer_id = c.id
            WHERE
                o.user_id = :userId AND DATE(o.date) = DATE(NOW()) AND o.customer_id = :customerId
        ");

        $req->execute(['userId' => $_SESSION['user_id'], 'customerId' => $id]);

        $orders = [];

        while ($row = $req->fetch())
        {
            $order = [];
            $order['name'] = $row['name'];
            $order['state'] = $row['state'];
            $order['date'] = $row['sending_date'];
            $order['reference'] = $row['sending_ref'];
            $orders[] = $order;
        }

        return $orders;
    }

}