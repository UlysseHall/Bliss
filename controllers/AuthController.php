<?php

namespace Controllers;

use Repository\userRepository;

class AuthController {

    function loginAction($twig, $bdd) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $req = $bdd->prepare("SELECT username FROM user WHERE username = :username AND password = :password");
            $req->execute([
                'username' => $_POST['username'],
                'password' => md5($_POST['password'])
            ]);

            if($req->fetch()) {
                $rep = new userRepository();
                $id = $rep->getIdByName($bdd, $_POST['username']);
                $_SESSION['user_id'] = intval($id);

                header('Location: ?action=home');
            } else {
                header('Location: ?action=login');
            }

        } else {
            echo $twig->render('Auth/login.html');
        }
    }

    function registerAction($twig, $bdd) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $req = $bdd->prepare("SELECT username FROM user WHERE username = :username");
            $req->execute(['username' => $_POST['username']]);

            if($req->fetch()) {
                echo $twig->render('Auth/register.html', ['error' => 'Username already taken']);
                return false;
            }

            $req = $bdd->prepare("SELECT username FROM user WHERE email = :email");
            $req->execute(['email' => $_POST['email']]);

            if($req->fetch()) {
                echo $twig->render('Auth/register.html', ['error' => 'Email already taken']);
                return false;
            }

            $req = $bdd->prepare("INSERT INTO user(email, username, password) VALUES (:email, :username, :password)");
            $req->execute([
                'email' => $_POST['email'],
                'username' => $_POST['username'],
                'password' => md5($_POST['password'])
            ]);

            $rep = new userRepository();
            $id = $rep->getIdByName($bdd, $_POST['username']);
            $_SESSION['user_id'] = intval($id);

            header('Location: ?action=home');
        } else {
            echo $twig->render('Auth/register.html');
        }
    }

}