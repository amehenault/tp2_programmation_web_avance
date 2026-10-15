<?php

namespace App\Providers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View {

    static public function render($template, $data = []){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $notice = $_SESSION['notice'] ?? null;
        unset($_SESSION['notice']);

        $loader = new FilesystemLoader(__DIR__ . '/../views');

        $twig = new Environment($loader, [
            'autoescape' => 'html'
        ]);

        $twig->addGlobal('asset', ASSET);
        $twig->addGlobal('base', BASE);
        $twig->addGlobal('notice', $notice);

        echo $twig->render($template . '.php', $data);
    }

    static public function redirect($url, $message = null){
        if ($message !== null) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['notice'] = $message;
        }

        header('Location: ' . BASE . '/' . $url);
        exit;
    }
}