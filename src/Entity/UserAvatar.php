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

    /**
     * @throws EntityNotFoundException
     */
    public static function findById(int $userId)
    {
        $sql = MyPdo::getInstance()->prepare(
            <<<SQL
            SELECT id , avatar
            FROM user 
            WHERE id = :id 
SQL
        );
        $sql->execute([':id' => $userId]);

        $sql->setFetchMode(\PDO::FETCH_CLASS, UserAvatar::class)
        ;
        $user = $sql->fetch();
        if (false === $user) {
            throw new EntityNotFoundException("Il n'y a pas de ligne séléctionnée");
        }

        return $user;
    }

    /**
     * @param string|null $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function save():UserAvatar
    {
        $sql = MyPdo::getInstance()->prepare(
          <<<SQL
            UPDATE user
            SET avatar = :avatar 
            WHERE id = :id
SQL
        );
        $sql->execute([':avatar'=>$this->avatar, ':id'=>$this->id ]);
        return $this ;
    }
}
