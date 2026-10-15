{% extends 'layout.php' %}

{% block content %}

<section class="form-shell">
    <h1>
        Modifier l’article
    </h1>

    {% if errors is defined and errors is not empty %}
        <div class="errors" role="alert">
            <ul>
                {% for error in errors %}
                    <li>{{ error }}</li>
                {% endfor %}
            </ul>
        </div>
    {% endif %}

    <form
        action="{{ base }}/article/update"
        method="post"
    >
        <input
            type="hidden"
            name="idPosts"
            value="{{ idPosts }}"
        >

        <label for="Titre">
            Titre
        </label>

        <input
            id="Titre"
            name="Titre"
            type="text"
            maxlength="255"
            value="{{ titre }}"
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
        >{{ contenu }}</textarea>

        <label for="Users_idUsers">
            Auteur
        </label>

        <select
            id="Users_idUsers"
            name="Users_idUsers"
            required
        >
            {% for user in users %}
                <option
                    value="{{ user.idUsers }}"
                    {% if user.idUsers == idUser %}selected{% endif %}
                >
                    {{ user.Nom }}
                </option>
            {% endfor %}
        </select>

        <fieldset>
            <legend>
                Catégories
            </legend>

            <div class="checkboxes">
                {% for categorie in categories %}
                    <label class="checkbox">
                        <input
                            type="checkbox"
                            name="categories[]"
                            value="{{ categorie.idCategories }}"
                            {% if categorie.idCategories in categoryIds %}checked{% endif %}
                        >

                        {{ categorie.Nom }}
                    </label>
                {% endfor %}
            </div>
        </fieldset>

        <button
            class="button"
            type="submit"
        >
            Enregistrer les modifications
        </button>

        <a href="{{ base }}/article?id={{ idPosts }}">
            Annuler
        </a>
    </form>
</section>

{% endblock %}