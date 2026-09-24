<?php

require_once __DIR__ . '/classes/crud.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: post-index.php');
    exit;
}

$crud = new Crud();

$id = (int) ($_POST['id'] ?? 0);

if ($id > 0) {
    $crud->delete(
        'Post_categorie',
        $id,
        'Posts_idPosts1'
    );

    $crud->delete(
        'Posts',
        $id,
        'idPosts'
    );
}

header('Location: post-index.php');
exit;