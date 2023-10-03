<?php

declare(strict_types=1);

use Authentication\UserAuthentication;
use Html\AppWebPage;

$authentication = new UserAuthentication();

$p = new AppWebPage('Authentification');
try {
    $user = $authentication->getUser();
    $html = new \Html\UserProfileWithAvatar($user);
    $p->appendContent($html->toHtml());
} catch (\Authentication\Exception\NotLoggedInException $e) {
    header('Location: /form.php');
} catch (Exception $e) {
    $p->appendContent("Un problème est survenu&nbsp;: {$e->getMessage()}");
}

// Envoi du code HTML au navigateur du client
echo $p->toHTML();
