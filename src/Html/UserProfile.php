<?php

declare(strict_types=1);

namespace Html;
use Entity\User;
use Html\StringEscaper;

class UserProfile
{
    use StringEscaper;

    public function __construct(User $user){
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function ToHtml(){

        return <<<HTML
                <!doctype HTML>
                <html>
                    <head>
                        <meta charset="utf-8">
                        <title> User Profil</title>
                    </head>
                    <body>
                        <p> Nom </p>    
                        <blockquote> <p>{$this->escapeString($this->user->getLastName()) }</p></blockquote>
                        <p> Prénom </p>    
                        <blockquote> <p> {$this->escapeString($this->user->getFirstName())}</p></blockquote>
                        <p> login </p>    
                        <blockquote> <p> {$this->escapeString($this->user->getLogin())}</p></blockquote>
                        <p> Prénom </p>    
                        <blockquote> <p> {$this->escapeString($this->user->getPhone())}</p></blockquote>
                    </body>
                </html>
HTML;

    }

}