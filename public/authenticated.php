<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\AppWebPage;

$authentication = new UserAuthentication();
$title = 'Zone membre connecté';
$p = new AppWebPage($title);
// Un utilisateur est-il connecté ?

if (!$authentication->isUserConnected()) {
    header("Location: /form.php");
    exit;
}

$user = $authentication->getUser();
$p->appendContent(<<<HTML
        <h1>$title</h1>
        <a href="user.php"> {$user->getFirstName()} </a>
HTML
);

echo $p->toHTML();
