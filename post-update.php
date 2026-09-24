<?php

require_once __DIR__ . '/classes/crud.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: post-index.php');
    exit;
}

$crud = new Crud();

$id = (int) (
    $_POST['idPosts']
    ?? 0
);

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
    $id < 1
    || $titre === ''
    || $contenu === ''
    || $idUser < 1
) {
    header('Location: post-index.php');
    exit;
}

$crud->update(
    'Posts',
    [
        'idPosts' => $id,
        'Titre' => $titre,
        'Contenu' => $contenu,
        'update_at' => date('Y-m-d H:i:s'),
        'Users_idUsers' => $idUser
    ],
    'idPosts'
);

$crud->delete(
    'Post_categorie',
    $id,
    'Posts_idPosts1'
);

foreach ($categories as $idCategorie) {
    $crud->insert(
        'Post_categorie',
        [
            'Categories_idCategories' => (int) $idCategorie,
            'Posts_idPosts1' => $id
        ]
    );
}

header("Location: post-show.php?id=$id");
exit;