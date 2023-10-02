<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\AppWebPage;

$authentication = new UserAuthentication();
$title = 'Zone membre connecté';
$user = $authentication->getUser();
$p = new AppWebPage($title);
// Un utilisateur est-il connecté ?

if (!$authentication->isUserConnected()) {
    header("Location: /form.php");
    exit;
}


$p->appendContent(<<<HTML
        <h1>$title</h1>
        <p> {$user->getFirstName()}
HTML
);

echo $p->toHTML();
