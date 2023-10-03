<?php

declare(strict_types=1);

use Entity\UserAvatar;

$page = new \Html\AppWebPage('Avatar');

if(isset($_GET['userId'])){
    try {
        $idAvatar = $_GET['userId'];
        $idAvatar = intval($idAvatar);
        $user = userAvatar::findById($idAvatar);
        $avatar = $user->getAvatar();
    } catch (\Entity\Exception\EntityNotFoundException $e) {
        $avatar = file_get_contents('img/default_avatar.png');
    }
}
else{
    $avatar = file_get_contents('img/default_avatar.png');
}
header("Content-Type: image/png");
//var_dump(http_response_code(200));
echo $avatar;
