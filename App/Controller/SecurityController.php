<?php

namespace App\Controller;
use App\Service\SecurityService;
use App\Entity\Users;

class SecurityController
{
    private readonly SecurityService $securityService;

    public function __construct()
    {
        $this->securityService = new SecurityService();
    }
    
    public function render(string $template, ?string $title, array $data = []): void
    {
        include __DIR__ . "/../../templates/template_" . $template . ".php";
    }

    //methode pour register un user
    public function register() {
        //Test si le formulaire est submit
        if (isset($_POST["submit"])) {

            $data["message"]= $this->securityService->register(new Users($_POST["firstname"],$_POST["lastname"],$_POST["email"],$_POST["password"]));
        }
        
        //rendu de la vue
        $this->render('register','register', $data ?? []);
    }


    //methode pour connecter un user
    public function login() {
        if (isset($post["submit"])) {
            $data["message"] = $this->securityService->connexion($_POST);
        }

        $this->render('login','connexion',$data??[]);
    }

    //methode pour déconnecter un user
    public function logout() {
        $this->securityService->deconnexion();
    }
}
