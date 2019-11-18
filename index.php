<?php
require 'vendor/autoload.php';
date_default_timezone_set('Afriac/Cairo'); // set default timezone

//$log = new Monolog\Logger('name');
//$log->pushHandler(new Monolog\Handler\StreamHandler('app.txt', Monolog\Logger::WARNING));
//$log->addWarning('Oh Noes.');

$app = new \Slim\Slim(array(
  'view' => new \Slim\Views\Twig()
));

$view = $app->view();
$view->parserOptions = array(
  'debug' => true
);
$view->parserExtensions = array(
  new \Slim\Views\TwigExtension(),
);

//Homw view
$app->get('/', function () use ($app) {
  $app->render('about.twig')->name('home');
});

//contact view
$app->get('/contact', function () use ($app) {
  $app->render('contact.twig');
})->name('contact');

//form rout
$app->post('/contact', function () use ($app) {
  $name = $app->request->post('name');
  $email = $app->request->post('email');
  $msg = $app->request->post('msg');

  if (!empty($name) && !empty($email) && !empty($msg)) {
    // filter form vars
    $cleanName = filter_var($name, FILTER_SANITIZE_STRING);
    $cleanEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
    $cleanMsg = filter_var($msg, FILTER_SANITIZE_STRING);
  } else {
    // message to user there was a problem
    $app->redirect('/contact');
  }
});

// Run the object
$app->run();
