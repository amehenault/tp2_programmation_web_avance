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

    <link
        rel="stylesheet"
        href="css/style.css"
    >
</head>

<body>

<header class="site-header">
    <a
        class="logo"
        href="index.php"
    >
        Blogue coloré
    </a>

    <nav aria-label="Navigation principale">
        <a href="index.php">
            Accueil
        </a>

        <a href="post-index.php">
            Articles
        </a>

        <a
            class="button small"
            href="post-create.php"
        >
            Nouvel article
        </a>
    </nav>
</header>

<main class="container">