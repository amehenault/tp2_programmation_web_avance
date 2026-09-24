<?php

require_once __DIR__ . '/classes/crud.php';

$crud = new Crud();

$users = $crud->select(
    'Users',
    'Nom'
);

$categories = $crud->select(
    'Categories',
    'Nom'
);

$pageTitle = 'Ajouter un article';

require_once __DIR__ . '/includes/header.php';

?>

<section class="form-shell">
    <h1>
        Ajouter un article
    </h1>

    <form
        action="post-store.php"
        method="post"
    >
        <label for="Titre">
            Titre
        </label>

        <input
            id="Titre"
            name="Titre"
            type="text"
            maxlength="255"
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
        ></textarea>

        <label for="Users_idUsers">
            Auteur
        </label>

        <select
            id="Users_idUsers"
            name="Users_idUsers"
            required
        >
            <option value="">
                Choisir un auteur
            </option>

            <?php foreach ($users as $user): ?>

                <option value="<?= (int) $user['idUsers'] ?>">
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
            Publier l’article
        </button>
    </form>
</section>

<?php

require_once __DIR__ . '/includes/footer.php';

?>