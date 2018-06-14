<?php

namespace Repository;

class productRepository {

    function getProducts($bdd) {
        $req = $bdd->prepare("
            SELECT
                p.id, p.reference, p.description
            FROM
                product p
            WHERE
                p.user_id = :userId
        ");

        $req->execute(['userId' => $_SESSION['user_id']]);

        $products = [];

        while ($row = $req->fetch())
        {
            $product = [];
            $product['id'] = $row['id'];
            $product['reference'] = $row['reference'];
            $product['description'] = $row['description'];
            $products[] = $product;
        }

        return $products;
    }

}