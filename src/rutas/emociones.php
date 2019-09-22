<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// INICO GET
$app->get('/api/emociones', function(REQUEST $request, RESPONSE $response){

    $query = "SELECT * FROM emocion";

    try {

        // instanciar bd
        $db = new db();
        // conectar
        $db = $db->conectar();
        // mandar el query
        $consulta = $db->query($query);

        if ($consulta->rowCount() > 0) {
            // guardamos los datos para mostrar
            $emociones = $consulta->fetchAll(PDO::FETCH_OBJ);
            // mostrar la consulta
            echo json_encode($emociones);
        } else {
            echo json_encode ('No existe ningun evento');
        }

        $consulta = null;
        $db = null;
    } catch(PDOException $e) {
        '{"error": {"text":'.$e->getMessage().'}';
    }
});
// FINAL GET

// INICO POST
$app->post('/api/emociones/post', function(REQUEST $request, RESPONSE $response){

    // crear variables
    $Emo_Nombre = $request->getParam('Emo_Nombre');
    $Emo_Imagen = $request->getParam('Emo_Imagen');

    $query = "INSERT INTO emocion (Emo_Nombre, Emo_Imagen) VALUES(:Emo_Nombre, :Emo_Imagen)";

    try {

        // instanciar bd
        $db = new db();
        // conectar
        $db = $db->conectar();
        // mandar el query
        $consulta = $db->prepare($query);

        $consulta->bindParam(':Emo_Nombre', $Emo_Nombre);
        $consulta->bindParam(':Emo_Imagen', $Emo_Imagen);

        $consulta->execute();
        
        echo json_encode ('Emocion guardada');

        $consulta = null;
        $db = null;

    } catch(PDOException $e) {
        '{"error": {"text":'.$e->getMessage().'}';
    }
});
// FINAL POST

// INICO PUT
$app->put('/api/emociones/post/{id}', function(REQUEST $request, RESPONSE $response){
    // guardar el id
    $idEmocion = $request->getAttribute('id');
    // crear variables
    $Emo_Nombre = $request->getParam('Emo_Nombre');
    $Emo_Imagen = $request->getParam('Emo_Imagen');

    $query = "UPDATE emocion SET
              Emo_Nombre = :Emo_Nombre,
              Emo_Imagen = :Emo_Imagen
              WHERE idEmocion = $idEmocion";

    try {

        // instanciar bd
        $db = new db();
        // conectar
        $db = $db->conectar();
        // mandar el query
        $consulta = $db->prepare($query);

        $consulta->bindParam(':Emo_Nombre', $Emo_Nombre);
        $consulta->bindParam(':Emo_Imagen', $Emo_Imagen);

        $consulta->execute();
        
        echo json_encode ('Emocion modificada');

        $consulta = null;
        $db = null;

    } catch(PDOException $e) {
        '{"error": {"text":'.$e->getMessage().'}';
    }
});
// FINAL PUT

// INICO DELETE
$app->delete('/api/emociones/delete/{id}', function(REQUEST $request, RESPONSE $response){
    // guardar el id
    $idEmocion = $request->getAttribute('id');

    $query = "DELETE FROM emocion WHERE idEmocion = $idEmocion";

    try {

        // instanciar bd
        $db = new db();
        // conectar
        $db = $db->conectar();
        // mandar el query
        $consulta = $db->prepare($query);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            echo json_encode('Emocion Eliminada');
        } else {
            echo json_encode('No existe esa emocion');
        }

        $consulta = null;
        $db = null;

    } catch(PDOException $e) {
        '{"error": {"text":'.$e->getMessage().'}';
    }
});
// FINAL DELETE

?>