<?php 
require_once 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader(__DIR__);
$twig = new \Twig\Environment($loader);

echo $twig->render('demo.twig', array('variable_name' => 'variable_value'));