<?php

require_once __DIR__ . '/classes/crud.php';

$crud = new Crud();

$sql = "SELECT
            p.*,
            u.Nom AS Auteur
        FROM Posts p
        INNER JOIN Users u
            ON p.Users_idUsers = u.idUsers
        ORDER BY p.Create_at DESC
        LIMIT 3";

$posts = $crud
    ->query($sql)
    ->fetchAll();

$pageTitle = 'Blogue coloré';

require_once __DIR__ . '/includes/header.php';

?>

<section class="hero">
    <h1>
        Des idées colorées pour créer et apprendre
    </h1>

    <a
        class="button"
        href="post-index.php"
    >
        Découvrir les articles
    </a>
</section>

<section class="section-heading">
    <div>
        <h2>
            Articles récents
        </h2>
    </div>

    <a href="post-index.php">
        Voir tout →
    </a>
</section>

<div class="grid">

    <?php foreach ($posts as $post): ?>

        <article class="card">
            <p class="meta">
                <?= htmlspecialchars($post['Auteur']) ?>

                ·

                <?= htmlspecialchars(
                    date(
                        'd/m/Y',
                        strtotime($post['Create_at'])
                    )
                ) ?>
            </p>

            <h3>
                <?= htmlspecialchars($post['Titre']) ?>
            </h3>

            <p>
                <?= htmlspecialchars(
                    mb_strimwidth(
                        $post['Contenu'],
                        0,
                        150,
                        '…'
                    )
                ) ?>
            </p>

            <a href="post-show.php?id=<?= (int) $post['idPosts'] ?>">
                Lire l’article →
            </a>
        </article>

    <?php endforeach; ?>

</div>

<?php

require_once __DIR__ . '/includes/footer.php';

?>