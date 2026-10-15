<?php

$pageTitle = $pageTitle ?? 'Blogue coloré';

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars($pageTitle) ?>
    </title>

    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

<header class="site-header">
    <a
        class="logo"
        href="/"
    >
        Blogue coloré
    </a>

    <nav aria-label="Navigation principale">
        <a href="/">
            Accueil
        </a>

        <a href="/articles">
            Articles
        </a>

        <a
            class="button small"
            href="/article/create"
        >
            Nouvel article
        </a>
    </nav>
</header>

<main class="container">