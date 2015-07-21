<!doctype html>
<html>
    <head>
        <title>{{title|default("beheh.de")}}</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="beheh.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
        {{headers|raw}}
    </head>
    <body>
        <header id="banner">
            <div id="background"></div>
            <div class="container">
                <h1><a href="https://beheh.de">Benedict Etzel</a></h1>
                <h2>{{catchphrase}}</h2>
            </div>
        </header>
        <div id="content">
            {% block contents %}
            <div class="container">
                {% for preview in previews %}
                {% include 'preview.tpl' with {'filename': preview.filename, 'title': preview.title, 'contents': preview.contents, 'nicetime': preview.nicetime} %}
                {% else %}
                <section>
                    <header>
                        <h1>Bereit zum Abflug</h1>
                    </header>
                    <p>Hier erscheinen in Zukunft diverse Artikel.</p>
                </section>
                {% endfor %}
            </div>
            {% endblock %}
        </div>
        <footer id="end">
            <div class="container">
                <p class="obscured pull-right">
                    <a href="mailto:moin@beheh.de">moin@beheh.de</a> &middot;
                    <a href="entries.rss">RSS</a> &middot;
                    <a href="https://github.com/beheh/beheh.de">Code</a> &middot;
                    <a hreF="imprint.html">Impressum</a></p>
                <p>
                    <span class="icons"><a href="https://github.com/beheh"><i class="fa fa-github"></i></a>, <a href="https://twitter.com/beheh"><i class="fa fa-twitter"></i></a>, <a href="https://www.facebook.com/benedict.etzel"><i class="fa fa-facebook"></i></a>.</span>
                </p>
        </footer>
        {{tracking|raw}}
    </body>
</html>
