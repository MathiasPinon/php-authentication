<?php

declare(strict_types=1);

namespace Authentication;
use Authentication\Exception\AuthenticationException;
use Entity\User;
use Html\StringEscaper;

class UserAuthentication
{
    use StringEscaper ;
    const LOGIN_INPUT_NAME = "login";
    const PASSWORD_INPUT_NAME = "password";
    public function loginForm(string $action,string $submitTest = "OK") : string
    {
        $log = self::LOGIN_INPUT_NAME;
        $pass = self::PASSWORD_INPUT_NAME;
        return <<<HTML
                    <body>
                    <form action="{$action}" method="post" ">
                        <label> login
                        <input name="{$log}" type="text">
                        </label>
                        <label> password
                        <input name="{$pass}" type="password">
                        </label>
                        <button type="submit">{$this->escapeString($submitTest)}</button>
                    </form>
                    </body> 
HTML;
    }

    public function getUserFromAuth(){
        $user = User::findByCredentials($_POST['login'],$_POST['password']);
         if( $user !== NULL) {
             return $user;
         }
         else {
             throw new AuthenticationException("Vous ne vous êtes pas authentifié");
         }
    }
}

