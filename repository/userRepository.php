<?php

namespace Repository;

class userRepository {

    function getIdByName($bdd, $username) {
        $req = $bdd->prepare("
            SELECT
                id
            FROM
                `user`
            WHERE
                username = :username
        ");
        
        $req->execute(['username' => $username]);
        $id = $req->fetch();
        $id = $id['id'];

        return $id;
    }

}