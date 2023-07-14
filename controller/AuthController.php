<?php

require_once '../vendor/autoload.php';
require_once '../model/UserModel.php';
session_start();
class AuthController {
    private $model;
    private $twig;

    public function __construct($twig) {
        $this->model = new UserModel();

        $this->twig = $twig;
    }

    public function login($username, $password) {
        $user = $this->model->getByUsernameAndPassword($username, $password);

        if ($user) {
            #$_SESSION['user'] = $user;
            if ($user['isAdmin']) {
                $adminId = $this->model->getByAdminId($user['id']);
                $_SESSION['adminId'] = $adminId;
                header('Location: /projet_web/public/admin.php');
            } else {
                $clientId = $this->model->getByClientId($user['id']);
                $_SESSION['clientId'] = $clientId;
                header('Location: /projet_web/public/user.php');
            }
        } else {
            return ['error' => 'Invalid username or password.'];
        }
    }

    public function render($view, $params = []) {
        echo $this->twig->render($view, $params);
    }
    
}
