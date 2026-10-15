<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ pageTitle|default('Blogue coloré') }}</title>

    <link rel="stylesheet" href="{{ base }}/css/style.css">
</head>
<body>

<header class="site-header">
    <a
        class="logo"
        href="{{ base }}/"
    >
        Blogue coloré
    </a>

    <nav aria-label="Navigation principale">
        <a href="{{ base }}/">
            Accueil
        </a>

        <a href="{{ base }}/articles">
            Articles
        </a>

        <a
            class="button small"
            href="{{ base }}/article/create"
        >
            Nouvel article
        </a>
    </nav>
</header>

<main class="container">
    {% if notice %}
        <div class="notice" role="status">
            {{ notice }}
        </div>
    {% endif %}

    {% block content %}{% endblock %}
</main>

<footer class="site-footer">
    <p>
        Projet TP2 de Programmation Web avancée — Créé par Amélie Hénault
    </p>
</footer>

</body>
</html>