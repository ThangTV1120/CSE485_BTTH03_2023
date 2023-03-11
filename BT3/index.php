<?php
// require_once 'vendor/autoload.php';
// require_once 'config.php';

// use Twig\Environment;
// use Twig\Loader\FilesystemLoader;

// $loader = new FilesystemLoader('views');
// $twig = new Environment($loader);

// $action = isset($_GET['action']) ? $_GET['action'] : '';

// switch ($action) {
//     case 'add':
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $name = $_POST['name'];
//             $email = $_POST['email'];
//             $stmt = $db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
//             $stmt->execute([$name, $email]);
//             header('Location: index.php');
//             exit;
//         }
//         echo $twig->render('add.twig');
//         break;
//     case 'edit':
//         $id = $_GET['id'];
//         $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
//         $stmt->execute([$id]);
//         $user = $stmt->fetch(PDO::FETCH_ASSOC);
//         if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//             $name = $_POST['name'];
//             $email = $_POST['email'];
//             $stmt = $db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
//             $stmt->execute([$name, $email, $id]);
//             header('Location: index.php');
//             exit;
//         }
//         echo $twig->render('edit.twig', ['user' => $user]);
//         break;
//     case 'delete':
//         $id = $_GET['id'];
//         $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
//         $stmt->execute([$id]);
//         header('Location: index.php');
//         exit;
//         break;
//     default:
//         $stmt = $db->query("SELECT * FROM users");
//         $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//         echo $twig->render('index.twig', ['users' => $users]);
//         break;
// }

// include("email/EmailSender.php");
// include("email/EmailServerInterface.php");
// include("email/MyEmailServer.php");

// $emailServer = new MyEmailServer();
// $emailSender = new EmailSender($emailServer);
// $emailSender->send("thangchien86@gmail.com", "Test Email", "This is a test email.");

require_once 'vendor/autoload.php';

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$routes = new RouteCollection();

// List all users
$routes->add('user.index', new Route('/', array(
    '_controller' => 'UserController::index',
)));

// Show user details
$routes->add('user.show', new Route('/users/{id}', array(
    '_controller' => 'UserController::show',
)));

// Create a new user (show form)
$routes->add('user.create', new Route('/users/create', array(
    '_controller' => 'UserController::create',
)));

// Store a new user (handle form submission)
$routes->add('user.store', new Route('/users', array(
    '_controller' => 'UserController::store',
), array(), array(), '', array(), array('POST')));

// Edit user details (show form)
$routes->add('user.edit', new Route('/users/{id}/edit', array(
    '_controller' => 'UserController::edit',
)));

// Update user details (handle form submission)
$routes->add('user.update', new Route('/users/{id}', array(
    '_controller' => 'UserController::update',
), array(), array(), '', array(), array('PUT', 'PATCH')));

// Delete user
$routes->add('user.delete', new Route('/users/{id}', array(
    '_controller' => 'UserController::delete',
), array(), array(), '', array(), array('DELETE')));

// Initialize the routing context
$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);

// Match the current request to a route
$matcher = new UrlMatcher($routes, $context);
$parameters = $matcher->match($request->getPathInfo());

// Call the appropriate controller method with the matched parameters
$controller = new $parameters['_controller'];
$response = call_user_func_array(array($controller, $parameters['_action']), $parameters);

// Send the response to the browser
$response->send();

