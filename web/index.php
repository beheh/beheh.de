<?php

use Klein\Klein;
use Aptoma\Twig\Extension\MarkdownExtension;
use BehEh\Adapter\ParsedownExtraEngine;

require '../bootstrap.php';


$twig = new Twig_Environment(new Twig_Loader_Filesystem('../templates'));

$twig->addExtension(new Twig_Extensions_Extension_Text());
$twig->addExtension(new MarkdownExtension(new ParsedownExtraEngine()));

$klein = new Klein;

$klein->respond(function () use ($twig) {
    return $twig->render('index.tpl', array(
            'previews' => array(
                array('title' => 'Moin moin', 'teaser' => 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.')
            )
    ));
});


$klein->dispatch();
