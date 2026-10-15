{% extends 'layout.php' %}

{% block content %}

<section class="section-heading">
    <div>
        <h1>
            Tous les articles
        </h1>
    </div>

    <a
        class="button"
        href="{{ base }}/article/create"
    >
        Ajouter un article
    </a>
</section>

{% if errors is defined and errors is not empty %}
    <div class="errors" role="alert">
        <ul>
            {% for error in errors %}
                <li>{{ error }}</li>
            {% endfor %}
        </ul>
    </div>
{% endif %}

{% if posts is empty %}

    <div class="empty">
        Aucun article.
    </div>

{% else %}

    <div class="grid">

        {% for post in posts %}

            <article class="card">
                <p class="tag">
                    {{ post.Categories ?? 'Sans catégorie' }}
                </p>

                <h2>
                    {{ post.Titre }}
                </h2>

                <p>
                    {{ post.Contenu|slice(0, 170) }}{% if post.Contenu|length > 170 %}…{% endif %}
                </p>

                <p class="meta">
                    Par {{ post.Auteur }}
                </p>

                <div class="actions">
                    <a href="{{ base }}/article?id={{ post.idPosts }}">
                        Voir
                    </a>

                    <a href="{{ base }}/article/edit?id={{ post.idPosts }}">
                        Modifier
                    </a>

                    <form
                        action="{{ base }}/article/delete"
                        method="post"
                        onsubmit="return confirm('Supprimer cet article ?');"
                    >
                        <input
                            type="hidden"
                            name="id"
                            value="{{ post.idPosts }}"
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

        {% endfor %}

    </div>

{% endif %}

{% endblock %}