<?php

require_once 'conexionbd.php';

class Model_Usuario extends conexionBD
{
  public function VerificarUsuario($email, $pass) {
      $con = conexionBD::conexion();
    
      //$sql = "SELECT * FROM usuario WHERE email = ? AND estado = 'ACTIVO'";
      $sql = "SELECT * FROM usuario WHERE email = ?";
      $query = $con->prepare($sql);
      $query->bindParam(1, $email);
      $query->execute();
    
      $resultado = $query->fetchAll();
      if ($resultado) {
        foreach ($resultado as $email) {
          if (password_verify($pass, $email['pass_hash'])) {
            return $email; // Devuelve los datos del email si está activo
          }
        }
      } else {
        return null; // Usuario no encontrado, no está activo o contraseña incorrecta
      }
      conexionBD::cerrar_conexion();
  }          
  
  public function listar_usuarios() {
      $con = conexionBD::conexion();
      $sql = "SELECT * FROM usuario";
      $arreglo = array();
  
      try {
          $query = $con->prepare($sql);
          $query->execute();
          $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
          
          foreach ($resultado as $rpta) {
              $arreglo["data"][] = $rpta;
          }
  
          conexionBD::cerrar_conexion();
          return $arreglo;
      } catch (PDOException $e) {
          // Manejo de errores en la consulta
          echo "Error al listar usuarios: " . $e->getMessage();
          return null;
      }
  }    

  public function registrar_usuario($nombres, $email, $pass_hash, $rol, $pregunta, $respuesta) {
      $con = conexionBD::conexion();
      
      $estado = 'ACTIVO'; // Definimos el estado por defecto como 'ACTIVO'
      // Establecer el encabezado para indicar que se envía JSON
      header('Content-Type: application/json');
      
      // Verificar si ya existe un usuario con los mismos nombres y email
      $check_sql = "SELECT COUNT(*) AS count FROM usuario WHERE nombres = ? AND email = ?";
      $check_query = $con->prepare($check_sql);
      $check_query->bindParam(1, $nombres);
      $check_query->bindParam(2, $email);
      $check_query->execute();
      $count = $check_query->fetchColumn();
  
      if ($count > 0) {
          // Ya existe un usuario con estos nombres y email, devuelve un mensaje indicando que ya está registrado
          $response = array("status" => "exist");
          echo json_encode($response);
          return; // Salir de la función sin insertar nada más
      }
      // Sí No existe un usuario con estos nombres y email, proceder con la inserción
      $sql = "INSERT INTO usuario (nombres, email, pass_hash, rol, estado, pregunta, respuesta) VALUES (?, ?, ?, ?, ?, ?, ?)";
      $query = $con->prepare($sql);
  
      $query->bindParam(1, $nombres);
      $query->bindParam(2, $email);
      $query->bindParam(3, $pass_hash);
      $query->bindParam(4, $rol);
      $query->bindParam(5, $estado); // Asignamos directamente el valor 'ACTIVO' al estado
      $query->bindParam(6, $pregunta);
      $query->bindParam(7, $respuesta);
  
      try {
          $query->execute();
          $insertedId = $con->lastInsertId(); // Obtener el ID del usuario insertado, si es necesario
          $response = array("status" => "success", "insertedId" => $insertedId);
          echo json_encode($response);
      } catch (PDOException $e) {
          // Manejo de errores en la inserción
          $response = array("status" => "error", "message" => "Error al registrar usuario: " . $e->getMessage());
          echo json_encode($response);
      }
  
      conexionBD::cerrar_conexion();
  }
  
  public function modificar_usuario($id, $nombres, $email, $pass_hash, $rol, $estado, $pregunta, $respuesta) {
    try {
        $con = conexionBD::conexion();

        // Verificar que el valor de la clave primaria del registro que estamos modificando sea correcto
        if ($id <= 0) {
            throw new Exception("El ID del usuario debe ser mayor que 0.");
        }

        // Verificar si el nuevo email ya está siendo utilizado por otro usuario
        $check_sql = "SELECT COUNT(*) AS count FROM usuario WHERE email = ? AND id <> ?";
        $check_query = $con->prepare($check_sql);
        $check_query->bindParam(1, $email);
        $check_query->bindParam(2, $id);
        $check_query->execute();
        $count = $check_query->fetchColumn();

        if ($count > 0) {
            throw new Exception("El email ya está en uso por otro usuario.");
        }

        $sql = "UPDATE usuario SET nombres = ?, email = ?, pass_hash = ?, rol = ?, estado = ?, pregunta=?, respuesta=? WHERE id = ?";
        $query = $con->prepare($sql);

        $query->bindParam(1, $nombres);
        $query->bindParam(2, $email);
        $query->bindParam(3, $pass_hash);
        $query->bindParam(4, $rol);
        $query->bindParam(5, $estado);
        $query->bindParam(6, $pregunta);
        $query->bindParam(7, $respuesta);
        $query->bindParam(8, $id);

        $query->execute();

        // Devolver una respuesta JSON en caso de éxito
        echo json_encode(["message" => "Usuario Modificado.", "success" => true]);
        exit();

    } catch (PDOException $e) {
        // En caso de un error de PDO, devolver una respuesta JSON con el mensaje de error
        echo json_encode(["message" => "Error al modificar usuario: " . $e->getMessage(), "success" => false]);

    } catch (Exception $e) {
        // En caso de una excepción general, devolver una respuesta JSON con el mensaje de error
        echo json_encode(["message" => $e->getMessage(), "success" => false]);

    } finally {
        // Cerrar la conexión aquí, independientemente de si hay una excepción o no
        conexionBD::cerrar_conexion();
    }
  }

  public function ObtenerPreguntaSecreta($email) {
    $con = conexionBD::conexion();

    $sql = "SELECT pregunta, respuesta FROM usuario WHERE email = ? AND estado = 'ACTIVO'";
    $query = $con->prepare($sql);
    $query->bindParam(1, $email);
    $query->execute();

    $resultado = $query->fetch(PDO::FETCH_ASSOC);
    if ($resultado) {
        return $resultado; // Devuelve un array asociativo con la pregunta y la respuesta
    } else {
        return null; // Usuario no encontrado o no está activo
    }
    conexionBD::cerrar_conexion();
}

public function ActualizarContrasena($email, $nuevaContrasena) {
    $con = conexionBD::conexion();

    // Consulta SQL para actualizar la contraseña
    $sql = "UPDATE usuario SET pass_hash = ? WHERE email = ?";
    $query = $con->prepare($sql);
    $query->bindParam(1, $nuevaContrasena); // Utilizamos la nueva contraseña directamente
    $query->bindParam(2, $email);
    
    // Ejecutar la consulta
    $resultado = $query->execute();

    // Verificar si la consulta se ejecutó correctamente
    if ($resultado) {
        return true; // La contraseña se actualizó correctamente
    } else {
        return false; // Ocurrió un error al actualizar la contraseña
    }

    // Cerrar la conexión a la base de datos
    conexionBD::cerrar_conexion();
}


}
?>
