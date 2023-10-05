<?php

declare(strict_types=1);

namespace Html;

class UserProfileWithAvatar extends UserProfile
{
    public const AVATAR_INPUT_NAME =  'avatar' ;
    private string $formAction ;
    public function toHtml(){
        $id = $this->user->getId();
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
                        <img  
                         src="avatar.php?userId={$id}"
                        />
                    </body>
                </html>
HTML;

    }
}