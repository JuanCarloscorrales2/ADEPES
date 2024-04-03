<?php
require "../model/TablasDescriptivas.php";
session_start(); //fuarda la sesion del usuario
//instancia de la clase rol
$tablas = new Tablas();

switch ($_REQUEST["operador"]) {

    case "listar_tipos_prestamos":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarTiposPrestamos() : []; //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? ' <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_tipo_prestamo" 
                onclick="ObtenerTipoPrestamoPorId(' . $datos[$i]['idTipoPrestamo'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_activar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerTipoPrestamoPorId(' . $datos[$i]['idTipoPrestamo'] . ",'activar'" . ');">
                <i class="icon-check"></i> Activar </a>' : '';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '    
                <a class="dropdown-item"onclick="ObtenerTipoPrestamoPorId(' . $datos[$i]['idTipoPrestamo'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => ($datos[$i]['idEstadoTipoPrestamo'] == 1) ?
                        '<div class="btn-group"> 
                        <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                        </button>
                        <div class="dropdown-menu">
                        ' . $boton_editar . $boton_eliminar . '
                        
                            
                        </div>
                    </div>' :
                        '<div class="btn-group"> 
                        <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                        </button>
                        <div class="dropdown-menu">
                         '.$boton_editar.'
                    
                         '.$boton_activar.'
                        </div>
                    </div>',
                    "NO" => $datos[$i]['idTipoPrestamo'], //nombre de la tablas en la base de datos
                    "ESTADO" => $datos[$i]['Estado'], //nombre de la tablas en la base de datos
                    "DESCRIPCION" => $datos[$i]['Prestamo'],
                    "TASA" => $datos[$i]['tasa'],
                    "PLAZO" => $datos[$i]['PlazoMaximo'],
                    "MINIMO" => $datos[$i]['montoMinimo'],
                    "MAXIMO" => $datos[$i]['montoMaximo'],



                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;

    case "registrar_tipo_prestamo":
        if (
            isset($_POST["nombre"], $_POST["tasa"], $_POST["plazoMaximo"], $_POST["montoMinimo"], $_POST["montoMaximo"])
            && !empty($_POST["nombre"]) && !empty($_POST["tasa"]) && !empty($_POST["plazoMaximo"]) && !empty($_POST["montoMinimo"]) && !empty($_POST["montoMaximo"])
        ) {

            $nombre = $_POST["nombre"];
            $tasa = $_POST["tasa"];
            $PlazoMaximo = $_POST["plazoMaximo"];
            $montoMaximo = $_POST["montoMaximo"];
            $montoMinimo = $_POST["montoMinimo"];

    
            if ($montoMinimo >= $montoMaximo) {
                $response = "minimo";
            } else if ($tablas->RegistrarTipoPrestamo($nombre, $tasa, $PlazoMaximo, $montoMaximo, $montoMinimo)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


    break;

    case "obtener_tipo_prestamo_por_id":
        if (isset($_POST["idTipoPrestamo"]) && !empty($_POST["idTipoPrestamo"])) {
            $data = $tablas->ObtenerTipoPrestamoPorId($_POST["idTipoPrestamo"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idTipoPrestamo'],
                    "ESTADO" => $data['idEstadoTipoPrestamo'],
                    "NOMBRE" => $data['Descripcion'],
                    "TASA" => $data['tasa'],
                    "PLAZO" => $data['PlazoMaximo'],
                    "MONTO_MAXIMO" => $data['montoMaximo'],
                    "MONTO_MINIMO" => $data['montoMinimo'],

                );
                echo json_encode($list);
            }
        }

        break;

    case "listar_estadoPrestamo_select":

        if (isset($_POST["idTipoPrestamo"]) && !empty($_POST["idTipoPrestamo"])) {
            $datos = $tablas->ListarEstadoPrestamoSelectEdit($_POST["idTipoPrestamo"]);
            if ($datos) {  //valida que traiga datos
                for ($i = 0; $i < count($datos); $i++) {
                    $list[] = array(  //se pone los campos que queremos guardar
                        "0" => $datos[$i]['idestadoTipoPrestamo'],
                        "1" => $datos[$i]['descripcion'],
                    );
                }
                echo json_encode($list); //se devuelve los datos en formato json 
            }
        }


        break;

    case "actualizar_tipo_prestamo":
        if (
            isset($_POST["idTipoPrestamo"], $_POST["idEstadoTipoPrestamo"], $_POST["Descripcion"], $_POST["tasa"], $_POST["PlazoMaximo"], $_POST["montoMaximo"], $_POST["montoMinimo"])
            && !empty($_POST["idTipoPrestamo"]) && !empty($_POST["idEstadoTipoPrestamo"]) && !empty($_POST["Descripcion"]) && !empty($_POST["tasa"]) && !empty($_POST["PlazoMaximo"])
            && !empty($_POST["montoMaximo"]) && !empty($_POST["montoMinimo"])
        ) {

            $idTipoPrestamo = $_POST["idTipoPrestamo"];
            $idEstadoTipoPrestamo = $_POST["idEstadoTipoPrestamo"];
            $Descripcion = $_POST["Descripcion"];
            $tasa = $_POST["tasa"];
            $PlazoMaximo = $_POST["PlazoMaximo"];
            $montoMaximo = $_POST["montoMaximo"];
            $montoMinimo = $_POST["montoMinimo"];
        
            if ($montoMinimo >= $montoMaximo) {
                $response = "minimo";
            } else if ($tablas->ActualizarTipoPrestamo($idTipoPrestamo, $idEstadoTipoPrestamo, $Descripcion, $tasa, $PlazoMaximo, $montoMaximo, $montoMinimo)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "inactivar_tipoPrestamo":
        if (isset($_POST["idTipoPrestamo"]) && !empty($_POST["idTipoPrestamo"])) {


            if ($tablas->InactivarTipoPrestamo($_POST["idTipoPrestamo"])) {
                $response = "success";
            } else {
                $response = "error";
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;

    case "activar_tipoPrestamo":
        if (isset($_POST["idTipoPrestamo"]) && !empty($_POST["idTipoPrestamo"])) {


            if ($tablas->ActivarTipoPrestamo($_POST["idTipoPrestamo"])) {
                $response = "success";
            } else {
                $response = "error";
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;

        /*************  VALIDACIONES DE ESTADOS CIVILES  ************************************************************************************/
    case "listar_estadocivil":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarEstadoCivil() : [];  //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '   <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_estadocivil" 
                onclick="ObtenerEstadoCivilPorId(' . $datos[$i]['idEstadoCivil'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerEstadoCivilPorId(' . $datos[$i]['idEstadoCivil'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                        <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                        </button>
                        <div class="dropdown-menu">
                         
                        ' . $boton_editar . $boton_eliminar . '
                      
                        
                            
                        </div>
                    </div>',
                    "NO" => $datos[$i]['idEstadoCivil'], //nombre de la tablas en la base de datos
                    "DESCRIPCION" => $datos[$i]['Descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;

    case "obtener_estado_civil_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idEstadoCivil"]) && !empty($_POST["idEstadoCivil"])) {
            $data = $tablas->ObtenerEstadoCivilPorId($_POST["idEstadoCivil"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idEstadoCivil'],  //nombres de la base de datos
                    "DESCRIPCION" => $data['Descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_estado_civil":
        if (isset($_POST["descripcion"]) && !empty($_POST["descripcion"])) {

            $descripcion = $_POST["descripcion"];

            if ($tablas->RegistrarEstadoCivil($descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_estado_civil":
        if (isset($_POST["idEstadoCivil"], $_POST["Descripcion"])  && !empty($_POST["idEstadoCivil"]) && !empty($_POST["Descripcion"])) {

            $idEstadoCivil = $_POST["idEstadoCivil"];
            $Descripcion = $_POST["Descripcion"];


            if ($tablas->ActualizarEstadoCivil($idEstadoCivil, $Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;


    case "eliminar_estado_civil":
        if (isset($_POST["idEstadoCivil"]) && !empty($_POST["idEstadoCivil"])) {

            $eliminar = $tablas->EliminarEstadoCivil($_POST["idEstadoCivil"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;




        /**************  VALIDACIONES TABLA PARENTESCO *****************************************************************************/
    case "listar_parentesco":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarParentesco() : []; //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Parentesco" 
                onclick="ObtenerParentescoPorId(' . $datos[$i]['idParentesco'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '
                <a class="dropdown-item" onclick="ObtenerParentescoPorId(' . $datos[$i]['idParentesco'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
                    
                ' . $boton_editar . $boton_eliminar . '
            
                    
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idParentesco'], //nombre de la tablas en la base de datos
                    "PARENTESCO" => $datos[$i]['descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;

    case "obtener_parentesco_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idParentesco"]) && !empty($_POST["idParentesco"])) {
            $data = $tablas->ObtenerParentescoPorId($_POST["idParentesco"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idParentesco'],  //nombres de la base de datos
                    "DESCRIPCION" => $data['descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Parentesco":
        if (isset($_POST["descripcion"]) && !empty($_POST["descripcion"])) {

            $Descripcion = $_POST["descripcion"];

            if ($tablas->RegistrarParentesco($Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_parentesco":
        if (isset($_POST["idParentesco"], $_POST["descripcion"])  && !empty($_POST["idParentesco"]) && !empty($_POST["descripcion"])) {

            $idParentesco = $_POST["idParentesco"];
            $descripcion = $_POST["descripcion"];


            if ($tablas->ActualizarParentesco($idParentesco, $descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;


    case "eliminar_Parentesco":
        if (isset($_POST["idParentesco"]) && !empty($_POST["idParentesco"])) {

            $eliminar = $tablas->EliminarParentesco($_POST["idParentesco"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;

        /**************  VALIDACIONES TABLA CATEGORIA CASA *****************************************************************************/
    case "listar_Categoria":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarCategoriaCasa() : []; //obtiene los datos del metodo
        if ($datos) {

            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Categoria" 
            onclick="ObtenerCategoriaPorId(' . $datos[$i]['idcategoriaCasa'] . ",'editar'" . ');">
            <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerCategoriaPorId(' . $datos[$i]['idcategoriaCasa'] . ",'eliminar'" . ');">
            <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
                ' . $boton_editar . $boton_eliminar . '
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idcategoriaCasa'], //nombre de la tablas en la base de datos
                    "CATEGORIA" => $datos[$i]['descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;
    case "obtener_categoria_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idcategoriaCasa"]) && !empty($_POST["idcategoriaCasa"])) {
            $data = $tablas->ObtenerCategoriaPorId($_POST["idcategoriaCasa"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idcategoriaCasa'],  //nombres de la base de datos
                    "CATEGORIA" => $data['descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Categoria":
        if (isset($_POST["descripcion"]) && !empty($_POST["descripcion"])) {

            $descripcion = $_POST["descripcion"];

            if ($tablas->RegistrarCategoria($descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_categoria":
        if (isset($_POST["idcategoriaCasa"], $_POST["descripcion"])  && !empty($_POST["idcategoriaCasa"]) && !empty($_POST["descripcion"])) {

            $idcategoriaCasa = $_POST["idcategoriaCasa"];
            $descripcion = $_POST["descripcion"];


            if ($tablas->ActualizarCategoria($idcategoriaCasa, $descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "eliminar_Categoria":
        if (isset($_POST["idcategoriaCasa"]) && !empty($_POST["idcategoriaCasa"])) {

            $eliminar = $tablas->EliminarCategoria($_POST["idcategoriaCasa"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;

        /**************  VALIDACIONES TABLA GENERO *****************************************************************************/
    case "listar_Genero":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ?  $tablas->ListarGenero() : []; //obtiene los datos del metodo
        if ($datos) {

            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Genero" 
                onclick="ObtenerGeneroPorId(' . $datos[$i]['idGenero'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '
                <a class="dropdown-item" onclick="ObtenerGeneroPorId(' . $datos[$i]['idGenero'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
                ' . $boton_editar . $boton_eliminar . '
                    
                    
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idGenero'], //nombre de la tablas en la base de datos
                    "GENERO" => $datos[$i]['Descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;
    case "obtener_genero_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idGenero"]) && !empty($_POST["idGenero"])) {
            $data = $tablas->ObtenerGenerocoPorId($_POST["idGenero"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idGenero'],  //nombres de la base de datos
                    "GENERO" => $data['Descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Genero":
        if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

            $descripcion = $_POST["Descripcion"];

            if ($tablas->RegistrarGenero($descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_genero":
        if (isset($_POST["idGenero"], $_POST["Descripcion"])  && !empty($_POST["idGenero"]) && !empty($_POST["Descripcion"])) {

            $idGenero = $_POST["idGenero"];
            $Descripcion = $_POST["Descripcion"];


            if ($tablas->ActualizarGenero($idGenero, $Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "eliminar_Genero":
        if (isset($_POST["idGenero"]) && !empty($_POST["idGenero"])) {

            $eliminar = $tablas->EliminarGenero($_POST["idGenero"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;
        /**************  VALIDACIONES TABLA Contacto *****************************************************************************/
    case "listar_Contacto":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarContacto() : []; //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '      <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Contacto" 
                onclick="ObtenerContactoPorId(' . $datos[$i]['idTipoContacto'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>
                ' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '        <a class="dropdown-item" onclick="ObtenerContactoPorId(' . $datos[$i]['idTipoContacto'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
              
                ' . $boton_editar . $boton_eliminar . '
                    
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idTipoContacto'], //nombre de la tablas en la base de datos
                    "CONTACTO" => $datos[$i]['Descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;
    case "obtener_contacto_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idTipoContacto"]) && !empty($_POST["idTipoContacto"])) {
            $data = $tablas->ObtenerContactoPorId($_POST["idTipoContacto"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idTipoContacto'],  //nombres de la base de datos
                    "CONTACTO" => $data['Descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Contacto":
        if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

            $descripcion = $_POST["Descripcion"];

            if ($tablas->RegistrarContacto($descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_contacto":
        if (isset($_POST["idTipoContacto"], $_POST["Descripcion"])  && !empty($_POST["idTipoContacto"]) && !empty($_POST["Descripcion"])) {

            $idTipoContacto = $_POST["idTipoContacto"];
            $Descripcion = $_POST["Descripcion"];


            if ($tablas->ActualizarContacto($idTipoContacto, $Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "eliminar_Contacto":
        if (isset($_POST["idTipoContacto"]) && !empty($_POST["idTipoContacto"])) {

            $eliminar = $tablas->EliminarContacto($_POST["idTipoContacto"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;
        /**************  VALIDACIONES TABLA BIENES *****************************************************************************/
    case "listar_Bienes":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarBienes() : []; //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '     <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Bienes" 
                onclick="ObtenerBienesPorId(' . $datos[$i]['idPersonaBienes'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerBienesPorId(' . $datos[$i]['idPersonaBienes'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
                ' . $boton_editar . $boton_eliminar . '
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idPersonaBienes'], //nombre de la tablas en la base de datos
                    "BIENES" => $datos[$i]['Descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;
    case "obtener_bienes_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idPersonaBienes"]) && !empty($_POST["idPersonaBienes"])) {
            $data = $tablas->ObtenerBienesPorId($_POST["idPersonaBienes"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idPersonaBienes'],  //nombres de la base de datos
                    "BIENES" => $data['Descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Bienes":
        if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

            $descripcion = $_POST["Descripcion"];

            if ($tablas->RegistrarBienes($descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_bienes":
        if (isset($_POST["idPersonaBienes"], $_POST["Descripcion"])  && !empty($_POST["idPersonaBienes"]) && !empty($_POST["Descripcion"])) {

            $idPersonaBienes = $_POST["idPersonaBienes"];
            $Descripcion = $_POST["Descripcion"];


            if ($tablas->ActualizarBienes($idPersonaBienes, $Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "eliminar_Bienes":
        if (isset($_POST["idPersonaBienes"]) && !empty($_POST["idPersonaBienes"])) {

            $eliminar = $tablas->EliminarBienes($_POST["idPersonaBienes"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;
        /**************  VALIDACIONES TABLA NACIONALIDAD *****************************************************************************/
    case "listar_Nacionalidad":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarNacionalidad() : []; //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? ' <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Nacionalidad" 
                onclick="ObtenerNacionalidadPorId(' . $datos[$i]['idNacionalidad'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>
                ' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '    <a class="dropdown-item" onclick="ObtenerNacionalidadPorId(' . $datos[$i]['idNacionalidad'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>
                ' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">}
                           
                ' . $boton_editar . $boton_eliminar . '
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idNacionalidad'], //nombre de la tablas en la base de datos
                    "NACIONALIDAD" => $datos[$i]['Descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;
    case "obtener_nacionalidad_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idNacionalidad"]) && !empty($_POST["idNacionalidad"])) {
            $data = $tablas->ObtenerNacionalidadPorId($_POST["idNacionalidad"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idNacionalidad'],  //nombres de la base de datos
                    "NACIONALIDAD" => $data['Descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Nacionalidad":
        if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

            $descripcion = $_POST["Descripcion"];

            if ($tablas->RegistrarNacionalidad($descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_nacionalidad":
        if (isset($_POST["idNacionalidad"], $_POST["Descripcion"])  && !empty($_POST["idNacionalidad"]) && !empty($_POST["Descripcion"])) {

            $idNacionalidad = $_POST["idNacionalidad"];
            $Descripcion = $_POST["Descripcion"];


            if ($tablas->ActualizarNacionalidad($idNacionalidad, $Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "eliminar_Nacionalidad":
        if (isset($_POST["idNacionalidad"]) && !empty($_POST["idNacionalidad"])) {

            $eliminar = $tablas->EliminarNacionalidad($_POST["idNacionalidad"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;
        /**************  VALIDACIONES TABLA Tiempo Laboral *****************************************************************************/
    case "listar_Laboral":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarLaboral() : [];
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '   <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Laboral" 
                onclick="ObtenerLaboralPorId(' . $datos[$i]['idTiempoLaboral'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerLaboralPorId(' . $datos[$i]['idTiempoLaboral'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>
                ' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
                ' . $boton_editar . $boton_eliminar . '
          
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idTiempoLaboral'], //nombre de la tablas en la base de datos
                    "LABORAL" => $datos[$i]['descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;

    case "obtener_laboral_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idTiempoLaboral"]) && !empty($_POST["idTiempoLaboral"])) {
            $data = $tablas->ObtenerLaboralPorId($_POST["idTiempoLaboral"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idTiempoLaboral'],  //nombres de la base de datos
                    "DESCRIPCION" => $data['descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Laboral":
        if (isset($_POST["descripcion"]) && !empty($_POST["descripcion"])) {

            $Descripcion = $_POST["descripcion"];

            if ($tablas->RegistrarLaboral($Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_laboral":
        if (isset($_POST["idTiempoLaboral"], $_POST["descripcion"])  && !empty($_POST["idTiempoLaboral"]) && !empty($_POST["descripcion"])) {

            $idTiempoLaboral = $_POST["idTiempoLaboral"];
            $descripcion = $_POST["descripcion"];


            if ($tablas->ActualizarLaboral($idTiempoLaboral, $descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;


    case "eliminar_Laboral":
        if (isset($_POST["idTiempoLaboral"]) && !empty($_POST["idTiempoLaboral"])) {

            $eliminar = $tablas->EliminarLaboral($_POST["idTiempoLaboral"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;
        /**************  VALIDACIONES TABLA ESTADO PLAN PAGO *****************************************************************************/
    case "listar_Estadoplanpago":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarEstadoplanpago() : []; //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '      <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Estadoplanpago" 
                onclick="ObtenerEstadoplanpagoPorId(' . $datos[$i]['idEstadoPlanPagos'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '    <a class="dropdown-item" onclick="ObtenerEstadoplanpagoPorId(' . $datos[$i]['idEstadoPlanPagos'] . ",'eliminar'" . ');">
                    <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
              
                ' . $boton_editar . $boton_eliminar . '
                
                    </div>
                </div>',
                    "NO" => $datos[$i]['idEstadoPlanPagos'], //nombre de la tablas en la base de datos
                    "ESTADOPLANPAGO" => $datos[$i]['Descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;
    case "obtener_estadoplanpago_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idEstadoPlanPagos"]) && !empty($_POST["idEstadoPlanPagos"])) {
            $data = $tablas->ObtenerEstadoplanpagoPorId($_POST["idEstadoPlanPagos"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idEstadoPlanPagos'],  //nombres de la base de datos
                    "ESTADOPLANPAGO" => $data['Descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Estadoplanpago":
        if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

            $descripcion = $_POST["Descripcion"];

            if ($tablas->RegistrarEstadoplanpago($descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_estadoplanpago":
        if (isset($_POST["idEstadoPlanPagos"], $_POST["Descripcion"])  && !empty($_POST["idEstadoPlanPagos"]) && !empty($_POST["Descripcion"])) {

            $idEstadoPlanPagos = $_POST["idEstadoPlanPagos"];
            $Descripcion = $_POST["Descripcion"];


            if ($tablas->ActualizarEstadoplanpago($idEstadoPlanPagos, $Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "eliminar_Estadoplanpago":
        if (isset($_POST["idEstadoPlanPagos"]) && !empty($_POST["idEstadoPlanPagos"])) {

            $eliminar = $tablas->EliminarEstadoplanpago($_POST["idEstadoPlanPagos"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;
        /**************  VALIDACIONES TABLA Tiempo Vivir*****************************************************************************/
    case "listar_Tiempovivir":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarTiempovivir() : [];
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '    <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Tiempovivir" 
                onclick="ObtenerTiempovivirPorId(' . $datos[$i]['idtiempoVivir'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '       <a class="dropdown-item" onclick="ObtenerTiempovivirPorId(' . $datos[$i]['idtiempoVivir'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
                
                ' . $boton_editar . $boton_eliminar . '
             
                    
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idtiempoVivir'], //nombre de la tablas en la base de datos
                    "TIEMPOVIVIR" => $datos[$i]['descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;

    case "obtener_tiempovivir_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idtiempoVivir"]) && !empty($_POST["idtiempoVivir"])) {
            $data = $tablas->ObtenerTiempovivirPorId($_POST["idtiempoVivir"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idtiempoVivir'],  //nombres de la base de datos
                    "DESCRIPCION" => $data['descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Tiempovivir":
        if (isset($_POST["descripcion"]) && !empty($_POST["descripcion"])) {

            $Descripcion = $_POST["descripcion"];

            if ($tablas->RegistrarTiempovivir($Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_tiempovivir":
        if (isset($_POST["idtiempoVivir"], $_POST["descripcion"])  && !empty($_POST["idtiempoVivir"]) && !empty($_POST["descripcion"])) {

            $idtiempoVivir = $_POST["idtiempoVivir"];
            $descripcion = $_POST["descripcion"];


            if ($tablas->ActualizarTiempovivir($idtiempoVivir, $descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;


    case "eliminar_Tiempovivir":
        if (isset($_POST["idtiempoVivir"]) && !empty($_POST["idtiempoVivir"])) {

            $eliminar = $tablas->EliminarTiempovivir($_POST["idtiempoVivir"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;

        /**************  VALIDACIONES TABLA ESTADO TIPO PRESTAMO*****************************************************************************/
    case "listar_Estadotipoprestamo":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ?  $tablas->ListarEstadotipoprestamo() : [];
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '    <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Estadotipoprestamo" 
                onclick="ObtenerEstadotipoprestamoPorId(' . $datos[$i]['idestadoTipoPrestamo'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? ' <a class="dropdown-item" onclick="ObtenerEstadotipoprestamoPorId(' . $datos[$i]['idestadoTipoPrestamo'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
                ' . $boton_editar . $boton_eliminar . '
                
                    
                   
                    
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idestadoTipoPrestamo'], //nombre de la tablas en la base de datos
                    "ESTADOTIPOPRESTAMO" => $datos[$i]['descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;

    case "obtener_estamotipoprestamo_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idestadoTipoPrestamo"]) && !empty($_POST["idestadoTipoPrestamo"])) {
            $data = $tablas->ObtenerEstadotipoprestamoPorId($_POST["idestadoTipoPrestamo"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idestadoTipoPrestamo'],  //nombres de la base de datos
                    "DESCRIPCION" => $data['descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Estadotipoprestamo":
        if (isset($_POST["descripcion"]) && !empty($_POST["descripcion"])) {

            $Descripcion = $_POST["descripcion"];

            if ($tablas->RegistrarEstadotipoprestamo($Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_estadotipoprestamo":
        if (isset($_POST["idestadoTipoPrestamo"], $_POST["descripcion"])  && !empty($_POST["idestadoTipoPrestamo"]) && !empty($_POST["descripcion"])) {

            $idestadoTipoPrestamo = $_POST["idestadoTipoPrestamo"];
            $descripcion = $_POST["descripcion"];


            if ($tablas->ActualizarEstadotipoprestamo($idestadoTipoPrestamo, $descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;


    case "eliminar_Estadotipoprestamo":
        if (isset($_POST["idestadoTipoPrestamo"]) && !empty($_POST["idestadoTipoPrestamo"])) {

            $eliminar = $tablas->EliminarEstadotipoprestamo($_POST["idestadoTipoPrestamo"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;
        /**************  VALIDACIONES TABLA ESTADO SOLICITUDES*****************************************************************************/
    case "listar_Estadosolicitud":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ?  $datos = $tablas->ListarEstadosolicitud() : []; //obtiene los datos del metodo

        ; //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '    <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Estadosolicitud" 
                onclick="ObtenerEstadosolicitudPorId(' . $datos[$i]['idEstadoSolicitud'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '     <a class="dropdown-item" onclick="ObtenerEstadosolicitudPorId(' . $datos[$i]['idEstadoSolicitud'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
                
                    
                          
                ' . $boton_editar . $boton_eliminar . '
                    
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idEstadoSolicitud'], //nombre de la tablas en la base de datos
                    "ESTADOSOLICITUD" => $datos[$i]['Descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;
    case "obtener_estadosolicitud_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idEstadoSolicitud"]) && !empty($_POST["idEstadoSolicitud"])) {
            $data = $tablas->ObtenerEstadosolicitudPorId($_POST["idEstadoSolicitud"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idEstadoSolicitud'],  //nombres de la base de datos
                    "ESTADOSOLICITUD" => $data['Descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Estadosolicitud":
        if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

            $descripcion = $_POST["Descripcion"];

            if ($tablas->RegistrarEstadosolicitud($descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_estadosolicitud":
        if (isset($_POST["idEstadoSolicitud"], $_POST["Descripcion"])  && !empty($_POST["idEstadoSolicitud"]) && !empty($_POST["Descripcion"])) {

            $idEstadoSolicitud = $_POST["idEstadoSolicitud"];
            $Descripcion = $_POST["Descripcion"];


            if ($tablas->ActualizarEstadosolicitud($idEstadoSolicitud, $Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "eliminar_Estadosolicitud":
        if (isset($_POST["idEstadoSolicitud"]) && !empty($_POST["idEstadoSolicitud"])) {

            $eliminar = $tablas->EliminarEstadosolicitud($_POST["idEstadoSolicitud"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;
        /**************  VALIDACIONES TABLA RUBRO *****************************************************************************/
    case "listar_Rubro":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        $datos = $_SESSION["consultar"] >= 1 ?     $datos = $tablas->ListarRubro() : []; //obtiene los datos del metodo
        ; //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $boton_editar = $_SESSION["actualizar"] >= 1 ? '       <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Rubro" 
                onclick="ObtenerRubroPorId(' . $datos[$i]['idRubro'] . ",'editar'" . ');">
                <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
                $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '   <a class="dropdown-item" onclick="ObtenerRubroPorId(' . $datos[$i]['idRubro'] . ",'eliminar'" . ');">
                <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
                $list[] = array(
                    "Acciones" => '<div class="btn-group"> 
                <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                </button>
                <div class="dropdown-menu">
             
                ' . $boton_editar . $boton_eliminar . '
                 
                    
                        
                    </div>
                </div>',
                    "NO" => $datos[$i]['idRubro'], //nombre de la tablas en la base de datos
                    "RUBRO" => $datos[$i]['Descripcion'],


                );
            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => count($list),
                "iTotalDisplayRecords" => count($list),
                "aaData" => $list
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;
    case "obtener_rubro_por_id": //sirve para obtener el id para poder actualizar o eliminar
        if (isset($_POST["idRubro"]) && !empty($_POST["idRubro"])) {
            $data = $tablas->ObtenerRubroPorId($_POST["idRubro"]);
            if ($data) {
                $list[] = array(
                    "ID" => $data['idRubro'],  //nombres de la base de datos
                    "RUBRO" => $data['Descripcion'], //nombres de la base de datos


                );
                echo json_encode($list);
            }
        }

        break;

    case "registrar_Rubro":
        if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

            $descripcion = $_POST["Descripcion"];

            if ($tablas->RegistrarRubro($descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;


        break;

    case "actualizar_rubro":
        if (isset($_POST["idRubro"], $_POST["Descripcion"])  && !empty($_POST["idRubro"]) && !empty($_POST["Descripcion"])) {

            $idRubro = $_POST["idRubro"];
            $Descripcion = $_POST["Descripcion"];


            if ($tablas->ActualizarRubro($idRubro, $Descripcion)) {
                $response = "success";  //si se inserto en la BD manda mensaje de exito

            } else {
                $response = "error";  //error al insertar en BD
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;

    case "eliminar_Rubro":
        if (isset($_POST["idRubro"]) && !empty($_POST["idRubro"])) {

            $eliminar = $tablas->EliminarRubro($_POST["idRubro"]);
            if ($eliminar == "elimino") {
                $response = "success";  //si elimino correctamente

            } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
                $response = "llave_uso";
            } else {
                $response = "error";  //cualquier otro tipo de error
            }
        } else {
            $response = "error";
        }
        echo $response;

        break;
/**************  VALIDACIONES TABLA PROFESION *****************************************************************************/
case "listar_Profesion":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarProfesion() : []; //obtiene los datos del metodo
    if($datos){
        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '    <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Profesion" 
            onclick="ObtenerProfesionPorId(' . $datos[$i]['idProfesion'] . ",'editar'" . ');">
            <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? ' <a class="dropdown-item" onclick="ObtenerProfesionPorId(' . $datos[$i]['idProfesion'] . ",'eliminar'" . ');">
            <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
            </button>
            <div class="dropdown-menu">
            ' . $boton_editar . $boton_eliminar . '
                    
                        
                    </div>
                </div>',
                "NO"=>$datos[$i]['idProfesion'], //nombre de la tablas en la base de datos
                "PROFESION"=>$datos[$i]['Descripcion'],
               
                
            );

        }

        $resultados = array(
            "sEcho" =>1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" =>$list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

break;
case "obtener_profesion_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if( isset($_POST["idProfesion"]) && !empty($_POST["idProfesion"]) ){
        $data = $tablas->ObtenerProfesionPorId($_POST["idProfesion"]);
        if($data){
            $list[] = array(
                "ID"=>$data['idProfesion'],  //nombres de la base de datos
                "PROFESION"=>$data['Descripcion'],//nombres de la base de datos
               

            );
            echo json_encode($list);
        }
    }

break;

case "registrar_Profesion":
    if( isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])){

        $descripcion = $_POST["Descripcion"];

        if( $tablas->RegistrarProfesion($descripcion) ){
           $response = "success";  //si se inserto en la BD manda mensaje de exito
        }else{
            $response = "error"; 
        }
    }else{
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


break;
    
case "actualizar_profesion":
    if( isset($_POST["idProfesion"],$_POST["Descripcion"])  && !empty($_POST["idProfesion"]) && !empty($_POST["Descripcion"]) ){
           
            $idProfesion = $_POST["idProfesion"];
            $Descripcion = $_POST["Descripcion"];
           
          
            if( $tablas->ActualizarProfesion($idProfesion, $Descripcion) ){
                $response = "success";  //si se inserto en la BD manda mensaje de exito
           
            }else{
                $response = "error";  //error al insertar en BD
            }    
       
    }else{
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

break;  
   
case "eliminar_Profesion":
    if( isset($_POST["idProfesion"]) && !empty($_POST["idProfesion"]) ){
 
        $eliminar = $tablas->EliminarProfesion($_POST["idProfesion"]);
       if( $eliminar == "elimino"){
            $response ="success";  //si elimino correctamente

       }else if($eliminar == "Llave en uso"){  //si la llave ya esta en uso en otras tablas
          $response = "llave_uso";
       }else{
          $response = "error";  //cualquier otro tipo de error
       }

    }else{
       $response = "error";
    }
    echo $response;
 
 break;
  /**************  VALIDACIONES TABLA ESTADO USUARIO*****************************************************************************/
case "listar_ Estadousuario":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->listar_Estadousuario() : []; //obtiene los datos del metodo
    if($datos){
        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '    <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Estadousuario" 
            onclick="ObtenerEstadousuarioPorId(' . $datos[$i]['idEstadoUsuario'] . ",'editar'" . ');">
            <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? ' <a class="dropdown-item" onclick="ObtenerEstadousuarioPorId(' . $datos[$i]['idEstadoUsuario'] . ",'eliminar'" . ');">
            <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
            </button>
            <div class="dropdown-menu">
            ' . $boton_editar . $boton_eliminar . '
            
                    
                        
                    </div>
                </div>',
                "NO"=>$datos[$i]['idEstadoUsuario'], //nombre de la tablas en la base de datos
                "ESTADOUSUARIO"=>$datos[$i]['Descripcion'],
               
                
            );

        }

        $resultados = array(
            "sEcho" =>1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" =>$list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable
    
    

break;
case "obtener_estadousuario_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if( isset($_POST["idEstadoUsuario"]) && !empty($_POST["idEstadoUsuario"]) ){
        $data = $tablas->ObtenerEstadousuarioPorId($_POST["idEstadoUsuario"]);
        if($data){
            $list[] = array(
                "ID"=>$data['idEstadoUsuario'],  //nombres de la base de datos
                "ESTADOUSUARIO"=>$data['Descripcion'],//nombres de la base de datos
               

            );
            echo json_encode($list);
        }
    }

break;

case "registrar_Estadousuario":
    if( isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])){

        $descripcion = $_POST["Descripcion"];

        if( $tablas->RegistrarEstadousuario($descripcion) ){
           $response = "success";  //si se inserto en la BD manda mensaje de exito
        }else{
            $response = "error"; 
        }
    }else{
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


break;
    
case "actualizar_estadousuario":
    if( isset($_POST["idEstadoUsuario"],$_POST["Descripcion"])  && !empty($_POST["idMunicipio"]) && !empty($_POST["Descripcion"]) ){
           
            $idEstadoUsuario = $_POST["idEstadoUsuario"];
            $Descripcion = $_POST["Descripcion"];
           
          
            if( $tablas->ActualizarEstadousuario($idEstadoUsuario, $Descripcion) ){
                $response = "success";  //si se inserto en la BD manda mensaje de exito
           
            }else{
                $response = "error";  //error al insertar en BD
            }    
       
    }else{
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

break;  
   
case "eliminar_Estadousuario":
    if( isset($_POST["idEstadoUsuario"]) && !empty($_POST["idEstadoUsuario"]) ){
 
        $eliminar = $tablas->EliminarEstadousuario($_POST["idEstadoUsuario"]);
       if( $eliminar == "elimino"){
            $response ="success";  //si elimino correctamente

       }else if($eliminar == "Llave en uso"){  //si la llave ya esta en uso en otras tablas
          $response = "llave_uso";
       }else{
          $response = "error";  //cualquier otro tipo de error
       }

    }else{
       $response = "error";
    }
    echo $response;
 
 break;
 
  
 /**************  VALIDACIONES TABLA MUNICIPIO*****************************************************************************/
case "listar_Municipio":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarMunicipio() : [];//obtiene los datos del metodo
    if($datos){
        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '    <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Municipio" 
            onclick="ObtenerMunicipioPorId(' . $datos[$i]['idMunicipio'] . ",'editar'" . ');">
            <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? ' <a class="dropdown-item" onclick="ObtenerMunicipioPorId(' . $datos[$i]['idMunicipio'] . ",'eliminar'" . ');">
            <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';
            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
            </button>
            <div class="dropdown-menu">
            ' . $boton_editar . $boton_eliminar . '
                    
                        
                    </div>
                </div>',
                "NO"=>$datos[$i]['idMunicipio'], //nombre de la tablas en la base de datos
                "MUNICIPIO"=>$datos[$i]['Descripcion'],
               
                
            );

        }

        $resultados = array(
            "sEcho" =>1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" =>$list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

break;
case "obtener_municipio_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if( isset($_POST["idMunicipio"]) && !empty($_POST["idMunicipio"]) ){
        $data = $tablas->ObtenerMunicipioPorId($_POST["idMunicipio"]);
        if($data){
            $list[] = array(
                "ID"=>$data['idMunicipio'],  //nombres de la base de datos
                "MUNICIPIO"=>$data['Descripcion'],//nombres de la base de datos
               

            );
            echo json_encode($list);
        }
    }

break;

case "registrar_Municipio":
    if( isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])){

        $descripcion = $_POST["Descripcion"];

        if( $tablas->RegistrarMunicipio($descripcion) ){
           $response = "success";  //si se inserto en la BD manda mensaje de exito
        }else{
            $response = "error"; 
        }
    }else{
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


break;
    
case "actualizar_municipio":
    if( isset($_POST["idMunicipio"],$_POST["Descripcion"])  && !empty($_POST["idMunicipio"]) && !empty($_POST["Descripcion"]) ){
           
            $idMunicipio = $_POST["idMunicipio"];
            $Descripcion = $_POST["Descripcion"];
           
          
            if( $tablas->ActualizarMunicipio($idMunicipio, $Descripcion) ){
                $response = "success";  //si se inserto en la BD manda mensaje de exito
           
            }else{
                $response = "error";  //error al insertar en BD
            }    
       
    }else{
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

break;  
   
case "eliminar_Municipio":
    if( isset($_POST["idMunicipio"]) && !empty($_POST["idMunicipio"]) ){
 
        $eliminar = $tablas->EliminarMunicipio($_POST["idMunicipio"]);
       if( $eliminar == "elimino"){
            $response ="success";  //si elimino correctamente

       }else if($eliminar == "Llave en uso"){  //si la llave ya esta en uso en otras tablas
          $response = "llave_uso";
       }else{
          $response = "error";  //cualquier otro tipo de error
       }

    }else{
       $response = "error";
    }
    echo $response;
 
 break;
 /**************  VALIDACIONES TABLA TIPO PAGO *****************************************************************************/
 case "listar_Tipo_Pago":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarTipoPago() : []; //obtiene los datos del metodo
    if ($datos) {

        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Tipopago" 
        onclick="ObtenerTipoPagoPorId(' . $datos[$i]['idTipoPago'] . ",'editar'" . ');">
        <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerTipoPagoPorId(' . $datos[$i]['idTipoPago'] . ",'eliminar'" . ');">
        <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
            </button>
            <div class="dropdown-menu">
            ' . $boton_editar . $boton_eliminar . '
                    
                </div>
            </div>',
                "NO" => $datos[$i]['idTipoPago'], //nombre de la tablas en la base de datos
                "TIPOPAGO" => $datos[$i]['descripcion'],


            );
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" => $list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

    break;
case "obtener_tipo_pago_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if (isset($_POST["idTipoPago"]) && !empty($_POST["idTipoPago"])) {
        $data = $tablas->ObtenerTipoPagoPorId($_POST["idTipoPago"]);
        if ($data) {
            $list[] = array(
                "ID" => $data['idTipoPago'],  //nombres de la base de datos
                "TIPOPAGO" => $data['descripcion'], //nombres de la base de datos


            );
            echo json_encode($list);
        }
    }

    break;

case "registrar_Tipopago":
    if (isset($_POST["descripcion"]) && !empty($_POST["descripcion"])) {

        $descripcion = $_POST["descripcion"];

        if ($tablas->RegistrarTipoPago($descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito
        } else {
            $response = "error";
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


    break;

case "actualizar_tipopago":
    if (isset($_POST["idTipoPago"], $_POST["descripcion"])  && !empty($_POST["idTipoPago"]) && !empty($_POST["descripcion"])) {

        $idTipoPago = $_POST["idTipoPago"];
        $descripcion = $_POST["descripcion"];


        if ($tablas->ActualizarTipoPago($idTipoPago, $descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito

        } else {
            $response = "error";  //error al insertar en BD
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

    break;

case "eliminar_Tipopago":
    if (isset($_POST["idTipoPago"]) && !empty($_POST["idTipoPago"])) {

        $eliminar = $tablas->EliminarTipoPago($_POST["idTipoPago"]);
        if ($eliminar == "elimino") {
            $response = "success";  //si elimino correctamente

        } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
            $response = "llave_uso";
        } else {
            $response = "error";  //cualquier otro tipo de error
        }
    } else {
        $response = "error";
    }
    echo $response;

    break;
     /**************  VALIDACIONES TABLA TIPO Cliente *****************************************************************************/
 case "listar_Tipo_Cliente":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarTipoCliente() : []; //obtiene los datos del metodo
    if ($datos) {

        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Tipocliente" 
        onclick="ObtenerTipoClientePorId(' . $datos[$i]['idTipoCliente'] . ",'editar'" . ');">
        <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerTipoClientePorId(' . $datos[$i]['idTipoCliente'] . ",'eliminar'" . ');">
        <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
            </button>
            <div class="dropdown-menu">
            ' . $boton_editar . $boton_eliminar . '
                    
                </div>
            </div>',
                "NO" => $datos[$i]['idTipoCliente'], //nombre de la tablas en la base de datos
                "TIPOCLIENTE" => $datos[$i]['Descripcion'],


            );
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" => $list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

    break;
case "obtener_tipo_cliente_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if (isset($_POST["idTipoCliente"]) && !empty($_POST["idTipoCliente"])) {
        $data = $tablas->ObtenerTipoClientePorId($_POST["idTipoCliente"]);
        if ($data) {
            $list[] = array(
                "ID" => $data['idTipoCliente'],  //nombres de la base de datos
                "TIPOCLIENTE" => $data['Descripcion'], //nombres de la base de datos


            );
            echo json_encode($list);
        }
    }

    break;

case "registrar_Tipocliente":
    if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

        $descripcion = $_POST["Descripcion"];

        if ($tablas->RegistrarTipoCliente($descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito
        } else {
            $response = "error";
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


    break;

case "actualizar_tipocliente":
    if (isset($_POST["idTipoCliente"], $_POST["Descripcion"])  && !empty($_POST["idTipoCliente"]) && !empty($_POST["Descripcion"])) {

        $idTipoCliente = $_POST["idTipoCliente"];
        $descripcion = $_POST["Descripcion"];


        if ($tablas->ActualizarTipoCliente($idTipoCliente, $descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito

        } else {
            $response = "error";  //error al insertar en BD
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

    break;

case "eliminar_Tipocliente":
    if (isset($_POST["idTipoCliente"]) && !empty($_POST["idTipoCliente"])) {

        $eliminar = $tablas->EliminarTipoCliente($_POST["idTipoCliente"]);
        if ($eliminar == "elimino") {
            $response = "success";  //si elimino correctamente

        } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
            $response = "llave_uso";
        } else {
            $response = "error";  //cualquier otro tipo de error
        }
    } else {
        $response = "error";
    }
    echo $response;

    break;
/**************  VALIDACIONES TABLA ESTADO CREDITO *****************************************************************************/
case "listar_Estado_Credito":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarEstadoCredito() : []; //obtiene los datos del metodo
    if ($datos) {

        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Estadocredito" 
        onclick="ObtenerEstadoCreditoPorId(' . $datos[$i]['idEstadoCredito'] . ",'editar'" . ');">
        <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerEstadoCreditoPorId(' . $datos[$i]['idEstadoCredito'] . ",'eliminar'" . ');">
        <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
            </button>
            <div class="dropdown-menu">
            ' . $boton_editar . $boton_eliminar . '
                    
                </div>
            </div>',
                "NO" => $datos[$i]['idEstadoCredito'], //nombre de la tablas en la base de datos
                "ESTADOCREDITO" => $datos[$i]['Descripcion'],


            );
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" => $list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

    break;
case "obtener_estado_credito_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if (isset($_POST["idEstadoCredito"]) && !empty($_POST["idEstadoCredito"])) {
        $data = $tablas->ObtenerEstadoCreditoPorId($_POST["idEstadoCredito"]);
        if ($data) {
            $list[] = array(
                "ID" => $data['idEstadoCredito'],  //nombres de la base de datos
                "ESTADOCREDITO" => $data['Descripcion'], //nombres de la base de datos


            );
            echo json_encode($list);
        }
    }

    break;

case "registrar_Estadocredito":
    if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

        $descripcion = $_POST["Descripcion"];

        if ($tablas->RegistrarEstadoCredito($descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito
        } else {
            $response = "error";
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


    break;

case "actualizar_estadocredito":
    if (isset($_POST["idEstadoCredito"], $_POST["Descripcion"])  && !empty($_POST["idEstadoCredito"]) && !empty($_POST["Descripcion"])) {

        $idEstadoCredito = $_POST["idEstadoCredito"];
        $descripcion = $_POST["Descripcion"];


        if ($tablas->ActualizarEstadoCredito($idEstadoCredito, $descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito

        } else {
            $response = "error";  //error al insertar en BD
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

    break;

case "eliminar_Estadocredito":
    if (isset($_POST["idEstadoCredito"]) && !empty($_POST["idEstadoCredito"])) {

        $eliminar = $tablas->EliminarEstadoCredito($_POST["idEstadoCredito"]);
        if ($eliminar == "elimino") {
            $response = "success";  //si elimino correctamente

        } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
            $response = "llave_uso";
        } else {
            $response = "error";  //cualquier otro tipo de error
        }
    } else {
        $response = "error";
    }
    echo $response;

    break;
    /**************  VALIDACIONES TABLA TIPO PAGO *****************************************************************************/
 case "listar_Analisis":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarAnalisis() : []; //obtiene los datos del metodo
    if ($datos) {

        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Analisis" 
        onclick="ObtenerAnalisisPorId(' . $datos[$i]['idestadoAnalisisCrediticio'] . ",'editar'" . ');">
        <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerAnalisisPorId(' . $datos[$i]['idestadoAnalisisCrediticio'] . ",'eliminar'" . ');">
        <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
            </button>
            <div class="dropdown-menu">
            ' . $boton_editar . $boton_eliminar . '
                    
                </div>
            </div>',
                "NO" => $datos[$i]['idestadoAnalisisCrediticio'], //nombre de la tablas en la base de datos
                "ANALISIS" => $datos[$i]['descripcion'],


            );
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" => $list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

    break;
case "obtener_analisis_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if (isset($_POST["idestadoAnalisisCrediticio"]) && !empty($_POST["idestadoAnalisisCrediticio"])) {
        $data = $tablas->ObtenerAnalisisPorId($_POST["idestadoAnalisisCrediticio"]);
        if ($data) {
            $list[] = array(
                "ID" => $data['idestadoAnalisisCrediticio'],  //nombres de la base de datos
                "ANALISIS" => $data['descripcion'], //nombres de la base de datos


            );
            echo json_encode($list);
        }
    }

    break;

case "registrar_Analisis":
    if (isset($_POST["descripcion"]) && !empty($_POST["descripcion"])) {

        $descripcion = $_POST["descripcion"];

        if ($tablas->RegistrarAnalisis($descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito
        } else {
            $response = "error";
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


    break;

case "actualizar_analisis":
    if (isset($_POST["idestadoAnalisisCrediticio"], $_POST["descripcion"])  && !empty($_POST["idestadoAnalisisCrediticio"]) && !empty($_POST["descripcion"])) {

        $idestadoAnalisisCrediticio = $_POST["idestadoAnalisisCrediticio"];
        $descripcion = $_POST["descripcion"];


        if ($tablas->ActualizarAnalisis($idestadoAnalisisCrediticio, $descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito

        } else {
            $response = "error";  //error al insertar en BD
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

    break;

case "eliminar_Analisis":
    if (isset($_POST["idestadoAnalisisCrediticio"]) && !empty($_POST["idestadoAnalisisCrediticio"])) {

        $eliminar = $tablas->EliminarAnalisis($_POST["idestadoAnalisisCrediticio"]);
        if ($eliminar == "elimino") {
            $response = "success";  //si elimino correctamente

        } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
            $response = "llave_uso";
        } else {
            $response = "error";  //cualquier otro tipo de error
        }
    } else {
        $response = "error";
    }
    echo $response;

    break;

     /**************  VALIDACIONES AVALA APERSONA *****************************************************************************/
 case "listar_Avala":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarAvala() : []; //obtiene los datos del metodo
    if ($datos) {

        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Avala" 
        onclick="ObtenerAvalaPorId(' . $datos[$i]['idEsAval'] . ",'editar'" . ');">
        <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerAvalaPorId(' . $datos[$i]['idEsAval'] . ",'eliminar'" . ');">
        <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
            </button>
            <div class="dropdown-menu">
            ' . $boton_editar . $boton_eliminar . '
                    
                </div>
            </div>',
                "NO" => $datos[$i]['idEsAval'], //nombre de la tablas en la base de datos
                "AVALA" => $datos[$i]['Descripcion'],


            );
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" => $list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

    break;
case "obtener_avala_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if (isset($_POST["idEsAval"]) && !empty($_POST["idEsAval"])) {
        $data = $tablas->ObtenerAvalaPorId($_POST["idEsAval"]);
        if ($data) {
            $list[] = array(
                "ID" => $data['idEsAval'],  //nombres de la base de datos
                "AVALA" => $data['Descripcion'], //nombres de la base de datos


            );
            echo json_encode($list);
        }
    }

    break;

case "registrar_Avala":
    if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

        $descripcion = $_POST["Descripcion"];

        if ($tablas->RegistrarAvala($descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito
        } else {
            $response = "error";
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


    break;

case "actualizar_avala":
    if (isset($_POST["idEsAval"], $_POST["Descripcion"])  && !empty($_POST["idEsAval"]) && !empty($_POST["Descripcion"])) {

        $idEsAval = $_POST["idEsAval"];
        $descripcion = $_POST["Descripcion"];


        if ($tablas->ActualizarAvala($idEsAval, $descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito

        } else {
            $response = "error";  //error al insertar en BD
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

    break;

case "eliminar_Avala":
    if (isset($_POST["idEsAval"]) && !empty($_POST["idEsAval"])) {

        $eliminar = $tablas->EliminarAvala($_POST["idEsAval"]);
        if ($eliminar == "elimino") {
            $response = "success";  //si elimino correctamente

        } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
            $response = "llave_uso";
        } else {
            $response = "error";  //cualquier otro tipo de error
        }
    } else {
        $response = "error";
    }
    echo $response;

    break;
    /**************  VALIDACIONES TABLA TIPO PERSONA *****************************************************************************/
 case "listar_Tipo_Persona":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarTipoPersona() : []; //obtiene los datos del metodo
    if ($datos) {

        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Tipopersona" 
        onclick="ObtenerTipoPersonaPorId(' . $datos[$i]['idTipoPersona'] . ",'editar'" . ');">
        <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerTipoPersonaPorId(' . $datos[$i]['idTipoPersona'] . ",'eliminar'" . ');">
        <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
            </button>
            <div class="dropdown-menu">
            ' . $boton_editar . $boton_eliminar . '
                    
                </div>
            </div>',
                "NO" => $datos[$i]['idTipoPersona'], //nombre de la tablas en la base de datos
                "TIPOPERSONA" => $datos[$i]['Descripcion'],


            );
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" => $list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

    break;
case "obtener_tipo_persona_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if (isset($_POST["idTipoPersona"]) && !empty($_POST["idTipoPersona"])) {
        $data = $tablas->ObtenerTipoPersonaPorId($_POST["idTipoPersona"]);
        if ($data) {
            $list[] = array(
                "ID" => $data['idTipoPersona'],  //nombres de la base de datos
                "TIPOPERSONA" => $data['Descripcion'], //nombres de la base de datos


            );
            echo json_encode($list);
        }
    }

    break;

case "registrar_Tipopersona":
    if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

        $descripcion = $_POST["Descripcion"];

        if ($tablas->RegistrarTipoPersona($descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito
        } else {
            $response = "error";
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


    break;

case "actualizar_tipopersona":
    if (isset($_POST["idTipoPersona"], $_POST["Descripcion"])  && !empty($_POST["idTipoPersona"]) && !empty($_POST["Descripcion"])) {

        $idTipoPersona = $_POST["idTipoPersona"];
        $descripcion = $_POST["Descripcion"];


        if ($tablas->ActualizarTipoPersona($idTipoPersona, $descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito

        } else {
            $response = "error";  //error al insertar en BD
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

    break;

case "eliminar_Tipopersona":
    if (isset($_POST["idTipoPersona"]) && !empty($_POST["idTipoPersona"])) {

        $eliminar = $tablas->EliminarTipoPersona($_POST["idTipoPersona"]);
        if ($eliminar == "elimino") {
            $response = "success";  //si elimino correctamente

        } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
            $response = "llave_uso";
        } else {
            $response = "error";  //cualquier otro tipo de error
        }
    } else {
        $response = "error";
    }
    echo $response;

    break;
     /**************  VALIDACIONES TABLA TIPO CUENTA *****************************************************************************/
 case "listar_Tipo_Cuenta":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarTipoCuenta() : []; //obtiene los datos del metodo
    if ($datos) {

        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '<a class="dropdown-item" data-toggle="modal" data-target="#actualizar_Tipocuenta" 
        onclick="ObtenerTipoCuentaPorId(' . $datos[$i]['idTipoCuenta'] . ",'editar'" . ');">
        <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerTipoCuentaPorId(' . $datos[$i]['idTipoCuenta'] . ",'eliminar'" . ');">
        <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
            <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
            </button>
            <div class="dropdown-menu">
            ' . $boton_editar . $boton_eliminar . '
                    
                </div>
            </div>',
                "NO" => $datos[$i]['idTipoCuenta'], //nombre de la tablas en la base de datos
                "TIPOCUENTA" => $datos[$i]['Descripcion'],


            );
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" => $list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

    break;
case "obtener_tipo_cuenta_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if (isset($_POST["idTipoCuenta"]) && !empty($_POST["idTipoCuenta"])) {
        $data = $tablas->ObtenerTipoCuentaPorId($_POST["idTipoCuenta"]);
        if ($data) {
            $list[] = array(
                "ID" => $data['idTipoCuenta'],  //nombres de la base de datos
                "TIPOCUENTA" => $data['Descripcion'], //nombres de la base de datos


            );
            echo json_encode($list);
        }
    }

    break;

case "registrar_Tipocuenta":
    if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

        $descripcion = $_POST["Descripcion"];

        if ($tablas->RegistrarTipoCuenta($descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito
        } else {
            $response = "error";
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


    break;

case "actualizar_tipocuenta":
    if (isset($_POST["idTipoCuenta"], $_POST["Descripcion"])  && !empty($_POST["idTipoCuenta"]) && !empty($_POST["Descripcion"])) {

        $idTipoCuenta = $_POST["idTipoCuenta"];
        $descripcion = $_POST["Descripcion"];


        if ($tablas->ActualizarTipoCuenta($idTipoCuenta, $descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito

        } else {
            $response = "error";  //error al insertar en BD
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

    break;

case "eliminar_Tipocuenta":
    if (isset($_POST["idTipoCuenta"]) && !empty($_POST["idTipoCuenta"])) {

        $eliminar = $tablas->EliminarTipoCuenta($_POST["idTipoCuenta"]);
        if ($eliminar == "elimino") {
            $response = "success";  //si elimino correctamente

        } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
            $response = "llave_uso";
        } else {
            $response = "error";  //cualquier otro tipo de error
        }
    } else {
        $response = "error";
    }
    echo $response;

    break;
    
/*************  VALIDACIONES DE CREDITO AVAL ************************************************************************************/
case "listar_creditoaval":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarCreditoAval() : [];  //obtiene los datos del metodo
    if ($datos) {
        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '   <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_creditoaval" 
            onclick="ObtenerCreditoAvalPorId(' . $datos[$i]['idCreditoAval'] . ",'editar'" . ');">
            <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerCreditoAvalPorId(' . $datos[$i]['idCreditoAval'] . ",'eliminar'" . ');">
            <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                    </button>
                    <div class="dropdown-menu">
                     
                    ' . $boton_editar . $boton_eliminar . '
                  
                    
                        
                    </div>
                </div>',
                "NO" => $datos[$i]['idCreditoAval'], //nombre de la tablas en la base de datos
                "CREDITOAVAL" => $datos[$i]['Descripcion'],


            );
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" => $list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

    break;

case "obtener_credito_aval_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if (isset($_POST["idCreditoAval"]) && !empty($_POST["idCreditoAval"])) {
        $data = $tablas->ObtenerCreditoAvalPorId($_POST["idCreditoAval"]);
        if ($data) {
            $list[] = array(
                "ID" => $data['idCreditoAval'],  //nombres de la base de datos
                "CREDITOAVAL" => $data['Descripcion'], //nombres de la base de datos


            );
            echo json_encode($list);
        }
    }

    break;

case "registrar_credito_aval":
    if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

        $descripcion = $_POST["Descripcion"];

        if ($tablas->RegistrarCreditoAval($descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito
        } else {
            $response = "error";
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


    break;

case "actualizar_credito_aval":
    if (isset($_POST["idCreditoAval"], $_POST["Descripcion"])  && !empty($_POST["idCreditoAval"]) && !empty($_POST["Descripcion"])) {

        $idCreditoAval = $_POST["idCreditoAval"];
        $Descripcion = $_POST["Descripcion"];


        if ($tablas->ActualizarCreditoAval($idCreditoAval, $Descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito

        } else {
            $response = "error";  //error al insertar en BD
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

    break;


case "eliminar_credito_aval":
    if (isset($_POST["idCreditoAval"]) && !empty($_POST["idCreditoAval"])) {

        $eliminar = $tablas->EliminarCreditoAval($_POST["idCreditoAval"]);
        if ($eliminar == "elimino") {
            $response = "success";  //si elimino correctamente

        } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
            $response = "llave_uso";
        } else {
            $response = "error";  //cualquier otro tipo de error
        }
    } else {
        $response = "error";
    }
    echo $response;

    break;
    /*************  VALIDACIONES DE OBJETOS************************************************************************************/
case "listar_objeto":
    $resultados = array(
        "sEcho" => 0,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "aaData" => []
    );
    $datos = $_SESSION["consultar"] >= 1 ? $tablas->ListarObjeto() : [];  //obtiene los datos del metodo
    if ($datos) {
        for ($i = 0; $i < count($datos); $i++) {
            $boton_editar = $_SESSION["actualizar"] >= 1 ? '   <a class="dropdown-item" data-toggle="modal" data-target="#actualizar_objetos" 
            onclick="ObtenerObjetosPorId(' . $datos[$i]['idObjetos'] . ",'editar'" . ');">
            <i class="icon-edit"></i> Editar </a>' : '<span class="tag tag-warning">No puede editar</span>';
            $boton_eliminar = $_SESSION["eliminar"] >= 1 ? '<a class="dropdown-item" onclick="ObtenerObjetosPorId(' . $datos[$i]['idObjetos'] . ",'eliminar'" . ');">
            <i class="icon-trash"></i> Eliminar </a>' : '<span class="tag tag-danger">No puede eliminar</span>';

            $list[] = array(
                "Acciones" => '<div class="btn-group"> 
                    <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                    </button>
                    <div class="dropdown-menu">
                     
                    ' . $boton_editar . $boton_eliminar . '
                  
                    
                        
                    </div>
                </div>',
                "NO" => $datos[$i]['idObjetos'], //nombre de la tablas en la base de datos
                "OBJETO" => $datos[$i]['Descripcion'],


            );
        }

        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => count($list),
            "iTotalDisplayRecords" => count($list),
            "aaData" => $list
        );
    }
    echo json_encode($resultados); //datos en formato json para la datatable

    break;

case "obtener_objeto_por_id": //sirve para obtener el id para poder actualizar o eliminar
    if (isset($_POST["idObjetos"]) && !empty($_POST["idObjetos"])) {
        $data = $tablas->ObtenerObjetosPorId($_POST["idObjetos"]);
        if ($data) {
            $list[] = array(
                "ID" => $data['idObjetos'],  //nombres de la base de datos
                "OBJETO" => $data['Descripcion'], //nombres de la base de datos


            );
            echo json_encode($list);
        }
    }

    break;

case "registrar_objeto":
    if (isset($_POST["Descripcion"]) && !empty($_POST["Descripcion"])) {

        $descripcion = $_POST["Descripcion"];

        if ($tablas->RegistrarObjetos($descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito
        } else {
            $response = "error";
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;


    break;

case "actualizar_objeto":
    if (isset($_POST["idObjetos"], $_POST["Descripcion"])  && !empty($_POST["idObjetos"]) && !empty($_POST["Descripcion"])) {

        $idObjetos = $_POST["idObjetos"];
        $Descripcion = $_POST["Descripcion"];


        if ($tablas->ActualizarObjetos($idObjetos, $Descripcion)) {
            $response = "success";  //si se inserto en la BD manda mensaje de exito

        } else {
            $response = "error";  //error al insertar en BD
        }
    } else {
        $response = "requerid"; //validad que ingresa todo los datos requeridos
    }

    echo $response;

    break;


case "eliminar_objeto":
    if (isset($_POST["idObjetos"]) && !empty($_POST["idObjetos"])) {

        $eliminar = $tablas->EliminarObjetos($_POST["idObjetos"]);
        if ($eliminar == "elimino") {
            $response = "success";  //si elimino correctamente

        } else if ($eliminar == "Llave en uso") {  //si la llave ya esta en uso en otras tablas
            $response = "llave_uso";
        } else {
            $response = "error";  //cualquier otro tipo de error
        }
    } else {
        $response = "error";
    }
    echo $response;

    break;

} //fin switch
