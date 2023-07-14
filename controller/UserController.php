<?php
require_once '../model/UserModel.php';
require_once '../vendor/autoload.php';


class UserController {
    private $model;
    private $twig;

    public function __construct() {
        $this->model = new UserModel();
        // Initialize the Twig environment
        $loader = new \Twig\Loader\FilesystemLoader('../view');
        $this->twig = new \Twig\Environment($loader);
    }

    public function create($username, $password, $isAdmin, $poste) {
        // Use the model to create a new user
        $this->model->create($username, $password, $isAdmin, $poste);

        // Redirect to the user list page (or wherever you want)
        // header('Location: user_list.php');
    }

    public function getById($id) {
        // Use the model to get a user by id
        $user = $this->model->getById($id);

        // Render the user detail view with the user data
        echo $this->twig->render('user_detail.html.twig', ['user' => $user]);
    }

    // Add more methods as needed
}
?>
