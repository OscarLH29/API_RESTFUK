<?php 
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

// *** Inicio GET (Leer)
$app->get('/api/usuarios', function( $request,  $response){ // ruta que usaremos

    $consulta = "SELECT * FROM usuario"; // guardamos nuestro query consulta

    // ** crear try catch
    try {

        // instancia de nuestra clase bd
        $db = new db();

        $db = $db->conectar();  // usamos la funcion conectar de nuestra clase bd
        $ejecutar = $db->query($consulta);  // le mandamos el query a la bd para que guarde el resultaro en una variable
     
        if ( $ejecutar->rowCount() > 0) { // si la variable tiene algo 

            $usuarios = $ejecutar->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($usuarios);

        } else {                        // si la variable no tiene nada
            echo json_encode('No existen usuarios en la BD');
        }

        // seteamos a null para cerrar conexion
        $ejecutar = null; 
        $db = null;

    } catch(PDOException $e) { // por si existe algun error
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});  

// ***  final GET

// *** Inicio GET por id

$app->get('/api/usuarios/{id}', function(Request $request, Response $response){ // ruta que usaremos

    $id_user = $request->getAttribute('id');
    $consulta = "SELECT * FROM usuario WHERE idUsuario = $id_user"; // guardamos nuestro query consulta

    // ** crear try catch
    try {

        // instancia de nuestra clase bd
        $db = new db();

        $db = $db->conectar();  // usamos la funcion conectar de nuestra clase bd
        $ejecutar = $db->query($consulta);  // le mandamos el query a la bd para que guarde el resultaro en una variable
     
        if ( $ejecutar->rowCount() > 0) { // si la variable tiene algo 

            $usuario = $ejecutar->fetchAll(PDO::FETCH_OBJ);
            echo json_encode($usuario);

        } else {                        // si la variable no tiene nada
            echo json_encode('No existen usuarios en la BD con ese id');
        }

        // seteamos a null para cerrar conexion
        $ejecutar = null; 
        $db = null;

    } catch(PDOException $e) { // por si existe algun error
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});  

// ***  final GET por id

// *** Inicio POST (Crear)

$app->post('/api/usuarios/post', function(Request $request, Response $response){ // ruta que usaremos

    // creamos variables para recibir informacion del frontend
    $nombresUsuario = $request->getParam('nombresUsuario');
    $APAUsuario = $request->getParam('APAUsuario');
    $AMAUsuario = $request->getParam('AMAUsuario');
    $correoUsuario = $request->getParam('correoUsuario');
    $nicknameUsuario = $request->getParam('nicknameUsuario');
    $sexoUsuario = $request->getParam('sexoUsuario');
    $contrasenaUsuario = $request->getParam('contrasenaUsuario');
    $NOCUENTA = $request->getParam('NOCUENTA');
    
    $consulta = "INSERT INTO usuario (nombresUsuario, APAUsuario, AMAUsuario, correoUsuario, nicknameUsuario, sexoUsuario, contrasenaUsuario, NOCUENTA)
    VALUES(:nombresUsuario, :APAUsuario, :AMAUsuario, :correoUsuario, :nicknameUsuario, :sexoUsuario, :contrasenaUsuario, :NOCUENTA) "; // guardamos nuestro query consulta

    // ** crear try catch
    try {

        // instancia de nuestra clase bd
        $db = new db();

        $db = $db->conectar();  // usamos la funcion conectar de nuestra clase bd
        $ejecutar = $db->prepare($consulta);  // le mandamos el query a la bd para que prepare el resultaro en una variable
        
        // guardar informacion de variables en bd
        $ejecutar->bindParam(':nombresUsuario', $nombresUsuario);
        $ejecutar->bindParam(':APAUsuario', $APAUsuario);
        $ejecutar->bindParam(':AMAUsuario', $AMAUsuario);
        $ejecutar->bindParam(':correoUsuario', $correoUsuario);
        $ejecutar->bindParam(':nicknameUsuario', $nicknameUsuario);
        $ejecutar->bindParam(':sexoUsuario', $sexoUsuario);
        $ejecutar->bindParam(':contrasenaUsuario', $contrasenaUsuario);
        $ejecutar->bindParam(':NOCUENTA', $NOCUENTA);

        // una vez preparados los campos ejecutamos

        $ejecutar->execute();

         echo json_encode('Cliente guardado exitosamente');

        // seteamos a null para cerrar conexion
        $ejecutar = null; 
        $db = null;

    } catch(PDOException $e) { // por si existe algun error
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});  

// ***  final POST

// *** Inicio PUT (modificar)

$app->put('/api/usuarios/modificar/{id}', function(Request $request, Response $response){ // ruta que usaremos

     // debemos obtener el id 
     $id_usuario = $request->getAttribute('id'); 
    // creamos variables para recibir informacion del frontend
    $nombresUsuario = $request->getParam('nombresUsuario');
    $APAUsuario = $request->getParam('APAUsuario');
    $AMAUsuario = $request->getParam('AMAUsuario');
    $correoUsuario = $request->getParam('correoUsuario');
    $nicknameUsuario = $request->getParam('nicknameUsuario');
    $sexoUsuario = $request->getParam('sexoUsuario');
    $contrasenaUsuario = $request->getParam('contrasenaUsuario');
    $NOCUENTA = $request->getParam('NOCUENTA');

    $consulta = "UPDATE usuario SET
                nombresUsuario = :nombresUsuario,
                APAUsuario = :APAUsuario,
                AMAUsuario = :AMAUsuario,
                correoUsuario = :correoUsuario,
                nicknameUsuario = :nicknameUsuario,
                sexoUsuario = :sexoUsuario,
                contrasenaUsuario = :contrasenaUsuario,
                NOCUENTA = :NOCUENTA
                WHERE idUsuario = $id_usuario"; // guardamos nuestro query para modificar
    
    // ** crear try catch
    try {

        // instancia de nuestra clase bd
        $db = new db();

        $db = $db->conectar();  // usamos la funcion conectar de nuestra clas db
        $ejecutar = $db->prepare($consulta);  // le mandamos el query a la bd para que prepare el resultaro en una variable
        
        // guardar informacion de variables en bd
        $ejecutar->bindParam(':nombresUsuario', $nombresUsuario);
        $ejecutar->bindParam(':APAUsuario', $APAUsuario);
        $ejecutar->bindParam(':AMAUsuario', $AMAUsuario);
        $ejecutar->bindParam(':correoUsuario', $correoUsuario);
        $ejecutar->bindParam(':nicknameUsuario', $nicknameUsuario);
        $ejecutar->bindParam(':sexoUsuario', $sexoUsuario);
        $ejecutar->bindParam(':contrasenaUsuario', $contrasenaUsuario);
        $ejecutar->bindParam(':NOCUENTA', $NOCUENTA);

        // una vez preparados los campos ejecutamos

        $ejecutar->execute();

        echo json_encode('Cliente modificado');

        // seteamos a null para cerrar conexion
        $ejecutar = null; 
        $db = null;

    } catch(PDOException $e) { // por si existe algun error
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});  

// ***  final PUT

// *** Inicio DELETE (eliminar)

$app->delete('/api/usuarios/delete/{id}', function(Request $request, Response $response){ // ruta que usaremos

    // debemos obtener el id 
   $id_usuario = $request->getAttribute('id'); 

   $consulta = "DELETE FROM usuario WHERE idUsuario = $id_usuario"; // guardamos nuestro query para modificar
   
   // ** crear try catch
   try {

       // instancia de nuestra clase bd
       $db = new db();

       $db = $db->conectar();  // usamos la funcion conectar de nuestra clase bd
       $ejecutar = $db->prepare($consulta);  // le mandamos el query a la bd para que prepare el resultaro en una variable
       $ejecutar->execute();
       
       if ($ejecutar->rowCount() > 0) { // si la busqueda del id es encontrada
        echo json_encode("Usuario Eliminado");
       } else {
        echo json_encode("No hay usuario con ese id");
       }

       // seteamos a null para cerrar conexion
       $ejecutar = null; 
       $db = null;

   } catch(PDOException $e) { // por si existe algun error
       echo '{"error": {"text": '.$e->getMessage().'}';
   }
});  

// ***  final DELETE

?>
