<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST ,OPTIONS, PUT');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Content-Type: application/json');

require '../vendor/autoload.php';
require '../src/config/db.php'; // importamos nuestro gestor de bd para usarlo

$app = new \Slim\app;
?>
<h1>POTRONOMETRO</h1>
<?php
// crear las rutas de las tablas
require '../src/rutas/eventos.php';
require '../src/rutas/usuarios.php';
require '../src/rutas/emociones.php';
require '../src/rutas/lugares.php';
require '../src/rutas/cuestionarios.php';

$app->run();