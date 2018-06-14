<?php

namespace Repository;

class reportRepository {

    function getCustomerReport($bdd, $id) {
        $req = $bdd->prepare("
            SELECT
                r.date, r.description
            FROM
                report r
            WHERE
                r.user_id = :userId
            AND
                r.customer_id = :customerId
        ");

        $req->execute(['userId' => $_SESSION['user_id'], 'customerId' => $id]);

        $reports = [];

        while ($row = $req->fetch())
        {
            $report = [];
            $report['date'] = $row['date'];
            $report['description'] = $row['description'];
            $reports[] = $report;
        }

        return $reports;
    }

}