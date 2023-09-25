<?php

declare(strict_types=1);

namespace Authentication;

use Html\StringEscaper;

class UserAuthentication
{
    use StringEscaper ;
    const LOGIN_INPUT_NAME = "login";
    const PASSWORD_INPUT_NAME = "password";
    public function loginForm(string $action,string $submitTest = "OK") : string
    {

        return <<<HTML
                    <body>
                    <form action="{$action}" method="post" ">
                        <label> login
                        <input name="login" type="text">
                        </label>
                        <label> password
                        <input name="password" type="password">
                        </label>
                        <button type="submit">{$this->escapeString($submitTest)}</button>
                    </form>
                    </body> 
HTML;

    }
}

