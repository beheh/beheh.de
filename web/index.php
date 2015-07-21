<?php

use Aptoma\Twig\Extension\MarkdownExtension;
use BehEh\Adapter\ParsedownExtraEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use League\Route\Http\Exception\NotFoundException;

require '../bootstrap.php';

// time parsing
$months = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
$parseTime = function($string) {
    $dateTime = DateTime::createFromFormat('Y-m-d', $string);
    $dateTime->setTime(10, 0, 0);
    return $dateTime;
};
$niceTime = function($date) use ($months, $parseTime) {
    $dateTime = $parseTime($date);
    return $dateTime->format('d').'. '.$months[$dateTime->format('n') - 1].' '.$dateTime->format('Y');
};
$atomTime = function($date) use ($parseTime) {
    return $parseTime($date)->format(DateTime::RFC3339);
};


// entry extraction
$getEntries = function ($flysystem) use ($niceTime, $atomTime) {
    $entries = array();

    $contents = $flysystem->listContents();
    $filenames = array_map(function($entry) {
        return $entry['path'];
    }, $contents);
    array_multisort($filenames, SORT_DESC, $contents);
    foreach ($flysystem->listContents() as $file) {
        $components = explode('_', $file['path']);

        if (count($components) != 2) {
            continue;
        }

        list($date, $name) = $components;
        if (new DateTime < DateTime::createFromFormat('Y-m-d', $date)) {
            continue;
        }

        $file = $flysystem->read($file['path']);

        $contents = $file['contents'];
        $pathinfo = pathinfo($file['path']);
        $entries[] = array(
            'filename' => $pathinfo['filename'].'.html',
            'title' => trim(strtok($contents, PHP_EOL), '# '),
            'nicetime' => $niceTime($date),
            'timestamp' => $atomTime($date),
            'contents' => trim(strstr($file['contents'], PHP_EOL))
        );
    }
    return $entries;
};

// twig
$twig = new Twig_Environment(new Twig_Loader_Filesystem('../templates'));
$twig->addExtension(new Twig_Extensions_Extension_Text());
$twig->addExtension(new MarkdownExtension(new ParsedownExtraEngine()));

// flysystem
$flysystem = new \League\Flysystem\Adapter\Local(__DIR__.'/../contents');

// router
$router = new League\Route\RouteCollection;

$router->get('/', function(Request $request, Response $response) use ($twig, $flysystem, $getEntries) {
    $entries = $getEntries($flysystem);

    $response->setContent($twig->render('index.tpl', array(
            'previews' => $entries
    )));
    return $response;
});

$router->get('/entries.rss', function(Request $request, Response $response) use ($twig, $flysystem, $getEntries) {
    $entries = $getEntries($flysystem);
    $response->headers->set('Content-Type', 'application/atom+xml');

    $response->setContent($twig->render('feed.tpl', array(
            'entries' => $entries
    )));
    return $response;
});

$router->get('/{entry}.{extension}', function(Request $request, Response $response, array $args) use ($twig, $flysystem, $niceTime) {
    $sourcefile = $args['entry'].'.md';
    $extension = $args['extension'];

    if (!$flysystem->has($sourcefile)) {
        throw new NotFoundException;
    }

    $components = explode('_', $sourcefile);

    if (count($components) == 2) {
        list($date, $name) = $components;
        if (new DateTime < DateTime::createFromFormat('Y-m-d', $date)) {
            throw new NotFoundException;
        }

        $file = $flysystem->read($sourcefile);
        switch ($extension) {
            case 'html':
                $response->setContent($twig->render('article.tpl', array(
                        'title' => trim(strtok($file['contents'], PHP_EOL), '# '),
                        'nicetime' => $niceTime($date),
                        'body' => trim(strstr($file['contents'], PHP_EOL))
                )));
                break;
            case 'md':
                $response->headers->set('Content-Type', 'text/plain');
                $response->setContent($file['contents']);
                break;
            default:
                throw new NotFoundException;
        }
    } else {
        $file = $flysystem->read($sourcefile);
        $contents = $file['contents'];
        switch ($extension) {
            case 'html':
                $response->setContent($twig->render('plain.tpl', array(
                        'title' => trim(strtok($file['contents'], PHP_EOL), '# '),
                        'body' => trim(strstr($file['contents'], PHP_EOL))
                )));
                break;
            case 'md':
                $response->headers->set('Content-Type', 'text/plain');
                $response->setContent($contents);
                break;
            default:
                throw new NotFoundException;
        }
    }

    return $response;
});

$dispatcher = $router->getDispatcher();
$request = Request::createFromGlobals();

try {
    $response = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
} catch (NotFoundException $ex) {
    $response = new Response($twig->render('404.tpl'), 404);
    $response->prepare($request);
} catch (Exception $ex) {
    $response = new Response($twig->render('500.tpl'), 500);
    $response->prepare($request);
    echo $ex;
}

$response->send();
