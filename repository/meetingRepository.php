<?php

namespace Repository;

class meetingRepository {

    function getDailyMeetings($bdd) {
        $req = $bdd->prepare("
            SELECT
                m.date, m.place, c.name
            FROM
                `meeting` m
            JOIN
                customer c
            ON
                m.customer_id = c.id
            WHERE
                m.user_id = :userId AND DATE(m.date) = DATE(NOW())
        ");

        $req->execute(['userId' => $_SESSION['user_id']]);

        $meetings = [];

        while ($row = $req->fetch())
        {
            $meeting = [];
            $meeting['place'] = $row['place'];
            $meeting['date'] = $row['date'];
            $meeting['name'] = $row['name'];
            $meetings[] = $meeting;
        }

        return $meetings;
    }

    function getMonthlyMeetings($bdd) {
        $req = $bdd->prepare("
            SELECT
                m.date, m.place, c.name
            FROM
                `meeting` m
            JOIN
                customer c
            ON
                m.customer_id = c.id
            WHERE
                m.user_id = :userId AND MONTH(m.date) = MONTH(NOW()) AND YEAR(m.date) = YEAR(NOW())
        ");

        $req->execute(['userId' => $_SESSION['user_id']]);

        $meetings = [];

        while ($row = $req->fetch())
        {
            $meeting = [];
            $meeting['place'] = $row['place'];
            $meeting['date'] = $row['date'];
            $meeting['name'] = $row['name'];
            $meetings[] = $meeting;
        }

        return $meetings;
    }

}