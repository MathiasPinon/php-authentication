<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\AppWebPage;

$authentication = new UserAuthentication();

$p = new AppWebPage('Authentification');
try {
    $user = $authentication->getUser();
    $p->appendContent(<<<HTML
<div>Id :  {$user->getId()}</div>
<div>Nom : {$user->getLastName()}</div>
<div>Prenom : {$user->getFirstName()}</div>
<div>Login :  {$user->getLogin()}</div>
<div>Téléphone {$user->getPhone()}</div>
HTML
    );
} catch (\Authentication\Exception\NotLoggedInException $e) {
    header('Location: /form.php');
} catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}");
}

// Envoi du code HTML au navigateur du client
echo $p->toHTML();
