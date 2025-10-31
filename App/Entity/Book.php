<?php
namespace App\Entity;

use App\Entity\Users;
use App\Entity\Category;
use DateTime;

class Book{

    private int $id;
    private string $title;
    private string $description;
    private DateTime $publicationDate;
    private ?string $author;
    private Users $user;
    private Category $category;

    public function __construct(string $title, string $description,
    DateTime $publicationDate){
        $this->title = $title;
        $this->description= $description;
        $this->publicationDate = $publicationDate;
        $this->user = new Users;
        $this->category = new Category;
    }

    //getters and setters
    public function getId(): int{
        return $this->id;
    }
    public function setId(int $id): void{
        $this->id = $id;
    }
    public function getTitle(): string{
        return $this->title;
    }
    public function setTitle(string $title): void{
        $this->title = $title;
    }
    public function getDescription(): string{
        return $this->description;
    }
    public function setDescription(string $description): void{
        $this->description = $description;
    }
    public function getPublicationDate(): DateTime{
        return $this->publicationDate;
    }
    public function setPublicationDate(DateTime $publicationDate): void{
        $this->publicationDate = $publicationDate;
    }
    public function getAuthor(): ?string{
        return $this->author;
    }
    public function setAuthor(?string $author): void{
        $this->author = $author;
    }
    public function getUser(): Users{
        return $this->user;
    }
    public function setUser(Users $user): void{
        $this->user = $user;
    }
    public function getCategory(): Category{
        return $this->category;
    }
    public function setCategory(Category $category): void{
        $this->category = $category;
    }

}