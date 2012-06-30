<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Fazer\TodoList;

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html', array());
})
->bind('homepage')
;

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    $page = 404 == $code ? '404.html' : '500.html';

    return new Response($app['twig']->render($page, array('code' => $code)), $code);
});

/** create service to make use of TodoList class */
$app['todo_service'] = function () use ($app) {
    $dsn = $app['parameter.driver'].':dbname='.$app['parameter.dbName'].';host='.$app['parameter.host'];
    try {
        $pdo = new \PDO($dsn, $app['parameter.user'], $app['parameter.pass']);
    } catch (PDOException $e) {
        // @todo try to log exception here
    }
    //$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return new TodoList($pdo);
};

/** create route to make use of TodoList class */
$app->get('/add', function () use ($app) {
    $todo = $app['todo_service'];
    $todo['my first task'] = true; // create a task "my first task"
    $output = 'test';

    return new Response(sprintf('%s', $output), 200);
});
