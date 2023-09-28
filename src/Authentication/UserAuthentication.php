<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\AuthenticationException;
use Entity\User;
use Html\StringEscaper;
use Service\Session;

class UserAuthentication
{
    use StringEscaper;
    public const LOGIN_INPUT_NAME = 'login';
    public const PASSWORD_INPUT_NAME = 'password';
    private const SESSION_KEY = '__UserAuthentication__';
    private const SESSION_USER_KEY = 'user';
    private ?User $user = null;

    public function loginForm(string $action, string $submitTest = 'OK'): string
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

    public function getUserFromAuth()
    {
        $user = User::findByCredentials($_POST['login'], $_POST['password']);
        if (null !== $user) {
            $this->setUser($user);

            return $user;
        } else {
            throw new AuthenticationException('Vous ne vous êtes pas authentifié');
        }
    }

    public function setUser(User $user): void
    {
        Session::start();
        $_SESSION[self::SESSION_USER_KEY] = $user;
    }

    public function isUserConnected(): bool
    {
        Session::start();
        if (isset($_SESSION[self::SESSION_USER_KEY])) {
            if ($_SESSION[self::SESSION_USER_KEY] instanceof User) {
                return true;
            }
        }

        return false;
        //return isset($_SESSION[self::SESSION_USER_KEY]) && $_SESSION[self::SESSION_USER_KEY] instanceof User;
    }
}
