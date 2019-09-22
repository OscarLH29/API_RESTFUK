<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    // INICO GET
$app->get('/api/cuestionarios', function(REQUEST $request, RESPONSE $response){

    $query = "SELECT * FROM cuestionario";

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
            echo json_encode ('No existe ningun cuestionario');
        }

        $consulta = null;
        $db = null;
    } catch(PDOException $e) {
        '{"error": {"text":'.$e->getMessage().'}';
    }
});
// FINAL GET

// *** INICIO POST
$app->post('/api/cuestionarios/post', function(Request $request, Response $response) {

    // crear varibles a incertar
    $usuario_idUsuario = $request->getParam('usuario_idUsuario');
    $cuestionarioPParte = $request->getParam('cuestionarioPParte');
    $cuestionarioFecha = $request->getParam('cuestionarioFecha');

    $query = "INSERT INTO cuestionario (usuario_idUsuario, cuestionarioPParte,cuestionarioFecha) VALUES (:usuario_idUsuario, :cuestionarioPParte, :cuestionarioFecha)";


    try {
        // intanciar la bd
        $db = new db();

        // conectamos 
        $db = $db->conectar();
        // mandamos el query
        $consulta = $db->prepare($query);

        // preparamos los datos
        $consulta->bindParam(':usuario_idUsuario', $usuario_idUsuario);
        $consulta->bindParam(':cuestionarioPParte', $cuestionarioPParte);
        $consulta->bindParam(':cuestionarioFecha', $cuestionarioFecha);

        // ejecutamos la consulta
        $consulta->execute();

        echo json_encode('cuestionario Guardado');

        // seteamos a null para cerrar conexion
        $ejecutar = null; 
        $db = null;

    } catch (PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// *** INICIO POST

// *** INICIO PUT QUIZ2
$app->put('/api/cuestionarios/post/{id}/{cuestionarioFecha}', function(Request $request, Response $response) {

    $usuario_idUsuario = $request->getAttribute('id');
    $cuestionarioFecha = $request->getAttribute('cuestionarioFecha');
    // crear varibles a incertar
    $cuestionarioSPartel = $request->getParam('cuestionarioSPartel');

    $query = "UPDATE cuestionario SET
              cuestionarioSPartel = :cuestionarioSPartel
              WHERE usuario_idUsuario = $usuario_idUsuario
              and cuestionarioFecha = $cuestionarioFecha";

    try {
        // intanciar la bd
        $db = new db();

        // conectamos 
        $db = $db->conectar();
        // mandamos el query
        $consulta = $db->prepare($query);

        // preparamos los datos
        $consulta->bindParam(':cuestionarioSPartel', $cuestionarioSPartel);

        // ejecutamos la consulta
        $consulta->execute();

        echo json_encode('cuestionario Modificado');

        // seteamos a null para cerrar conexion
        $ejecutar = null; 
        $db = null;

    } catch (PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// *** FINAL PUT QUIZ2

// *** INICIO PUT QUIZ3
$app->put('/api/cuestionarios3/post/{id}/{cuestionarioFecha}', function(Request $request, Response $response) {

    $usuario_idUsuario = $request->getAttribute('id');
    $cuestionarioFecha = $request->getAttribute('cuestionarioFecha');
    // crear varibles a incertar
    $cuestionarioTParte = $request->getParam('cuestionarioTParte');

    $query = "UPDATE cuestionario SET
              cuestionarioTParte = :cuestionarioTParte
              WHERE usuario_idUsuario = $usuario_idUsuario
              and cuestionarioFecha = $cuestionarioFecha";

    try {
        // intanciar la bd
        $db = new db();

        // conectamos 
        $db = $db->conectar();
        // mandamos el query
        $consulta = $db->prepare($query);

        // preparamos los datos
        $consulta->bindParam(':cuestionarioTParte', $cuestionarioTParte);

        // ejecutamos la consulta
        $consulta->execute();

        echo json_encode('cuestionario Modificado');

        // seteamos a null para cerrar conexion
        $ejecutar = null; 
        $db = null;

    } catch (PDOException $e) {
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
// *** FINAL PUT QUIZ3


// INICIO GET PPARTE
$app->get('/api/lugares/{id}/{cuestionarioFecha}', function($request, $response) {

    $usuario_idUsuario = $request->getAttribute('id');
    $cuestionarioFecha = $request->getAttribute('cuestionarioFecha');

    $query = "SELECT * FROM cuestionario
              WHERE usuario_idUsuario = $usuario_idUsuario
              and cuestionarioFecha = $cuestionarioFecha";

    try {

        $db = new db();

        $db = $db->conectar();

        $consulta = $db->query($query);

        if ($consulta->rowCount() > 0) {

            $cuestionarios = $consulta->fetchAll(PDO::FETCH_OBJ);
            echo json_encode ($cuestionarios);
        } else {
            echo json_encode ('No existen elementos');
        }

        $consulta = null;
        $db = null;
    } catch (PDOException $e) {
        '{"error": {"text": '.$e->getMessage().'}';
    }
});
// FINAL GET PPARTE

// INICIO GET SPARTE
$app->get('/api/cuestionarios/{id}/{cuestionarioFecha}', function($request, $response) {

    $usuario_idUsuario = $request->getAttribute('id');
    $cuestionarioFecha = $request->getAttribute('cuestionarioFecha');

    $query = "SELECT cuestionarioSPartel FROM cuestionario
              WHERE usuario_idUsuario = $usuario_idUsuario
              and cuestionarioFecha = $cuestionarioFecha";

    try {

        $db = new db();

        $db = $db->conectar();

        $consulta = $db->query($query);

        if ($consulta->rowCount() > 0) {

            $cuestionarios = $consulta->fetchAll(PDO::FETCH_OBJ);
            echo json_encode ($cuestionarios);
        } else {
            echo json_encode ('No existen elementos');
        }

        $consulta = null;
        $db = null;
    } catch (PDOException $e) {
        '{"error": {"text": '.$e->getMessage().'}';
    }
});
// FINAL GET SPARTE

// INICIO GET TPARTE
$app->get('/api/cuestionarios3/{id}/{cuestionarioFecha}', function($request, $response) {

    $usuario_idUsuario = $request->getAttribute('id');
    $cuestionarioFecha = $request->getAttribute('cuestionarioFecha');

    $query = "SELECT cuestionarioTParte FROM cuestionario
              WHERE usuario_idUsuario = $usuario_idUsuario
              and cuestionarioFecha = $cuestionarioFecha";

    try {

        $db = new db();

        $db = $db->conectar();

        $consulta = $db->query($query);

        if ($consulta->rowCount() > 0) {

            $cuestionarios = $consulta->fetchAll(PDO::FETCH_OBJ);
            echo json_encode ($cuestionarios);
        } else {
            echo json_encode ('No existen elementos');
        }

        $consulta = null;
        $db = null;
    } catch (PDOException $e) {
        '{"error": {"text": '.$e->getMessage().'}';
    }
});
// FINAL GET TPARTE

?>