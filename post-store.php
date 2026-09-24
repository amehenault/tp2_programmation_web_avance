<?php

require_once __DIR__ . '/classes/crud.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: post-index.php');
    exit;
}

$crud = new Crud();

$titre = trim(
    $_POST['Titre']
    ?? ''
);

$contenu = trim(
    $_POST['Contenu']
    ?? ''
);

$idUser = (int) (
    $_POST['Users_idUsers']
    ?? 0
);

$categories = $_POST['categories'] ?? [];

if (
    $titre === ''
    || $contenu === ''
    || $idUser < 1
) {
    header('Location: post-create.php');
    exit;
}

$idPost = $crud->insert(
    'Posts',
    [
        'Titre' => $titre,
        'Contenu' => $contenu,
        'Create_at' => date('Y-m-d H:i:s'),
        'Users_idUsers' => $idUser
    ]
);

foreach ($categories as $idCategorie) {
    $crud->insert(
        'Post_categorie',
        [
            'Categories_idCategories' => (int) $idCategorie,
            'Posts_idPosts1' => $idPost
        ]
    );
}

header("Location: post-show.php?id=$idPost");
exit;