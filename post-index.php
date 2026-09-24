<?php

require_once __DIR__ . '/classes/crud.php';

$crud = new Crud();

$sql = "SELECT
            p.*,
            u.Nom AS Auteur,
            GROUP_CONCAT(
                c.Nom
                ORDER BY c.Nom
                SEPARATOR ', '
            ) AS Categories
        FROM Posts p
        INNER JOIN Users u
            ON p.Users_idUsers = u.idUsers
        LEFT JOIN Post_categorie pc
            ON p.idPosts = pc.Posts_idPosts1
        LEFT JOIN Categories c
            ON pc.Categories_idCategories = c.idCategories
        GROUP BY p.idPosts
        ORDER BY p.Create_at DESC";

$posts = $crud
    ->query($sql)
    ->fetchAll();

$pageTitle = 'Articles';

require_once __DIR__ . '/includes/header.php';

?>

<section class="section-heading">
    <div>

        <h1>
            Tous les articles
        </h1>
    </div>

    <a
        class="button"
        href="post-create.php"
    >
        Ajouter un article
    </a>
</section>

<?php if (!$posts): ?>

    <div class="empty">
        Aucun article.
    </div>

<?php else: ?>

    <div class="grid">

        <?php foreach ($posts as $post): ?>

            <article class="card">
                <p class="tag">
                    <?=
                        htmlspecialchars(
                            $post['Categories']
                            ?? 'Sans catégorie'
                        )
                    ?>
                </p>

                <h2>
                    <?= htmlspecialchars($post['Titre']) ?>
                </h2>

                <p>
                    <?=
                        htmlspecialchars(
                            mb_strimwidth(
                                $post['Contenu'],
                                0,
                                170,
                                '…'
                            )
                        )
                    ?>
                </p>

                <p class="meta">
                    Par <?= htmlspecialchars($post['Auteur']) ?>
                </p>

                <div class="actions">
                    <a
                        href="post-show.php?id=<?= (int) $post['idPosts'] ?>"
                    >
                        Voir
                    </a>

                    <a
                        href="post-edit.php?id=<?= (int) $post['idPosts'] ?>"
                    >
                        Modifier
                    </a>

                    <form
                        action="post-delete.php"
                        method="post"
                        onsubmit="return confirm('Supprimer cet article?');"
                    >
                        <input
                            type="hidden"
                            name="id"
                            value="<?= (int) $post['idPosts'] ?>"
                        >

                        <button
                            class="link danger"
                            type="submit"
                        >
                            Supprimer
                        </button>
                    </form>
                </div>
            </article>

        <?php endforeach; ?>

    </div>

<?php endif; ?>

<?php

require_once __DIR__ . '/includes/footer.php';

?>