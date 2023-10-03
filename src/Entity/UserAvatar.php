<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class UserAvatar
{
    private int $id;
    private ?string $avatar;

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public static function findById(int $userId)
    {
        $sql = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id , avatar
            FROM User 
            WHERE id = :id 
SQL
        );
        $sql->execute([':id' => $userId]);

        $sql->setFetchMode(\PDO::FETCH_CLASS, UserAvatar::class)
        ;
        $user = $sql->fetch();
        if($user === false ){
            throw new EntityNotFoundException("Il n'y a pas de ligne séléctionnée");
        }
        return $user ;
    }
}
