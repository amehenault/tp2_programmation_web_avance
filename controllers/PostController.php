<?php

require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/CategorieModel.php';

use App\Providers\View;

class PostController {

    public function index(){
        $postModel = new PostModel();

        $posts = $postModel->getAll();

        View::render('post-index', [
            'pageTitle' => 'Articles',
            'posts' => $posts
        ]);
    }

    public function show(){
        $id = (int) ($_GET['id'] ?? 0);

        $postModel = new PostModel();
        $post = $postModel->getById($id);

        if (!$post) {
            http_response_code(404);
            echo 'Article introuvable.';
            return;
        }

        View::render('post-show', [
            'pageTitle' => $post['Titre'],
            'post' => $post
        ]);
    }

    public function create(){
        $userModel = new UserModel();
        $categorieModel = new CategorieModel();

        $users = $userModel->getAll();
        $categories = $categorieModel->getAll();

        View::render('post-create', [
            'pageTitle' => 'Ajouter un article',
            'users' => $users,
            'categories' => $categories
        ]);
    }

    public function store(){
        $titre = trim($_POST['Titre'] ?? '');
        $contenu = trim($_POST['Contenu'] ?? '');
        $idUser = (int) ($_POST['Users_idUsers'] ?? 0);

        $categoryIds = $_POST['categories'] ?? [];

        $userModel = new UserModel();
        $categorieModel = new CategorieModel();

        $users = $userModel->getAll();
        $categories = $categorieModel->getAll();

        $errors = [];

        if ($titre === '') {
            $errors[] = 'Le titre est obligatoire.';
        } elseif (mb_strlen($titre) > 255) {
            $errors[] = 'Le titre doit contenir au maximum 255 caractères.';
        }

        if ($contenu === '') {
            $errors[] = 'Le contenu est obligatoire.';
        }

        $userIds = array_map(
            'intval',
            array_column($users, 'idUsers')
        );

        if (!in_array($idUser, $userIds, true)) {
            $errors[] = 'Choisis un auteur valide.';
        }

        if (!is_array($categoryIds)) {
            $errors[] = 'Les catégories sont invalides.';
            $categoryIds = [];
        }

        $categoryIds = array_unique(
            array_map('intval', $categoryIds)
        );

        $validCategoryIds = array_map(
            'intval',
            array_column($categories, 'idCategories')
        );

        if (array_diff($categoryIds, $validCategoryIds)) {
            $errors[] = 'Une catégorie sélectionnée est invalide.';
        }

        if (!$errors) {
            try {
                $postModel = new PostModel();

                $idPost = $postModel->createPost([
                    'Titre' => $titre,
                    'Contenu' => $contenu,
                    'Create_at' => date('Y-m-d H:i:s'),
                    'Users_idUsers' => $idUser
                ], $categoryIds);

                View::redirect(
                    'article?id=' . $idPost,
                    'L’article a été ajouté avec succès.'
                );
            } catch (PDOException $e) {
                $errors[] = 'Impossible d’enregistrer l’article pour le moment.';
            } catch (RuntimeException $e) {
                $errors[] = 'Impossible d’enregistrer l’article pour le moment.';
            }
        }

        View::render('post-create', [
            'pageTitle' => 'Ajouter un article',
            'users' => $users,
            'categories' => $categories,
            'errors' => $errors,
            'titre' => $titre,
            'contenu' => $contenu,
            'idUser' => $idUser,
            'categoryIds' => $categoryIds
        ]);
    }

    public function edit(){
        $id = (int) ($_GET['id'] ?? 0);

        $postModel = new PostModel();
        $post = $postModel->getById($id);

        if (!$post) {
            http_response_code(404);
            echo 'Article introuvable.';
            return;
        }

        $userModel = new UserModel();
        $categorieModel = new CategorieModel();

        $users = $userModel->getAll();
        $categories = $categorieModel->getAll();

        $categoryIds = $postModel->getCategoryIds($id);

        View::render('post-edit', [
            'pageTitle' => 'Modifier un article',
            'idPosts' => $post['idPosts'],
            'titre' => $post['Titre'],
            'contenu' => $post['Contenu'],
            'idUser' => $post['Users_idUsers'],
            'categoryIds' => $categoryIds,
            'users' => $users,
            'categories' => $categories
        ]);
    }

