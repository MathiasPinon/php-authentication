<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class User
{
    private int $id ;
    private string $firstName ;
    private string $lastName ;
    private string $login ;
    private string $phone ;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    public static function findByCredentials(string $login , string $password){
        $sql = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id , lastName , firstName , login , sha512pass, phone 
            FROM user 
            WHERE login = :login 
SQL
        );

        $sql->execute([":login" => $login]);
        $sql->setFetchMode(User::class);
        $user = $sql->fetch();
        if ($user === false) {
            throw new EntityNotFoundException("Login non trouvé");
        }
        return $user;
    }
}