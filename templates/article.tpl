{% extends "index.tpl" %}

{% block contents %}
<div class="container">
    <article>
        <header>
            {% if nicetime %}<time>{{nicetime}}</time>{% endif %}
            <h1>{{title}}</h1>
        </header>
        {{body|markdown}}
    </article>
</div>
{% endblock %}