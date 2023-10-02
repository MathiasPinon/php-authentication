<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;

class UserAvatar
{
    private int $id;
    private ?string $avatar;

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public static function findById(int $userId){
        $sql = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id , avatar
            FROM User 
            WHERE id = :id 
SQL

        );
        $sql->setFetchMode(PDO:)
    }
}
