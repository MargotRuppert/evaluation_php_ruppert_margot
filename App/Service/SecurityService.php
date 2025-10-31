<?php

namespace App\Service;

use App\Repository\UsersRepository;
use App\Utils\Tools;
use App\Entity\Users;
use Mithridatem\Validation\Validator;
use Mithridatem\Validation\Exception\ValidationException;

class SecurityService
{
    private readonly UsersRepository $usersRepository;
    private readonly Validator $validator;


    public function __construct()
    {
        $this->usersRepository = new UsersRepository();
        $this->validator = new Validator();
    }

    //ajouter un utilisateur à la bdd
    public function register(Users $user):string
    {
        //test si les champs sont remplis ou non
        if(empty($user->getFirstname()) || empty($user->getLastname()) || empty($user->getEmail() || empty($user->getPassword()))){
            return "Veuillez remplir tous les champs";
        }
        //Nettoyer les entrées
        
        // $user = Tools::sanitize($user);

        //Test si l'utilisateur existe 
        if ($this->usersRepository->isUserExistByEmail($user->getEmail())) {
            return "Les informations données ne sont pas bonnes";
        }

        //hasher le mdp
        $user->hashPassword();

        try {
            //enregistrement en bdd
            $this->usersRepository->saveUser($user);
        } catch (\PDOException $message) {
            return "Erreur d'enregistrement";
        }
        return "Le compte " . $user->getEmail() . " a bien été ajouté en BDD";

    }

    //methode de la connexion
    public function connexion(array $post): string
    {
        //Nettoyer
        // $user = Tools::sanitize($post);

        //Récupére l'objet User
        $user = $this->usersRepository->findUserByEmail($post["email"]);
        
        //Si le compte n'existe pas
        if (!isset($user)) {
            return "Les informations de connexion email et ou password sont invalides";
        }
        
        //test si les champs sont valides
        try {
            $this->validator->validate($user);
        } catch (ValidationException $e) {
            return $e->getMessage();
        }

        //Test si le password est correct
        if ($user instanceof Users && $user->verifPassword($post["password"])) {
            $this->onAuthentificationSuccess($user);
            return "Connecté";
        }

        $this->onAuthentificationFailed();
        
        return "Les informations de connexion email et ou password ne sont pas correctes";
    }

    private function onAuthentificationSuccess(Users $user): void 
    {
        //Création des super globales de session
        $_SESSION["email"] = $user->getEmail();
        $_SESSION["firstname"] = $user->getFirstname();
        $_SESSION["lastname"] = $user->getLastname();
        header("Refresh:2; url=/");
    }

    private function onAuthentificationFailed(): void
    {
        session_destroy();
        header("Refresh:3; url=/login");
    }

    //Logique métier de la déconnexion
    public function deconnexion() {
        session_destroy();
        header("Location:/login");
    }

}
