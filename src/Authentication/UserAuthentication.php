<?php

declare(strict_types=1);

namespace Authentication;

use Authentication\Exception\AuthenticationException;
use Authentication\Exception\NotLoggedInException;
use Entity\User;
use Html\StringEscaper;
use Service\Exception\SessionException;
use Service\Session;

class UserAuthentication
{
    use StringEscaper;
    public const LOGIN_INPUT_NAME = 'login';
    public const PASSWORD_INPUT_NAME = 'password';
    private const SESSION_KEY = '__UserAuthentication__';
    private const SESSION_USER_KEY = 'user';
    private ?User $user = null;
    private const LOGOUT_INPUT_NAME = 'logout';

    public function loginForm(string $action, string $submitTest = 'OK'): string
    {
        $log = self::LOGIN_INPUT_NAME;
        $pass = self::PASSWORD_INPUT_NAME;

        return <<<HTML
                    <form action="{$action}" method="post" ">
                        <label> login
                        <input name="{$log}" type="text">
                        </label>
                        <label> password
                        <input name="{$pass}" type="password">
                        </label>
                        <button type="submit">{$this->escapeString($submitTest)}</button>
                    </form>
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
        // return isset($_SESSION[self::SESSION_USER_KEY]) && $_SESSION[self::SESSION_USER_KEY] instanceof User;
    }

    public function logoutForm(string $action, string $text): string
    {
        $log = self::LOGOUT_INPUT_NAME;

        return <<<HTML
                    <form action="{$action}" method="post" >
                    <button type="submit" name="$log">{$this->escapeString($text)}</button>
                    </form>
                HTML;
    }

    public function logoutIfRequested()
    {
        $log = self::LOGOUT_INPUT_NAME;
        if (isset($_POST[$log])) {
            $this->user = NULL ;
            Session::start();
            unset($_SESSION[self::SESSION_USER_KEY]);
        }
    }

    /**
     * @throws SessionException
     * @throws NotLoggedInException
     */
    public function getUserFromSession()
    {
        Session::start();
        if (isset($_SESSION[self::SESSION_USER_KEY])) {
            return $_SESSION[self::SESSION_USER_KEY];
        }
        throw new NotLoggedInException("Erreur il y a pas d'utilisateur dans la sesson");
    }

    /**
     * @throws NotLoggedInException|SessionException
     */
    public function __construct()
    {
        try {
            $this->user = $this->getUserFromSession();
        } catch (NotLoggedInException $exception) {
        }

    }

    /**
     * @throws NotLoggedInException
     */
    public function getUser()
    {
        if (isset($this->user)) {
            return $this->user;
        } else {
            throw new NotLoggedInException("Il y a pas de d'utilisateur dans la session");
        }
    }
}
