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

$users = $crud->select(
    'Users',
    'Nom'
);

$categories = $crud->select(
    'Categories',
    'Nom'
);

$sql = "SELECT Categories_idCategories
        FROM Post_categorie
        WHERE Posts_idPosts1 = :id";

$stmt = $crud->prepare($sql);

$stmt->execute([
    'id' => $id
]);

$selection = array_map(
    'intval',
    array_column(
        $stmt->fetchAll(),
        'Categories_idCategories'
    )
);

$pageTitle = 'Modifier l’article';

require_once __DIR__ . '/includes/header.php';

?>

<section class="form-shell">
    <h1>
        Modifier l’article
    </h1>

    <form
        action="post-update.php"
        method="post"
    >
        <input
            type="hidden"
            name="idPosts"
            value="<?= $id ?>"
        >

        <label for="Titre">
            Titre
        </label>

        <input
            id="Titre"
            name="Titre"
            type="text"
            maxlength="255"
            value="<?= htmlspecialchars($post['Titre']) ?>"
            required
        >

        <label for="Contenu">
            Contenu
        </label>

        <textarea
            id="Contenu"
            name="Contenu"
            rows="10"
            required
        ><?= htmlspecialchars($post['Contenu']) ?></textarea>

        <label for="Users_idUsers">
            Auteur
        </label>

        <select
            id="Users_idUsers"
            name="Users_idUsers"
            required
        >

            <?php foreach ($users as $user): ?>

                <option
                    value="<?= (int) $user['idUsers'] ?>"
                    <?=
                        (int) $user['idUsers']
                        === (int) $post['Users_idUsers']
                            ? 'selected'
                            : ''
                    ?>
                >
                    <?= htmlspecialchars($user['Nom']) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <fieldset>
            <legend>
                Catégories
            </legend>

            <div class="checkboxes">

                <?php foreach ($categories as $categorie): ?>

                    <label class="checkbox">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="<?= (int) $categorie['idCategories'] ?>"
                            <?=
                                in_array(
                                    (int) $categorie['idCategories'],
                                    $selection,
                                    true
                                )
                                    ? 'checked'
                                    : ''
                            ?>
                        >

                        <?= htmlspecialchars($categorie['Nom']) ?>
                    </label>

                <?php endforeach; ?>

            </div>
        </fieldset>

        <button
            class="button"
            type="submit"
        >
            Enregistrer
        </button>
    </form>
</section>

<?php

require_once __DIR__ . '/includes/footer.php';

?>