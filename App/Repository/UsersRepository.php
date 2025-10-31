<?php

namespace App\Repository;


use App\Entity\Users;
use App\Database\Mysql;

class UsersRepository
{
    public \PDO $connexion;

    public function setConnexion(): void
    {
        $this->connexion = (new Mysql())->connectBdd();
    }

    public function __construct()
    {
        $this->setConnexion();
    }
    //bdduete auprès de la bdd
    public function saveUser(Users $user): void
    {
        $sql = "INSERT INTO users(firstname,lastname,email,`password`) VALUES (?,?,?,?)";
        $bdd = $this->connexion->prepare($sql);
        $bdd->bindValue(1, $user->getFirstname(), \PDO::PARAM_STR);
        $bdd->bindValue(2, $user->getLastname(), \PDO::PARAM_STR);
        $bdd->bindValue(3, $user->getEmail(), \PDO::PARAM_STR);
        $bdd->bindValue(4, $user->getPassword(), \PDO::PARAM_STR);

        $bdd->execute();
    }

    //check si l'utilisateur existe déjà ou non
    public function isUserExistByEmail(string $email): bool
    {
        $sql = "SELECT id FROM users WHERE email = ?";
        $bdd = $this->connexion->prepare($sql);
        $bdd->bindParam(1, $email, \PDO::PARAM_STR);
        $bdd->execute();

        //Test si le compte n'existe pas
        return $bdd->fetch(\PDO::FETCH_ASSOC);
    }

    //pour trouver un utilisateur via l'email
    public function findUserByEmail(string $email): ?Users
    {
        $sql = "SELECT id, firstname, lastname, email, `password` FROM users WHERE email = ?";
        $bdd = $this->connexion->prepare($sql);
        $bdd->bindParam(1, $email, \PDO::PARAM_STR);
        $bdd->execute();
        $user = $bdd->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

    //pour trouver un utilisateur via l'id
    public function find(int $id): ?Users
    {
        $sql = "SELECT id, firstname, lastname, email,`password` FROM users WHERE id = ?";
        $bdd = $this->connexion->prepare($sql);
        $bdd->bindParam(1, $id, \PDO::PARAM_INT);
        $bdd->execute();
        $user = $bdd->fetch(\PDO::FETCH_ASSOC);
        return $user;
    }

}
