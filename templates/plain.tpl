{% extends "index.tpl" %}

{% block contents %}
<div class="container">
    <section>
        <header>
            <h1>{{title}}</h1>
        </header>
        {{body|markdown}}
    </section>
</div>
{% endblock %}