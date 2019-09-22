<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// INICIO GET
$app->get('/api/lugares', function($request,  $response) {

    $query = "SELECT * FROM lugar";

    try {

        $db = new db();

        $db = $db->conectar();

        $consulta = $db->query($query);
        
        if ($consulta->rowCount() > 0) {

            $lugares = $consulta->fetchAll(PDO::FETCH_OBJ);
            echo json_encode ($lugares);

        } else {
            echo json_encode ('No existen elementos');
        }

        $consulta = null;
        $db = null;

    } catch (PDOException $e) {
        '{"error": {"text": '.$e->getMessage().'}';
    }

});
//FINAL GET

// INICIO POST
$app->post('/api/lugares/post', function(Request $request, Response $response) {

    // definir variables
    $latitud = $request->getParam('latitud');
    $altitud = $request->getParam('altitud');

    $query = "INSERT INTO lugar (latitud, altitud) VALUES(:latitud, :altitud)";


    try {

        $db = new db();

        $db = $db->conectar();

        $consulta = $db->prepare($query);
        
        $consulta->bindParam(':latitud', $latitud);
        $consulta->bindParam(':altitud', $altitud);

        $consulta->execute();

        echo json_encode ('Lugar guardado');

        $consulta = null;
        $db = null;

    } catch (PDOException $e) {
        '{"error": {"text": '.$e->getMessage().'}';
    }

});
//FINAL POST

// INICIO PUT
$app->put('/api/lugares/post/{id}', function(Request $request, Response $response) {

    $idLugar = $request->getAttribute('id');
    // definir variables
    $latitud = $request->getParam('latitud');
    $altitud = $request->getParam('altitud');

    $query = "UPDATE lugar SET
              latitud = :latitud,
              altitud = :altitud
              WHERE idLugar = $idLugar";

    try {

        $db = new db();

        $db = $db->conectar();

        $consulta = $db->prepare($query);
        
        $consulta->bindParam(':latitud', $latitud);
        $consulta->bindParam(':altitud', $altitud);

        $consulta->execute();

        echo json_encode ('Lugar actualizado!');

        $consulta = null;
        $db = null;

    } catch (PDOException $e) {
        '{"error": {"text": '.$e->getMessage().'}';
    }

});
//FINAL PUT

// INICIO DELETE
$app->delete('/api/lugares/delete/{id}', function(Request $request, Response $response) {

    $idLugar = $request->getAttribute('id');
    
    $query = "DELETE FROM lugar WHERE idLugar = $idLugar";

    try {

        $db = new db();

        $db = $db->conectar();

        $consulta = $db->prepare($query); 
        $consulta->execute();

        if( $consulta->rowCount() > 0) {

            echo json_encode ('Lugar Eliminado!');
        } else {
            echo json_encode ('Ese elemento no existe');
        }


        $consulta = null;
        $db = null;

    } catch (PDOException $e) {
        '{"error": {"text": '.$e->getMessage().'}';
    }

});
//FINAL DELETE


?>