    public function update(){
        $id = (int) ($_POST['idPosts'] ?? 0);

        $postModel = new PostModel();
        $post = $postModel->getById($id);

        if (!$post) {
            http_response_code(404);
            echo 'Article introuvable.';
            return;
        }

        $titre = trim($_POST['Titre'] ?? '');
        $contenu = trim($_POST['Contenu'] ?? '');
        $idUser = (int) ($_POST['Users_idUsers'] ?? 0);

        $categoryIds = $_POST['categories'] ?? [];

        $userModel = new UserModel();
        $categorieModel = new CategorieModel();

        $users = $userModel->getAll();
        $categories = $categorieModel->getAll();

        $errors = [];

        if ($titre === '') {
            $errors[] = 'Le titre est obligatoire.';
        } elseif (mb_strlen($titre) > 255) {
            $errors[] = 'Le titre doit contenir au maximum 255 caractères.';
        }

        if ($contenu === '') {
            $errors[] = 'Le contenu est obligatoire.';
        }

        $userIds = array_map(
            'intval',
            array_column($users, 'idUsers')
        );

        if (!in_array($idUser, $userIds, true)) {
            $errors[] = 'Choisis un auteur valide.';
        }

        if (!is_array($categoryIds)) {
            $errors[] = 'Les catégories sont invalides.';
            $categoryIds = [];
        }

        $categoryIds = array_unique(
            array_map('intval', $categoryIds)
        );

        $validCategoryIds = array_map(
            'intval',
            array_column($categories, 'idCategories')
        );

        if (array_diff($categoryIds, $validCategoryIds)) {
            $errors[] = 'Une catégorie sélectionnée est invalide.';
        }

        if (!$errors) {
            try {
                $postModel->updatePost($id, [
                    'Titre' => $titre,
                    'Contenu' => $contenu,
                    'Users_idUsers' => $idUser,
                    'update_at' => date('Y-m-d H:i:s')
                ], $categoryIds);

                View::redirect(
                    'article?id=' . $id,
                    'L’article a été modifié avec succès.'
                );
            } catch (PDOException $e) {
                $errors[] = 'Impossible de modifier l’article pour le moment.';
            } catch (RuntimeException $e) {
                $errors[] = 'Impossible de modifier l’article pour le moment.';
            }
        }

        View::render('post-edit', [
            'pageTitle' => 'Modifier un article',
            'idPosts' => $id,
            'titre' => $titre,
            'contenu' => $contenu,
            'idUser' => $idUser,
            'categoryIds' => $categoryIds,
            'users' => $users,
            'categories' => $categories,
            'errors' => $errors
        ]);
    }

    public function destroy(){
        $id = (int) ($_POST['id'] ?? 0);

        $postModel = new PostModel();
        $post = $postModel->getById($id);

        if (!$post) {
            http_response_code(404);

            View::render('post-index', [
                'pageTitle' => 'Articles',
                'posts' => $postModel->getAll(),
                'errors' => [
                    'Article introuvable : aucune suppression effectuée.'
                ]
            ]);

            return;
        }

        try {
            $postModel->deletePost($id);

            View::redirect(
                'articles',
                'L’article a été supprimé avec succès.'
            );
        } catch (PDOException $e) {
            http_response_code(500);

            View::render('post-index', [
                'pageTitle' => 'Articles',
                'posts' => $postModel->getAll(),
                'errors' => [
                    'Impossible de supprimer l’article pour le moment.'
                ]
            ]);
        } catch (RuntimeException $e) {
            http_response_code(500);

            View::render('post-index', [
                'pageTitle' => 'Articles',
                'posts' => $postModel->getAll(),
                'errors' => [
                    'Impossible de supprimer l’article pour le moment.'
                ]
            ]);
        }
    }
}