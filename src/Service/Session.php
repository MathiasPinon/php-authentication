<?php

declare(strict_types=1);

namespace Service;

use Service\Exception\SessionException;

class Session
{
    /**
     * @throws SessionException
     */
    public static function start()
    {
        if (PHP_SESSION_DISABLED == session_status()) {
            throw new SessionException('Erreur Session désactivé');
        }
        if (PHP_SESSION_ACTIVE == session_status()) {
            return null;
        }

        if (PHP_SESSION_NONE == session_status()) {
            if (headers_sent()) {
                throw new SessionException('Headers already sent');
            }
            session_start();
        }
        if (PHP_SESSION_ACTIVE !== session_status()) {
            throw new SessionException('Session doesnt start');
        }
    }
}
