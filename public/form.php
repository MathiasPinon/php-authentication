<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\AppWebPage;

// Création de l'authentification
$authentication = new UserAuthentication();

$p = new AppWebPage('Authentification');
$authentication->logoutIfRequested();

$p->appendCSS(<<<CSS
    form input {
        width : 4em ;
    }
CSS
);
try {
    $user = $authentication->getUser();
    $form = $authentication->logoutForm('form.php', 'Logout');
    $p->appendContent(<<<HTML
    {$form}
    <br>
    {$user->getFirstName()}
    {$user->getLastName()}
HTML
    );
} catch (\Authentication\Exception\NotLoggedInException $e){
    // Production du formulaire de connexion
    $form = $authentication->loginForm('auth.php');
    $p->appendContent(<<<HTML
    {$form}
    <p>Pour faire un test : essai/toto
HTML
    );
}

echo $p->toHTML();
