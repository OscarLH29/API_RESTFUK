<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// *** Inicio GET

$app->get('/api/eventos', function($request,  $response){
    
    $query = "SELECT * FROM evento";

    try {
        // instanciar clase bd
        $db = new db();

        $db = $db->conectar(); // usamos el metodo conectar
        $consulta = $db->query($query); // le mandamos el query a la consulta

        if ( $consulta->rowCount() > 0 ) { // si el contenido de la consulta es mayor a 0

            $eventos = $consulta->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($eventos);

        } else {
            echo json_encode('No existe ningun evento');
        }

        // cerramos la consulta
        $consulta = null;
        $db = null;

    } catch ( PDOException $e ) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    } 
    
});
// *** FINAL GET

// *** Inicio GET POR USUARIO

$app->get('/api/eventos/{id}', function($request,  $response){
    
    $idEvento = $request->getAttribute('id');
    $query = "SELECT idEvento,Usuario,NombreEvento,Descripcion,Emocion_idEmocion FROM evento WHERE Usuario = $idEvento";

    try {
        // instanciar clase bd
        $db = new db();

        $db = $db->conectar(); // usamos el metodo conectar
        $consulta = $db->query($query); // le mandamos el query a la consulta

        if ( $consulta->rowCount() > 0 ) { // si el contenido de la consulta es mayor a 0

            $eventos = $consulta->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($eventos);

        } else {
            echo json_encode('El usuario no tiene eventos');
        }

        // cerramos la consulta
        $consulta = null;
        $db = null;

    } catch ( PDOException $e ) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    } 
    
});
// *** FINAL GET POR USUARIO

// *** INICIO POST
$app->post('/api/eventos/post', function(Request $request, Response $response) {

    // crear varibles a incertar
    $Usuario = $request->getParam('Usuario');
    $NombreEvento = $request->getParam('NombreEvento');
    $Descripcion = $request->getParam('Descripcion');
    $Imagen = $request->getParam('Imagen');
    $Fecha = $request->getParam('Fecha');
    $Lugar_idLugar = $request->getParam('Lugar_idLugar');
    $Emocion_idEmocion = $request->getParam('Emocion_idEmocion');
    $Usuario_idUsuario = $request->getParam('Usuario_idUsuario');

    $query = "INSERT INTO evento (Usuario, NombreEvento, Descripcion, Imagen, Fecha, Lugar_idLugar, Emocion_idEmocion, Usuario_idUsuario) VALUES (:Usuario, :NombreEvento, :Descripcion, :Imagen, :Fecha, :Lugar_idLugar, :Emocion_idEmocion, :Usuario_idUsuario)";


    try {
        // intanciar la bd
        $db = new db();

        // conectamos 
        $db = $db->conectar();
        // mandamos el query
        $consulta = $db->prepare($query);

        // preparamos los datos
        $consulta->bindParam(':Usuario', $Usuario);
        $consulta->bindParam(':NombreEvento', $NombreEvento);
        $consulta->bindParam(':Descripcion', $Descripcion);
        $consulta->bindParam(':Imagen', $Imagen);
        $consulta->bindParam(':Fecha', $Fecha);
        $consulta->bindParam(':Lugar_idLugar', $Lugar_idLugar);
        $consulta->bindParam(':Emocion_idEmocion', $Emocion_idEmocion);
        $consulta->bindParam(':Usuario_idUsuario', $Usuario_idUsuario);

        // ejecutamos la consulta
        $consulta->execute();

        echo json_encode('Evento Guardado');

        // seteamos a null para cerrar conexion
        $ejecutar = null; 
        $db = null;

    } catch (PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// *** INICIO POST

// *** INICIO PUT
$app->put('/api/eventos/post/{id}', function(Request $request, Response $response) {

    $idEvento = $request->getAttribute('id');
    // crear varibles a incertar
    $NombreEvento = $request->getParam('NombreEvento');
    $Descripcion = $request->getParam('Descripcion');
    $Imagen = $request->getParam('Imagen');
    $Fecha = $request->getParam('Fecha');
    $Lugar_idLugar = $request->getParam('Lugar_idLugar');
    $Emocion_idEmocion = $request->getParam('Emocion_idEmocion');
    $Usuario_idUsuario = $request->getParam('Usuario_idUsuario');

    $query = "UPDATE evento SET
              NombreEvento = :NombreEvento,
              Descripcion = :Descripcion,
              Imagen = :Imagen,
              Fecha = :Fecha,
              Lugar_idLugar = :Lugar_idLugar,
              Emocion_idEmocion = :Emocion_idEmocion,
              Usuario_idUsuario = :Usuario_idUsuario
              WHERE idEvento = $idEvento";

    try {
        // intanciar la bd
        $db = new db();

        // conectamos 
        $db = $db->conectar();
        // mandamos el query
        $consulta = $db->prepare($query);

        // preparamos los datos
        $consulta->bindParam(':NombreEvento', $NombreEvento);
        $consulta->bindParam(':Descripcion', $Descripcion);
        $consulta->bindParam(':Imagen', $Imagen);
        $consulta->bindParam(':Fecha', $Fecha);
        $consulta->bindParam(':Lugar_idLugar', $Lugar_idLugar);
        $consulta->bindParam(':Emocion_idEmocion', $Emocion_idEmocion);
        $consulta->bindParam(':Usuario_idUsuario', $Usuario_idUsuario);

        // ejecutamos la consulta
        $consulta->execute();

        echo json_encode('Evento Modificado');

        // seteamos a null para cerrar conexion
        $ejecutar = null; 
        $db = null;

    } catch (PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// *** FINAL PUT

// *** INICIO DELETE
$app->delete('/api/eventos/delete/{id}', function(Request $request, Response $response) {

    $idEvento = $request->getAttribute('id');

    $query = "DELETE FROM evento WHERE idEvento = $idEvento";

    try {
        // intanciar la bd
        $db = new db();

        // conectamos 
        $db = $db->conectar();
        // mandamos el query
        $consulta = $db->prepare($query);

        // ejecutamos la consulta
        $consulta->execute();

        if($consulta->rowCount() > 0) {
            echo json_encode('Evento Eliminado');
        } else {
            echo json_encode('No hay eventos para eliminar');
        }

        // seteamos a null para cerrar conexion
        $ejecutar = null; 
        $db = null;

    } catch (PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// *** FINAL DELETE





?>