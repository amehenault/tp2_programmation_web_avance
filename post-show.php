<?php

require_once __DIR__ . '/classes/crud.php';

$crud = new Crud();

$id = (int) ($_GET['id'] ?? 0);

$post = $crud->selectId(
    'Posts',
    $id,
    'idPosts'
);

if (!$post) {
    header('Location: post-index.php');
    exit;
}

$auteur = $crud->selectId(
    'Users',
    $post['Users_idUsers'],
    'idUsers'
);

$sql = "SELECT c.Nom
        FROM Categories c
        INNER JOIN Post_categorie pc
            ON c.idCategories = pc.Categories_idCategories
        WHERE pc.Posts_idPosts1 = :id
        ORDER BY c.Nom";

$stmt = $crud->prepare($sql);

$stmt->execute([
    'id' => $id
]);

$categories = $stmt->fetchAll();

$pageTitle = $post['Titre'];

require_once __DIR__ . '/includes/header.php';

?>

<article class="article-full">
    <div class="article-topline">
        <p class="tag">
            <?=
                htmlspecialchars(
                    implode(
                        ' · ',
                        array_column(
                            $categories,
                            'Nom'
                        )
                    ) ?: 'Sans catégorie'
                )
            ?>
        </p>

        <p class="meta">
            <?=
                htmlspecialchars(
                    date(
                        'd/m/Y',
                        strtotime($post['Create_at'])
                    )
                )
            ?>
        </p>
    </div>

    <h1>
        <?= htmlspecialchars($post['Titre']) ?>
    </h1>

    <p class="byline">
        Par
        <?= htmlspecialchars(
            $auteur['Nom']
            ?? 'Auteur inconnu'
        ) ?>
    </p>

    <div class="article-content">
        <?= nl2br(
            htmlspecialchars($post['Contenu'])
        ) ?>
    </div>

    <div class="actions">
        <a
            class="button secondary"
            href="post-edit.php?id=<?= $id ?>"
        >
            Modifier
        </a>

        <a href="post-index.php">
            Retour aux articles
        </a>
    </div>
</article>

<?php

require_once __DIR__ . '/includes/footer.php';

?>