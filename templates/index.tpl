<!doctype html>
<html>
    <head>
        <title>beheh.de</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" type="text/css" href="beheh.css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <?php
        if (file_exists('headers.txt')) {
        echo file_get_contents('headers.txt');
        }
        ?>
    </head>
    <body>
        <header id="banner">
            <div id="background"></div>
            <div class="container">
                <h1><a href="https://beheh.de">Benedict Etzel</a></h1>
                <h2>Student an der Ostsee</h2>
            </div>
        </header>
        <div id="content">
            <div class="container">
                {% for preview in previews %}
                    {% include 'preview.tpl' with {'title': preview.title, 'teaser': preview.teaser} %}
                {% endfor %}
            </div>
        </div>
        <footer id="end">
            <div class="container">
                Auf <a href="https://github.com/beheh">GitHub</a> und <a href="https://twitter.com/beheh">Twitter</a>. <a href="https://beheh.de/imprint">Impressum</a>.
            </div>
        </footer>
        <?php
        if (file_exists('tracking.txt')) {
        echo file_get_contents('tracking.txt');
        }
        ?>
    </body>
</html>
