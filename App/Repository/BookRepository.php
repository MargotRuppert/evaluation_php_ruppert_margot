<?php

namespace App\Repository;

use App\Entity\Book;
use App\Database\Mysql;

class BookRepository{
    //etape de connexion à la BDD
    public \PDO $connexion;

    public function setConnexion(): void
    {
        $this->connexion = (new Mysql())->connectBdd();
    }

    public function __construct()
    {
        $this->setConnexion();
    }

     public function saveBook(Book $book): void
    {
        $sql = "INSERT INTO book(title,`description`, publication_date,id_users, id_category) VALUES (?,?,?,?,?)";
        $bdd = $this->connexion->prepare($sql);
        $bdd->bindValue(1, $book->getTitle(), \PDO::PARAM_STR);
        $bdd->bindValue(2, $book->getDescription(), \PDO::PARAM_STR);
        $bdd->bindValue(3, $book->getPublicationDate(), \PDO::PARAM_STR);
        $bdd->bindValue(4, $book->getUser()->getId(), \PDO::PARAM_STR);
        $bdd->bindValue(5, $book->getCategory()->getId(), \PDO::PARAM_STR);

        $bdd->execute();
    }

    //pour trouver un livre via l'id
    public function find(int $id): ?Book
    {
        $sql = "SELECT id, title, `description`, publication_date FROM book WHERE id = ?";
        $bdd = $this->connexion->prepare($sql);
        $bdd->bindParam(1, $id, \PDO::PARAM_INT);
        $bdd->execute();
        $book = $bdd->fetch(\PDO::FETCH_ASSOC);
        return $book;
    }


}