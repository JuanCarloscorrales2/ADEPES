<?php

require "../config/Conexion.php";

class Tablas {

    public $cnx; //variable publica para la conexion a la BD

    function __construct() //constructor
    {
        $this->cnx = Conexion::ConectarDB(); //conexion a la base de datos
    }

/**************************  FUNCIONES TABLA DE TIPOS DE PRESTAMOS ****************************************************************************************** */
    //funcion para listar los datos de la tabla tipos de prestamos
    function ListarTiposPrestamos()
    {
        $query = "SELECT prestamo.idTipoPrestamo, prestamo.idEstadoTipoPrestamo, prestamo.Descripcion as Prestamo, prestamo.tasa,
                        prestamo.PlazoMaximo, prestamo.montoMaximo, prestamo.montoMinimo, estado.descripcion as Estado
                  FROM tbl_mn_tipos_prestamos prestamo
                  INNER JOIN tbl_mn_estadotipoprestamo estado ON estado.idestadoTipoPrestamo = prestamo.idEstadoTipoPrestamo"; //sentencia sql
        $result = $this->cnx->prepare($query);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                    $datos[] = $fila;
                }
                return $datos;
            }
        }
        return false;
    }


    //FUNCION PARA REGISTRArUN TIPO DE PRESTAMO
    function RegistrarTipoPrestamo($Descripcion, $tasa, $PlazoMaximo, $montoMaximo, $montoMinimo){
        $query = "INSERT INTO tbl_mn_tipos_prestamos (idEstadoTipoPrestamo, Descripcion, tasa, PlazoMaximo, montoMaximo, montoMinimo)
                 VALUES(1, ?, ?, ?, ?, ?)";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$tasa);
        $result->bindParam(3,$PlazoMaximo);
        $result->bindParam(4,$montoMaximo);
        $result->bindParam(5,$montoMinimo);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

     //funcion que trae los datos del prestamo a actualizar
     function ObtenerTipoPrestamoPorId($idTipoPrestamo)
     {
         $query = "SELECT * FROM tbl_mn_tipos_prestamos WHERE idTipoPrestamo = ?"; 
         $result = $this->cnx->prepare($query);
         $result->bindParam(1,$idTipoPrestamo);
         if($result->execute())
         {
            return $result->fetch(PDO::FETCH_ASSOC);
         }
         return false;
     }

   //FUNCION QUE trae el estado del prestamo a actualizar para el select
    function ListarEstadoPrestamoSelectEdit($idTipoPrestamo) {
        $query = "SELECT estado.idestadoTipoPrestamo, estado.descripcion 
                 FROM tbl_mn_tipos_prestamos prestamo
                 INNER JOIN tbl_mn_estadotipoprestamo estado ON prestamo.idEstadoTipoPrestamo = estado.idestadoTipoPrestamo
                 WHERE prestamo.idTipoPrestamo = ? UNION SELECT idestadoTipoPrestamo, descripcion FROM tbl_mn_estadotipoprestamo"; 
        $result = $this->cnx->prepare($query);
        $result->bindParam(1,$idTipoPrestamo);
        if($result->execute())
        {
            if($result->rowCount() > 0){ //validacion para verificar si trae datos
                
               while($fila = $result->fetch(PDO::FETCH_ASSOC)){
                   $datos[] = $fila;
               }
                return $datos;
            }
        }
        return false;
    }

      //FUNCION PARA ACTUALIZR el tipo de prestamo
    function ActualizarTipoPrestamo($idTipoPrestamo, $idEstadoTipoPrestamo, $Descripcion, $tasa, $PlazoMaximo, $montoMaximo, $montoMinimo){
  
        $query = "UPDATE tbl_mn_tipos_prestamos SET idEstadoTipoPrestamo = ?, Descripcion = ?, tasa = ?, PlazoMaximo = ?, montoMaximo = ?, montoMinimo = ?
            WHERE idTipoPrestamo = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$idEstadoTipoPrestamo);
        $result->bindParam(2,$Descripcion);
        $result->bindParam(3,$tasa);
        $result->bindParam(4,$PlazoMaximo);
        $result->bindParam(5,$montoMaximo);
        $result->bindParam(6,$montoMinimo);
        $result->bindParam(7,$idTipoPrestamo);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }
    //FUNCION PARA PONER INACTIVO UN TIPO DE PRESTAMO
    function ConsultarEstadoPrestamo($idTipoPrestamo) {
        try {
            // Consultar que el préstamo no esté en uso
            $queryP = "SELECT * FROM tbl_mn_solicitudes_creditos WHERE idTipoPrestamo = ?";
            $resultP = $this->cnx->prepare($queryP);
            $resultP->bindParam(1, $idTipoPrestamo);
            
            if ($resultP->execute()) {
                if ($resultP->rowCount() > 0) {
                    // Si existen resultados, el préstamo está en uso
                    return "existe";
                } else {
                    // Si no hay resultados, el préstamo no está en uso
                    return "noexiste";
                }
            } else {
                // Manejo de errores en la ejecución de la consulta
                return "error";
            }
        } catch (PDOException $e) {
            // Manejo de errores de base de datos
            return "error_db";
        }
    }
    

    //FUNCION PARA PONER INACTIVO UN TIPO DE PRESTAMO
    function InactivarTipoPrestamo($idTipoPrestamo){
        //consultar que el prestamo no este en uso
        $queryP = "SELECT * FROM tbl_mn_solicitudes_creditos WHERE idTipoPrestamo = ?"; //sentencia sql
        $resultP = $this->cnx->prepare($queryP);
        $resultP->bindParam(1,$idTipoPrestamo);
        if($resultP->execute())
        {
            if($resultP->rowCount() > 0){ //validacion para verificar si trae datos
                return "enUso";
                
            }else{  //actualiza el prestamo a inactivo
                
                $query = "UPDATE tbl_mn_tipos_prestamos SET idEstadoTipoPrestamo = 2 WHERE idTipoPrestamo = ?";
                $result = $this->cnx->prepare($query); //preparacion de la sentencia
                $result->bindParam(1,$idTipoPrestamo);
                if($result->execute()){ //validacion de la ejecucion
                    return "inactivado";
                }

            }
        }


        

        return false; //si fallo se devuelvo false

    }

    function ActivarTipoPrestamo($idTipoPrestamo){
        $query = "UPDATE tbl_mn_tipos_prestamos SET idEstadoTipoPrestamo = 1 WHERE idTipoPrestamo = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$idTipoPrestamo);

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    

/****************************** FUNCIONES TABLA ESTADO CIVIL **************************************************************** */

  //funcion para listar los datos de la tabla estado civil
  function ListarEstadoCivil()
  {
      $query = "SELECT * FROM tbl_mn_estadocivil"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }

  //FUNCION PARA REGISTRAR UN NUEVO ESTADO CIVIL
 /* function RegistrarEstadoCivil($Descripcion){
    $query = "INSERT INTO tbl_mn_estadocivil (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}*/
function RegistrarEstadoCivil($Descripcion){
    // Consulta para verificar si ya existe un registro con la misma descripción
    $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_estadocivil WHERE Descripcion = ?";
    $checkResult = $this->cnx->prepare($checkQuery);
    $checkResult->bindParam(1, $Descripcion);
    $checkResult->execute();
    $row = $checkResult->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        // Si ya existe un registro con la misma descripción, devuelve false
        return "existeCivil";
    }

    // Si no existe, procede con la inserción
    $insertQuery = "INSERT INTO tbl_mn_estadocivil (Descripcion) VALUES(?)";
    $insertResult = $this->cnx->prepare($insertQuery);
    $insertResult->bindParam(1, $Descripcion);

    if ($insertResult->execute()) { 
        // Si la inserción fue exitosa, devuelve true
        return "inserto";
    }

    // Si la inserción falla, devuelve false
    return false;
}


 //funcion que trae los datos del prestamo a actualizar
 function ObtenerEstadoCivilPorId($idEstadoCivil)
 {
     $query = "SELECT * FROM tbl_mn_estadocivil WHERE idEstadoCivil = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idEstadoCivil);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS ESTADO CIVILES
    function ActualizarEstadoCivil($idEstadoCivil, $Descripcion){

        // Consulta para verificar si ya existe un registro con la misma descripción
        $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_estadocivil WHERE Descripcion = ? AND idEstadoCivil != ?";
        $checkResult = $this->cnx->prepare($checkQuery);
        $checkResult->bindParam(1, $Descripcion);
        $checkResult->bindParam(2, $idEstadoCivil);
        $checkResult->execute();
        $row = $checkResult->fetch(PDO::FETCH_ASSOC);

        if ($row['total'] > 0) {
            // Si ya existe un registro con la misma descripción, devuelve false
            return "existeCivil";
        }


        //si no existe actualiza
        $query = "UPDATE tbl_mn_estadocivil SET Descripcion = ? WHERE idEstadoCivil = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idEstadoCivil);
     

        if($result->execute()){ //validacion de la ejecucion
            return "inserto";
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN ESTADO CIVIL
    function EliminarEstadoCivil($idEstadoCivil) {
        try {
            $query = "DELETE FROM tbl_mn_estadocivil WHERE idEstadoCivil = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idEstadoCivil);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    



/*********************FUNCIONES DE LA TABLA PARENTESCO  ********************************************************/


  //funcion para listar los datos de la tabla estado civil
  function ListarParentesco()
  {
      $query = "SELECT * FROM tbl_mn_parentesco"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO PARENTESCO
 function RegistrarParentesco($Descripcion){

    // Consulta para verificar si ya existe un registro con la misma descripción
    $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_parentesco WHERE Descripcion = ?";
    $checkResult = $this->cnx->prepare($checkQuery);
    $checkResult->bindParam(1, $Descripcion);
    $checkResult->execute();
    $row = $checkResult->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        // Si ya existe un registro con la misma descripción, devuelve false
        return "existe";
    }
    $query = "INSERT INTO tbl_mn_parentesco (descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return "inserto";
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerParentescoPorId($idParentesco)
 {
     $query = "SELECT * FROM tbl_mn_parentesco WHERE idParentesco = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idParentesco);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarParentesco($idParentesco, $descripcion){

        // Consulta para verificar si ya existe un registro con la misma descripción
        $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_parentesco WHERE descripcion = ? AND idParentesco != ?";
        $checkResult = $this->cnx->prepare($checkQuery);
        $checkResult->bindParam(1, $descripcion);
        $checkResult->bindParam(2, $idParentesco);
        $checkResult->execute();
        $row = $checkResult->fetch(PDO::FETCH_ASSOC);

        if ($row['total'] > 0) {
            // Si ya existe un registro con la misma descripción, devuelve false
            return "existe";
        }

        $query = "UPDATE tbl_mn_parentesco SET descripcion = ? WHERE idParentesco = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$descripcion);
        $result->bindParam(2,$idParentesco);
     

        if($result->execute()){ //validacion de la ejecucion
            return "inserto";
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarParentesco($idParentesco) {
        try {
            $query = "DELETE FROM tbl_mn_parentesco WHERE idParentesco = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idParentesco);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    

/*********************FUNCIONES DE LA TABLA Categoria casa ********************************************************/


  //funcion para listar los datos de la CATEGORIA
  function ListarCategoriaCasa()
  {
      $query = "SELECT * FROM tbl_mn_categoria_casa"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
//FUNCION PARA REGISTRAR UN NUEVO CATEGORIA
function RegistrarCategoria($Descripcion){

     // Consulta para verificar si ya existe un registro con la misma descripción
     $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_categoria_casa WHERE descripcion = ?";
     $checkResult = $this->cnx->prepare($checkQuery);
     $checkResult->bindParam(1, $Descripcion);
     $checkResult->execute();
     $row = $checkResult->fetch(PDO::FETCH_ASSOC);
 
     if ($row['total'] > 0) {
         // Si ya existe un registro con la misma descripción, devuelve false
         return "existe";
     }

    $query = "INSERT INTO tbl_mn_categoria_casa (descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return "inserto";
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerCategoriaPorId($idcategoriaCasa)
 {
     $query = "SELECT * FROM tbl_mn_categoria_casa WHERE idcategoriaCasa = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idcategoriaCasa);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }


    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarCategoria($idcategoriaCasa, $descripcion){

         // Consulta para verificar si ya existe un registro con la misma descripción
        $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_categoria_casa WHERE descripcion = ? AND idcategoriaCasa != ? ";
        $checkResult = $this->cnx->prepare($checkQuery);
        $checkResult->bindParam(1, $descripcion);
        $checkResult->bindParam(2, $idcategoriaCasa);
        $checkResult->execute();
        $row = $checkResult->fetch(PDO::FETCH_ASSOC);
    
        if ($row['total'] > 0) {
            // Si ya existe un registro con la misma descripción, devuelve false
            return "existe";
        }

        $query = "UPDATE tbl_mn_categoria_casa SET descripcion = ? WHERE idcategoriaCasa = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$descripcion);
        $result->bindParam(2,$idcategoriaCasa);
     

        if($result->execute()){ //validacion de la ejecucion
            return "inserto";
        }

        return false; //si fallo se devuelvo false

    }
    //FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarCategoria($idcategoriaCasa) {
        try {
            $query = "DELETE FROM tbl_mn_categoria_casa WHERE idcategoriaCasa = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idcategoriaCasa);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    /*********************FUNCIONES DE LA TABLA GENERO  ********************************************************/


  //funcion para listar los datos de la tabla GENERO
  function ListarGenero()
  {
      $query = "SELECT * FROM tbl_mn_genero"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO PARENTESCO
 function RegistrarGenero($Descripcion){

    // Consulta para verificar si ya existe un registro con la misma descripción
    $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_genero WHERE Descripcion = ?";
    $checkResult = $this->cnx->prepare($checkQuery);
    $checkResult->bindParam(1, $Descripcion);
    $checkResult->execute();
    $row = $checkResult->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        // Si ya existe un registro con la misma descripción, devuelve false
        return "existe";
    }

    $query = "INSERT INTO tbl_mn_genero (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return "inserto";
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerGenerocoPorId($idGenero)
 {
     $query = "SELECT * FROM tbl_mn_genero WHERE idGenero = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idGenero);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarGenero($idGenero, $Descripcion){

         // Consulta para verificar si ya existe un registro con la misma descripción
         $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_genero WHERE Descripcion = ? AND idGenero != ? ";
         $checkResult = $this->cnx->prepare($checkQuery);
         $checkResult->bindParam(1, $Descripcion);
         $checkResult->bindParam(2, $idGenero);
         $checkResult->execute();
         $row = $checkResult->fetch(PDO::FETCH_ASSOC);
     
         if ($row['total'] > 0) {
             // Si ya existe un registro con la misma descripción, devuelve false
             return "existe";
         }
        $query = "UPDATE tbl_mn_genero SET Descripcion = ? WHERE idGenero = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idGenero);
     

        if($result->execute()){ //validacion de la ejecucion
            return "inserto";
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarGenero($idGenero) {
        try {
            $query = "DELETE FROM tbl_mn_genero WHERE idGenero = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idGenero);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
   /*********************FUNCIONES DE LA TABLA CONTACTO ********************************************************/


  //funcion para listar los datos de la tabla GENERO
  function ListarContacto()
  {
      $query = "SELECT * FROM tbl_mn_tipo_contacto"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO PARENTESCO
 function RegistrarContacto($Descripcion){

    // Consulta para verificar si ya existe un registro con la misma descripción
    $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_tipo_contacto WHERE Descripcion = ?";
    $checkResult = $this->cnx->prepare($checkQuery);
    $checkResult->bindParam(1, $Descripcion);
    $checkResult->execute();
    $row = $checkResult->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        // Si ya existe un registro con la misma descripción, devuelve false
        return "existe";
    }

    $query = "INSERT INTO tbl_mn_tipo_contacto (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return "inserto";
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerContactoPorId($idTipoContacto)
 {
     $query = "SELECT * FROM tbl_mn_tipo_contacto WHERE idTipoContacto = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idTipoContacto);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarContacto($idTipoContacto, $Descripcion){

         // Consulta para verificar si ya existe un registro con la misma descripción
         $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_tipo_contacto WHERE Descripcion = ? AND idTipoContacto != ? ";
         $checkResult = $this->cnx->prepare($checkQuery);
         $checkResult->bindParam(1, $Descripcion);
         $checkResult->bindParam(2, $idTipoContacto);
         $checkResult->execute();
         $row = $checkResult->fetch(PDO::FETCH_ASSOC);
     
         if ($row['total'] > 0) {
             // Si ya existe un registro con la misma descripción, devuelve false
             return "existe";
         }

        $query = "UPDATE tbl_mn_tipo_contacto SET Descripcion = ? WHERE idTipoContacto = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idTipoContacto);
     

        if($result->execute()){ //validacion de la ejecucion
            return "inserto";
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarContacto($idTipoContacto) {
        try {
            $query = "DELETE FROM tbl_mn_tipo_contacto WHERE idTipoContacto = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idTipoContacto);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    
    /*********************FUNCIONES DE LA TABLA BIENES ********************************************************/


  //funcion para listar los datos de la tabla GENERO
  function ListarBienes()
  {
      $query = "SELECT * FROM tbl_mn_personas_bienes"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO PARENTESCO
 function RegistrarBienes($Descripcion){

    // Consulta para verificar si ya existe un registro con la misma descripción
    $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_personas_bienes WHERE Descripcion = ?";
    $checkResult = $this->cnx->prepare($checkQuery);
    $checkResult->bindParam(1, $Descripcion);
    $checkResult->execute();
    $row = $checkResult->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        // Si ya existe un registro con la misma descripción, devuelve false
        return "existe";
    }

    $query = "INSERT INTO tbl_mn_personas_bienes (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return "inserto";
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerBienesPorId($idPersonaBienes)
 {
     $query = "SELECT * FROM tbl_mn_personas_bienes WHERE idPersonaBienes = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idPersonaBienes);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarBienes($idPersonaBienes, $Descripcion){

         // Consulta para verificar si ya existe un registro con la misma descripción
         $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_personas_bienes WHERE Descripcion = ? AND idPersonaBienes != ? ";
         $checkResult = $this->cnx->prepare($checkQuery);
         $checkResult->bindParam(1, $Descripcion);
         $checkResult->bindParam(2, $idPersonaBienes);
         $checkResult->execute();
         $row = $checkResult->fetch(PDO::FETCH_ASSOC);
     
         if ($row['total'] > 0) {
             // Si ya existe un registro con la misma descripción, devuelve false
             return "existe";
         }


        $query = "UPDATE tbl_mn_personas_bienes SET Descripcion = ? WHERE idPersonaBienes = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idPersonaBienes);
     

        if($result->execute()){ //validacion de la ejecucion
            return "inserto";
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarBienes($idPersonaBienes) {
        try {
            $query = "DELETE FROM tbl_mn_personas_bienes WHERE idPersonaBienes = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idPersonaBienes);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
     /*********************FUNCIONES DE LA TABLA NACIONALIDAD ********************************************************/


  //funcion para listar los datos de la tabla BIENES 
  function ListarNacionalidad()
  {
      $query = "SELECT * FROM tbl_mn_nacionalidades"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO BIENES 
 function RegistrarNacionalidad($Descripcion){

    // Consulta para verificar si ya existe un registro con la misma descripción
    $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_nacionalidades WHERE Descripcion = ?";
    $checkResult = $this->cnx->prepare($checkQuery);
    $checkResult->bindParam(1, $Descripcion);
    $checkResult->execute();
    $row = $checkResult->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        // Si ya existe un registro con la misma descripción, devuelve false
        return "existe";
    }

    $query = "INSERT INTO tbl_mn_nacionalidades (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return "inserto";
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del BIENES  a actualizar
 function ObtenerNacionalidadPorId($idNacionalidad)
 {
     $query = "SELECT * FROM tbl_mn_nacionalidades WHERE idNacionalidad = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idNacionalidad);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS BIENES 
    function ActualizarNacionalidad($idNacionalidad, $Descripcion){

         // Consulta para verificar si ya existe un registro con la misma descripción
         $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_nacionalidades WHERE Descripcion = ? AND idNacionalidad != ? ";
         $checkResult = $this->cnx->prepare($checkQuery);
         $checkResult->bindParam(1, $Descripcion);
         $checkResult->bindParam(2, $idNacionalidad);
         $checkResult->execute();
         $row = $checkResult->fetch(PDO::FETCH_ASSOC);
     
         if ($row['total'] > 0) {
             // Si ya existe un registro con la misma descripción, devuelve false
             return "existe";
         }

        $query = "UPDATE tbl_mn_nacionalidades SET Descripcion = ? WHERE idNacionalidad = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idNacionalidad);
     

        if($result->execute()){ //validacion de la ejecucion
            return "inserto";
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN BIENES 
    function EliminarNacionalidad($idNacionalidad) {
        try {
            $query = "DELETE FROM tbl_mn_nacionalidades WHERE idNacionalidad = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idNacionalidad);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
      /*********************FUNCIONES DE LA TABLA TIEMPO LABORAL  ********************************************************/


  //funcion para listar los datos de la tabla estado civil
  function ListarLaboral()
  {
      $query = "SELECT * FROM tbl_mn_tiempo_laboral"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO PARENTESCO
 function RegistrarLaboral($Descripcion){

     // Consulta para verificar si ya existe un registro con la misma descripción
     $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_tiempo_laboral WHERE descripcion = ?";
     $checkResult = $this->cnx->prepare($checkQuery);
     $checkResult->bindParam(1, $Descripcion);
     $checkResult->execute();
     $row = $checkResult->fetch(PDO::FETCH_ASSOC);
 
     if ($row['total'] > 0) {
         // Si ya existe un registro con la misma descripción, devuelve false
         return "existe";
     }

    $query = "INSERT INTO tbl_mn_tiempo_laboral (descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return "inserto";
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerLaboralPorId($idTiempoLaboral)
 {
     $query = "SELECT * FROM tbl_mn_tiempo_laboral WHERE idTiempoLaboral = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idTiempoLaboral);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarLaboral($idTiempoLaboral, $descripcion){

        // Consulta para verificar si ya existe un registro con la misma descripción
        $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_tiempo_laboral WHERE descripcion = ? AND idTiempoLaboral != ? ";
        $checkResult = $this->cnx->prepare($checkQuery);
        $checkResult->bindParam(1, $descripcion);
        $checkResult->bindParam(2, $idTiempoLaboral);
        $checkResult->execute();
        $row = $checkResult->fetch(PDO::FETCH_ASSOC);
    
        if ($row['total'] > 0) {
            // Si ya existe un registro con la misma descripción, devuelve false
            return "existe";
        }

        $query = "UPDATE tbl_mn_tiempo_laboral SET descripcion = ? WHERE idTiempoLaboral = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$descripcion);
        $result->bindParam(2,$idTiempoLaboral);
     

        if($result->execute()){ //validacion de la ejecucion
            return "inserto";
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarLaboral($idTiempoLaboral) {
        try {
            $query = "DELETE FROM tbl_mn_tiempo_laboral WHERE idTiempoLaboral = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idTiempoLaboral);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
        /*********************FUNCIONES DE LA TABLA ESTADO PLAN PAGO********************************************************/


  //funcion para listar los datos de la tabla BIENES 
  function ListarEstadoplanpago()
  {
      $query = "SELECT * FROM tbl_mn_estadoplanpagos"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO BIENES 
 function RegistrarEstadoplanpago($Descripcion){

    // Consulta para verificar si ya existe un registro con la misma descripción
    $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_estadoplanpagos WHERE Descripcion = ?";
    $checkResult = $this->cnx->prepare($checkQuery);
    $checkResult->bindParam(1, $Descripcion);
    $checkResult->execute();
    $row = $checkResult->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        // Si ya existe un registro con la misma descripción, devuelve false
        return "existe";
    }

    $query = "INSERT INTO tbl_mn_estadoplanpagos (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return "inserto";
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del BIENES  a actualizar
 function ObtenerEstadoplanpagoPorId($idEstadoPlanPagos)
 {
     $query = "SELECT * FROM tbl_mn_estadoplanpagos WHERE idEstadoPlanPagos = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idEstadoPlanPagos);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS BIENES 
    function ActualizarEstadoplanpago($idEstadoPlanPagos, $Descripcion){

        // Consulta para verificar si ya existe un registro con la misma descripción
        $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_estadoplanpagos WHERE Descripcion = ? AND idEstadoPlanPagos != ? ";
        $checkResult = $this->cnx->prepare($checkQuery);
        $checkResult->bindParam(1, $Descripcion);
        $checkResult->bindParam(2, $idEstadoPlanPagos);
        $checkResult->execute();
        $row = $checkResult->fetch(PDO::FETCH_ASSOC);
    
        if ($row['total'] > 0) {
            // Si ya existe un registro con la misma descripción, devuelve false
            return "existe";
        }

        $query = "UPDATE tbl_mn_estadoplanpagos SET Descripcion = ? WHERE idEstadoPlanPagos = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idEstadoPlanPagos);
     

        if($result->execute()){ //validacion de la ejecucion
            return "inserto";
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN BIENES 
    function EliminarEstadoplanpago($idEstadoPlanPagos) {
        try {
            $query = "DELETE FROM tbl_mn_estadoplanpagos WHERE idEstadoPlanPagos = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idEstadoPlanPagos);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    } 
      /*********************FUNCIONES DE LA TABLA TIEMPO VIVIR ********************************************************/


  //funcion para listar los datos de la tabla estado civil
  function ListarTiempovivir()
  {
      $query = "SELECT * FROM tbl_mn_tiempo_vivir"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO PARENTESCO
 function RegistrarTiempovivir($Descripcion){

    // Consulta para verificar si ya existe un registro con la misma descripción
    $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_tiempo_vivir WHERE descripcion = ?";
    $checkResult = $this->cnx->prepare($checkQuery);
    $checkResult->bindParam(1, $Descripcion);
    $checkResult->execute();
    $row = $checkResult->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        // Si ya existe un registro con la misma descripción, devuelve false
        return "existe";
    }
    $query = "INSERT INTO tbl_mn_tiempo_vivir (descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return "inserto";
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerTiempovivirPorId($idtiempoVivir)
 {
     $query = "SELECT * FROM tbl_mn_tiempo_vivir WHERE idtiempoVivir = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idtiempoVivir);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarTiempovivir($idtiempoVivir, $descripcion){

         // Consulta para verificar si ya existe un registro con la misma descripción
         $checkQuery = "SELECT COUNT(*) AS total FROM tbl_mn_tiempo_vivir WHERE descripcion = ? AND idtiempoVivir != ? ";
         $checkResult = $this->cnx->prepare($checkQuery);
         $checkResult->bindParam(1, $descripcion);
         $checkResult->bindParam(2, $idtiempoVivir);
         $checkResult->execute();
         $row = $checkResult->fetch(PDO::FETCH_ASSOC);
     
         if ($row['total'] > 0) {
             // Si ya existe un registro con la misma descripción, devuelve false
             return "existe";
         }

        $query = "UPDATE tbl_mn_tiempo_vivir SET descripcion = ? WHERE idtiempoVivir = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$descripcion);
        $result->bindParam(2,$idtiempoVivir);
     

        if($result->execute()){ //validacion de la ejecucion
            return "inserto";
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarTiempovivir($idtiempoVivir) {
        try {
            $query = "DELETE FROM tbl_mn_tiempo_vivir WHERE idtiempoVivir = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idtiempoVivir);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
      /*********************FUNCIONES DE LA TABLA ESTADO TIPO PRESTAMO ********************************************************/


  //funcion para listar los datos de la tabla estado civil
  function ListarEstadotipoprestamo()
  {
      $query = "SELECT * FROM tbl_mn_estadotipoprestamo"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO PARENTESCO
 function RegistrarEstadotipoprestamo($Descripcion){
    $query = "INSERT INTO tbl_mn_estadotipoprestamo (descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerEstadotipoprestamoPorId($idestadoTipoPrestamo)
 {
     $query = "SELECT * FROM tbl_mn_estadotipoprestamo WHERE idestadoTipoPrestamo = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idestadoTipoPrestamo);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarEstadotipoprestamo($idestadoTipoPrestamo, $descripcion){
        $query = "UPDATE tbl_mn_estadotipoprestamo SET descripcion = ? WHERE idestadoTipoPrestamo = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$descripcion);
        $result->bindParam(2,$idestadoTipoPrestamo);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarEstadotipoprestamo($idestadoTipoPrestamo) {
        try {
            $query = "DELETE FROM tbl_mn_estadotipoprestamo WHERE idestadoTipoPrestamo = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idestadoTipoPrestamo);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    /*********************FUNCIONES DE LA TABLA ESTADO PLAN PAGO********************************************************/


  //funcion para listar los datos de la tabla BIENES 
  function ListarEstadosolicitud()
  {
      $query = "SELECT * FROM tbl_mn_estados_solicitudes"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO BIENES 
 function RegistrarEstadosolicitud($Descripcion){
    $query = "INSERT INTO tbl_mn_estados_solicitudes (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del BIENES  a actualizar
 function ObtenerEstadosolicitudPorId($idEstadoSolicitud)
 {
     $query = "SELECT * FROM tbl_mn_estados_solicitudes WHERE idEstadoSolicitud = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idEstadoSolicitud);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS BIENES 
    function ActualizarEstadosolicitud($idEstadoSolicitud, $Descripcion){
        $query = "UPDATE tbl_mn_estados_solicitudes SET Descripcion = ? WHERE idEstadoSolicitud = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idEstadoSolicitud);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN BIENES 
    function EliminarEstadosolicitud($idEstadoSolicitud) {
        try {
            $query = "DELETE FROM tbl_mn_estados_solicitudes WHERE idEstadoSolicitud = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idEstadoSolicitud);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    } 
     /*********************FUNCIONES DE LA TABLA ESTADO RUBRO********************************************************/


  //funcion para listar los datos de la tabla BIENES 
  function ListarRubro()
  {
      $query = "SELECT * FROM tbl_mn_rubros"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO BIENES 
 function RegistrarRubro($Descripcion){
    $query = "INSERT INTO tbl_mn_rubros (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del BIENES  a actualizar
 function ObtenerRubroPorId($idRubro)
 {
     $query = "SELECT * FROM tbl_mn_rubros WHERE idRubro = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idRubro);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS BIENES 
    function ActualizarRubro($idRubro, $Descripcion){
        $query = "UPDATE tbl_mn_rubros SET Descripcion = ? WHERE idRubro = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idRubro);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN BIENES 
    function EliminarRubro($idRubro) {
        try {
            $query = "DELETE FROM tbl_mn_rubros WHERE idRubro = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idRubro);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    } 
    /*********************FUNCIONES DE LA TABLA Profesion ********************************************************/


  //funcion para listar los datos de la tabla GENERO
  function ListarProfesion()
  {
      $query = "SELECT * FROM tbl_mn_profesiones_oficios"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO PARENTESCO
 function RegistrarProfesion($Descripcion){
    $query = "INSERT INTO tbl_mn_profesiones_oficios (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerProfesionPorId($idProfesion)
 {
     $query = "SELECT * FROM tbl_mn_profesiones_oficios WHERE idProfesion = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idProfesion);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarProfesion($idProfesion, $Descripcion){
        $query = "UPDATE tbl_mn_profesiones_oficios SET Descripcion = ? WHERE idProfesion = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idProfesion);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarProfesion($idProfesion) {
        try {
            $query = "DELETE FROM tbl_mn_profesiones_oficios WHERE idProfesion = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idProfesion);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }

    /*********************FUNCIONES DE LA TABLA ESTADO USUARIO ********************************************************/


  //funcion para listar los datos de la tabla GENERO
  function listar_Estadousuario()
  {
      $query = "SELECT * FROM tbl_ms_estado_usuario"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
    
  }
     
 //FUNCION PARA REGISTRAR UN NUEVO PARENTESCO
 function RegistrarEstadousuario($Descripcion){
    $query = "INSERT INTO tbl_ms_estado_usuario (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerEstadousuarioPorId($idEstadoUsuario)
 {
     $query = "SELECT * FROM tbl_ms_estado_usuario WHERE idEstadoUsuario = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idEstadoUsuario);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarEstadousuario($idEstadoUsuario, $Descripcion){
        $query = "UPDATE tbl_ms_estado_usuario SET Descripcion = ? WHERE idEstadoUsuario = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idEstadoUsuario);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarEstadousuario($idEstadoUsuario) {
        try {
            $query = "DELETE FROM tbl_ms_estado_usuario WHERE idEstadoUsuario = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idEstadoUsuario);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    /*********************FUNCIONES DE LA TABLA MUNICIPIO********************************************************/


  //funcion para listar los datos de la tabla GENERO
  function ListarMunicipio()
  {
      $query = "SELECT * FROM tbl_mn_municipio"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
 //FUNCION PARA REGISTRAR UN NUEVO PARENTESCO
 function RegistrarMunicipio($Descripcion){
    $query = "INSERT INTO tbl_mn_municipio (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del parentesco a actualizar
 function ObtenerMunicipioPorId($idMunicipio)
 {
     $query = "SELECT * FROM tbl_mn_municipio WHERE idMunicipio = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idMunicipio);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS PARENTESCO 
    function ActualizarMunicipio($idMunicipio, $Descripcion){
        $query = "UPDATE tbl_mn_municipio SET Descripcion = ? WHERE idMunicipio = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idMunicipio);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN PARENTESCO
    function EliminarMunicipio($idMunicipio) {
        try {
            $query = "DELETE FROM tbl_mn_municipio WHERE idMunicipio = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idMunicipio);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    /*********************FUNCIONES DE LA TABLA Tipos de pagos ********************************************************/


  //funcion para listar los datos de tipo pago
  function ListarTipoPago()
  {
      $query = "SELECT * FROM tbl_mn_tipos_de_pago"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
//FUNCION PARA REGISTRAR UN NUEVO TIPO PAGO
function RegistrarTipoPago($Descripcion){
    $query = "INSERT INTO tbl_mn_tipos_de_pago (descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del tipo pago a actualizar
 function ObtenerTipoPagoPorId($idTipoPago)
 {
     $query = "SELECT * FROM tbl_mn_tipos_de_pago WHERE idTipoPago = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idTipoPago);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }


    //FUNCION PARA ACTUALIZR TIPO PAGO 
    function ActualizarTipoPago($idTipoPago, $descripcion){
        $query = "UPDATE tbl_mn_tipos_de_pago SET descripcion = ? WHERE idTipoPago = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$descripcion);
        $result->bindParam(2,$idTipoPago);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }
    //FUNCION PARA ELIMINAR UN TIPO PAGO
    function EliminarTipoPago($idTipoPago) {
        try {
            $query = "DELETE FROM tbl_mn_tipos_de_pago WHERE idTipoPago = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idTipoPago);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    /*********************FUNCIONES DE LA TABLA Tipo Cliente *******************************************************/


  //funcion para listar los datos de tipo pago
  function ListarTipoCliente()
  {
      $query = "SELECT * FROM tbl_mn_tipo_clientes"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
//FUNCION PARA REGISTRAR UN NUEVO TIPO PAGO
function RegistrarTipoCliente($Descripcion){
    $query = "INSERT INTO tbl_mn_tipo_clientes (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del tipo pago a actualizar
 function ObtenerTipoClientePorId($idTipoCliente)
 {
     $query = "SELECT * FROM tbl_mn_tipo_clientes WHERE idTipoCliente = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idTipoCliente);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }


    //FUNCION PARA ACTUALIZR TIPO PAGO 
    function ActualizarTipoCliente($idTipoCliente, $descripcion){
        $query = "UPDATE tbl_mn_tipo_clientes SET Descripcion = ? WHERE idTipoCliente = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$descripcion);
        $result->bindParam(2,$idTipoCliente);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }
    //FUNCION PARA ELIMINAR UN TIPO PAGO
    function EliminarTipoCliente($idTipoCliente) {
        try {
            $query = "DELETE FROM tbl_mn_tipo_clientes WHERE idTipoCliente = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idTipoCliente);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    /*********************FUNCIONES DE LA TABLA ESTADO CREDITO*******************************************************/


  //funcion para listar los datos de estado
  function ListarEstadoCredito()
  {
      $query = "SELECT * FROM tbl_mn_estado_credito"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
//FUNCION PARA REGISTRAR UN NUEVO TIPO PAGO
function RegistrarEstadoCredito($Descripcion){
    $query = "INSERT INTO tbl_mn_estado_credito (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del tipo pago a actualizar
 function ObtenerEstadoCreditoPorId($idEstadoCredito)
 {
     $query = "SELECT * FROM tbl_mn_estado_credito WHERE idEstadoCredito = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idEstadoCredito);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }


    //FUNCION PARA ACTUALIZR TIPO PAGO 
    function ActualizarEstadoCredito($idEstadoCredito, $descripcion){
        $query = "UPDATE tbl_mn_estado_credito SET Descripcion = ? WHERE idEstadoCredito = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$descripcion);
        $result->bindParam(2,$idEstadoCredito);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }
    //FUNCION PARA ELIMINAR UN TIPO PAGO
    function EliminarEstadoCredito($idEstadoCredito) {
        try {
            $query = "DELETE FROM tbl_mn_estado_credito WHERE idEstadoCredito = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idEstadoCredito);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    /*********************FUNCIONES DE LA TABLA ANALISIS CREDITICIO*******************************************************/
//funcion para listar los datos de tipo pago
function ListarAnalisis()
{
    $query = "SELECT * FROM tbl_mn_estado_analisiscrediticio"; //sentencia sql
    $result = $this->cnx->prepare($query);
    if($result->execute())
    {
        if($result->rowCount() > 0){ //validacion para verificar si trae datos
            while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                $datos[] = $fila;
            }
            return $datos;
        }
    }
    return false;
}
  
//FUNCION PARA REGISTRAR UN NUEVO TIPO PAGO
function RegistrarAnalisis($Descripcion){
  $query = "INSERT INTO tbl_mn_estado_analisiscrediticio (descripcion) VALUES(?)";
  $result = $this->cnx->prepare($query); //preparacion de la sentencia
  $result->bindParam(1,$Descripcion);

  if($result->execute()){ //validacion de la ejecucion
      return true;
  }

  return false; //si fallo se devuelvo false

}

//funcion que trae los datos del tipo pago a actualizar
function ObtenerAnalisisPorId($idestadoAnalisisCrediticio)
{
   $query = "SELECT * FROM tbl_mn_estado_analisiscrediticio WHERE idestadoAnalisisCrediticio = ?"; 
   $result = $this->cnx->prepare($query);
   $result->bindParam(1,$idestadoAnalisisCrediticio);
   if($result->execute())
   {
      return $result->fetch(PDO::FETCH_ASSOC);
   }
   return false;
}


  //FUNCION PARA ACTUALIZR TIPO PAGO 
  function ActualizarAnalisis($idestadoAnalisisCrediticio, $descripcion){
      $query = "UPDATE tbl_mn_estado_analisiscrediticio SET descripcion = ? WHERE idestadoAnalisisCrediticio = ?";
      $result = $this->cnx->prepare($query); //preparacion de la sentencia
      $result->bindParam(1,$descripcion);
      $result->bindParam(2,$idestadoAnalisisCrediticio);
   

      if($result->execute()){ //validacion de la ejecucion
          return true;
      }

      return false; //si fallo se devuelvo false

  }
  //FUNCION PARA ELIMINAR UN TIPO PAGO
  function EliminarAnalisis($idestadoAnalisisCrediticio) {
      try {
          $query = "DELETE FROM tbl_mn_estado_analisiscrediticio WHERE idestadoAnalisisCrediticio = ?";
          $result = $this->cnx->prepare($query);
          $result->bindParam(1, $idestadoAnalisisCrediticio);
  
          if ($result->execute()) {
              return "elimino";
          }
  
      } catch (PDOException $e) {
         
          if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
          
              return "Llave en uso"; // mensaje de llave ya en uso error 1451
          } else {
              
              return "error";
          }
      }
  }
/*********************FUNCIONES DE LA TABLA Avala*******************************************************/
//funcion para listar los datos de Avala a persona
function ListarAvala()
{
    $query = "SELECT * FROM tbl_mn_avala_a_persona"; //sentencia sql
    $result = $this->cnx->prepare($query);
    if($result->execute())
    {
        if($result->rowCount() > 0){ //validacion para verificar si trae datos
            while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                $datos[] = $fila;
            }
            return $datos;
        }
    }
    return false;
}
  
//FUNCION PARA REGISTRAR UN NUEVO AVALA
function RegistrarAvala($Descripcion){
  $query = "INSERT INTO tbl_mn_avala_a_persona (Descripcion) VALUES(?)";
  $result = $this->cnx->prepare($query); //preparacion de la sentencia
  $result->bindParam(1,$Descripcion);

  if($result->execute()){ //validacion de la ejecucion
      return true;
  }

  return false; //si fallo se devuelvo false

}

//funcion que trae los datos del tipo pago a actualizar
function ObtenerAvalaPorId($idEsAval)
{
   $query = "SELECT * FROM tbl_mn_avala_a_persona WHERE idEsAval = ?"; 
   $result = $this->cnx->prepare($query);
   $result->bindParam(1,$idEsAval);
   if($result->execute())
   {
      return $result->fetch(PDO::FETCH_ASSOC);
   }
   return false;
}


  //FUNCION PARA ACTUALIZR TIPO PAGO 
  function ActualizarAvala($idEsAval, $descripcion){
      $query = "UPDATE tbl_mn_avala_a_persona SET Descripcion = ? WHERE idEsAval = ?";
      $result = $this->cnx->prepare($query); //preparacion de la sentencia
      $result->bindParam(1,$descripcion);
      $result->bindParam(2,$idEsAval);
   

      if($result->execute()){ //validacion de la ejecucion
          return true;
      }

      return false; //si fallo se devuelvo false

  }
  //FUNCION PARA ELIMINAR UN TIPO PAGO
  function EliminarAvala($idEsAval) {
      try {
          $query = "DELETE FROM tbl_mn_avala_a_persona WHERE idEsAval = ?";
          $result = $this->cnx->prepare($query);
          $result->bindParam(1, $idEsAval);
  
          if ($result->execute()) {
              return "elimino";
          }
  
      } catch (PDOException $e) {
         
          if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
          
              return "Llave en uso"; // mensaje de llave ya en uso error 1451
          } else {
              
              return "error";
          }
      }
  }
  /*********************FUNCIONES DE LA TABLA Tipo Persona *******************************************************/


  //funcion para listar los datos de tipo pago
  function ListarTipoPersona()
  {
      $query = "SELECT * FROM tbl_mn_tipo_persona"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
//FUNCION PARA REGISTRAR UN NUEVO TIPO PAGO
function RegistrarTipoPersona($Descripcion){
    $query = "INSERT INTO tbl_mn_tipo_persona (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del tipo pago a actualizar
 function ObtenerTipoPersonaPorId($idTipoPersona)
 {
     $query = "SELECT * FROM tbl_mn_tipo_persona WHERE idTipoPersona = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idTipoPersona);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }


    //FUNCION PARA ACTUALIZR TIPO PAGO 
    function ActualizarTipoPersona($idTipoPersona, $descripcion){
        $query = "UPDATE tbl_mn_tipo_persona SET Descripcion = ? WHERE idTipoPersona = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$descripcion);
        $result->bindParam(2,$idTipoPersona);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }
    //FUNCION PARA ELIMINAR UN TIPO PAGO
    function EliminarTipoPersona($idTipoPersona) {
        try {
            $query = "DELETE FROM tbl_mn_tipo_persona WHERE idTipoPersona = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idTipoPersona);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
  /*********************FUNCIONES DE LA TABLA Tipo Persona *******************************************************/


  //funcion para listar los datos de tipo cuenta
  function ListarTipoCuenta()
  {
      $query = "SELECT * FROM tbl_mn_tipo_cuenta"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }
    
//FUNCION PARA REGISTRAR UN NUEVO TIPO CUENTA
function RegistrarTipoCuenta($descripcion){
    $query = "INSERT INTO tbl_mn_tipo_cuenta (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos del tipo pago a actualizar
 function ObtenerTipoCuentaPorId($idTipoCuenta)
 {
     $query = "SELECT * FROM tbl_mn_tipo_cuenta WHERE idTipoCuenta = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idTipoCuenta);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }


    //FUNCION PARA ACTUALIZR TIPO PAGO 
    function ActualizarTipoCuenta($idTipoCuenta, $descripcion){
        $query = "UPDATE tbl_mn_tipo_cuenta SET Descripcion = ? WHERE idTipoCuenta = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$descripcion);
        $result->bindParam(2,$idTipoCuenta);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }
    //FUNCION PARA ELIMINAR UN TIPO PAGO
    function EliminarTipoCuenta($idTipoCuenta) {
        try {
            $query = "DELETE FROM tbl_mn_tipo_cuenta WHERE idTipoCuenta = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idTipoCuenta);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    /****************************** FUNCIONES TABLA Credito Aval **************************************************************** */

  //funcion para listar los datos de la tabla Credito Aval 
  function ListarCreditoAval()
  {
      $query = "SELECT * FROM tbl_mn_credito_aval"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }

  //FUNCION PARA REGISTRAR UN NUEVO Credito Aval 
  function RegistrarCreditoAval($Descripcion){
    $query = "INSERT INTO tbl_mn_credito_aval (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos de Credito Aval a actualizar
 function ObtenerCreditoAvalPorId($idCreditoAval)
 {
     $query = "SELECT * FROM tbl_mn_credito_aval WHERE idCreditoAval = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idCreditoAval);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS ESTADO CIVILES
    function ActualizarCreditoAval($idCreditoAval, $Descripcion){
        $query = "UPDATE tbl_mn_credito_aval SET Descripcion = ? WHERE idCreditoAval = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idCreditoAval);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN ESTADO CIVIL
    function EliminarCreditoAval($idCreditoAval) {
        try {
            $query = "DELETE FROM tbl_mn_credito_aval WHERE idCreditoAval = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idCreditoAval);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    
  /****************************** FUNCIONES TABLA OBJETOS **************************************************************** */

  //funcion para listar los datos de la tabla objetos 
  function ListarObjeto()
  {
      $query = "SELECT * FROM tbl_ms_objetos"; //sentencia sql
      $result = $this->cnx->prepare($query);
      if($result->execute())
      {
          if($result->rowCount() > 0){ //validacion para verificar si trae datos
              while($fila = $result->fetch(PDO::FETCH_ASSOC)){  //guardar los datos en un arreglo
                  $datos[] = $fila;
              }
              return $datos;
          }
      }
      return false;
  }

  //FUNCION PARA REGISTRAR UN NUEVO OBJETO
  function RegistrarObjetos($Descripcion){
    $query = "INSERT INTO tbl_ms_objetos (Descripcion) VALUES(?)";
    $result = $this->cnx->prepare($query); //preparacion de la sentencia
    $result->bindParam(1,$Descripcion);

    if($result->execute()){ //validacion de la ejecucion
        return true;
    }

    return false; //si fallo se devuelvo false

}

 //funcion que trae los datos de Credito Aval a actualizar
 function ObtenerObjetosPorId($idObjetos)
 {
     $query = "SELECT * FROM tbl_ms_objetos WHERE idObjetos = ?"; 
     $result = $this->cnx->prepare($query);
     $result->bindParam(1,$idObjetos);
     if($result->execute())
     {
        return $result->fetch(PDO::FETCH_ASSOC);
     }
     return false;
 }

    //FUNCION PARA ACTUALIZR LOS OBJETOS
    function ActualizarObjetos($idObjetos, $Descripcion){
        $query = "UPDATE tbl_ms_objetos SET Descripcion = ? WHERE idObjetos = ?";
        $result = $this->cnx->prepare($query); //preparacion de la sentencia
        $result->bindParam(1,$Descripcion);
        $result->bindParam(2,$idObjetos);
     

        if($result->execute()){ //validacion de la ejecucion
            return true;
        }

        return false; //si fallo se devuelvo false

    }

    
//FUNCION PARA ELIMINAR UN ESTADO CIVIL
    function EliminarObjetos($idObjetos) {
        try {
            $query = "DELETE FROM tbl_ms_objetos WHERE idObjetos = ?";
            $result = $this->cnx->prepare($query);
            $result->bindParam(1, $idObjetos);
    
            if ($result->execute()) {
                return "elimino";
            }
    
        } catch (PDOException $e) {
           
            if ($e->errorInfo[1] === 1451) { // El código 1451 suele ser asociado con violaciones de claves externas
            
                return "Llave en uso"; // mensaje de llave ya en uso error 1451
            } else {
                
                return "error";
            }
        }
    }
    
  
 }