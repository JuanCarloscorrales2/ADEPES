<?php
session_start(); //fuarda la sesion del usuario
require "../model/CobrosModel.php";
date_default_timezone_set('America/Tegucigalpa');
$cobro =  new Cobros();
switch ($_REQUEST["operador"]) {

    case "listar_prestamos_cobro":
        $resultados = array(
            "sEcho" => 0,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
         );

        $datos = $cobro->ListarPrestamosCobros(); //obtiene los datos del metodo
        if ($datos) {
            for ($i = 0; $i < count($datos); $i++) {
                $list[] = array(
                    "Acciones" =>

                    ' <a class="btn btn-success" href="../pages/cobrosCliente.php"
                    onclick="ObtenerDatosPrestamo(' . $datos[$i]['idSolicitud'] . ",'Editar'" . ');"><i class="icon-money"></i> Agregar Pago</a>
                </a>',
                    "idSolicitud" => $datos[$i]['idSolicitud'],
                    "nombre" => $datos[$i]['nombre'],
                    "identidad" => $datos[$i]['identidad'], //nombre de la tablas en la base de datos
                    "Monto" => $datos[$i]['Monto'],
                    "Plazo" => $datos[$i]['Plazo'],
                    "FechaDesembolso" => $datos[$i]['fechaAprob'],
                    "idEstadoPlanPagos" => ($datos[$i]['idEstadoPlanPagos'] == 1) ? '<span class="tag tag-warning">Pendiente</span>' : (($datos[$i]['idEstadoPlanPagos'] == 2) ? '<span class="tag tag-success">Cancelado</span>' :
                            '<span class="tag tag-danger">Mora</span>'),
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

    case "listar_cuota_persona":
        $datos = $cobro->ListarCuotaPersona($_POST["idSolicitud"],isset($_POST["next_pay"])); //obtiene los datos del metodo
        $resultados = array(
            "sEcho" => 1,
            "iTotalRecords" => 0,
            "iTotalDisplayRecords" => 0,
            "aaData" => []
        );
        if ($datos) {
           

            for ($i = 0; $i < count($datos); $i++) {
                $boton_imprimir=  $datos[$i]['idEstadoPlanPagos'] == 4? '<a class="dropdown-item bg-danger"
                > Sin Acciones Disponibles</a>':    '<a class="dropdown-item"
                onclick="ObtenerCuotaPorId(' . $datos[$i]['idPlanCuota'] . ",'Imprimir'" . ');"> <i class="icon-money"></i> Imprimir Recibo</a>';
               
               $object= array(
                    "Acciones" => (($datos[$i]['idEstadoPlanPagos'] == 1 || $datos[$i]['idEstadoPlanPagos'] == 3)&&!isset($_POST["no_actions"])) ?
                        '<div class="btn-group"> 
                     <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                     </button>
                     <div class="dropdown-menu">
                        <a class="dropdown-item"
                        onclick="ObtenerCuotaPorId(' . $datos[$i]['idPlanCuota'] . ",'PagarCuota'" . ');"> <i class="icon-money"></i> Seleccionar Cuota</a>
                

                     </div>
                  </div>' : //imprime recibo de cuota
                        '<div class="btn-group"> 
                     <button class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="true"> <i class="icon-gear"> </i>
                     </button>
                     <div class="dropdown-menu">
                         '.$boton_imprimir.'
                     </div>
                  </div>',
                    "idPlanCuota" => $datos[$i]['idPlanCuota'],
                    "NumeroCuotas" => $datos[$i]['NumeroCuotas'],
                    "FechaCuota" => $datos[$i]['FechaCuota'],
                    "fechaDeposito" => $datos[$i]['fechaDeposito'],
                    "valorCuota" => $datos[$i]['pagos'], //nombre de la tablas en la base de datos
                    "pagoAdicional" => $datos[$i]['pagoAdicional'],
                    "saldoCapital" => $datos[$i]['saldoCapital'],
                    "diasRetraso" => $datos[$i]['diasRetraso'],
                    "interesesMoratorios" => $datos[$i]['interesesMoratorios'],
                    "mora" => $datos[$i]['mora'],
                    "Descripcion" => ($datos[$i]['idEstadoPlanPagos'] == 1) ? '<span class="tag tag-warning">Pendiente</span>' : (($datos[$i]['idEstadoPlanPagos'] == 2) ? '<span class="tag tag-success">Pagado</span>' :
                           (($datos[$i]['idEstadoPlanPagos'] == 4) ? '<span class="tag tag-info">Cancelada por pago anticipado</span>' :
                            '<span class="tag tag-danger">Mora</span>') )
                );
                $list[] =$object;

            }

            $resultados = array(
                "sEcho" => 1,
                "iTotalRecords" => $datos?count($list):0,
                "iTotalDisplayRecords" => $datos?count($list):0,
                "aaData" => $datos?$list:[]
            );
        }
        echo json_encode($resultados); //datos en formato json para la datatable

        break;


    case "datos_cliente":

        if (isset($_POST["idSolicitud"]) && !empty($_POST["idSolicitud"])) {
            $data = $cobro->datosCliente($_POST["idSolicitud"]);
            if ($data) {
                $list[] = array(
                    "cliente" => $data['cliente'],
                    "identidad" => $data['identidad'],
                    "Monto" => $data['Monto'],
                    "plazo" => $data['plazo'],
                    "FechaAprob" => $data['FechaAprob'],
                    "totalInteres" => $data['totalInteres'],

                );
                echo json_encode($list);
            }
        }

        break;

    case "obtener_cuota_por_id":
        if (isset($_POST["idPlanCuota"]) && !empty($_POST["idPlanCuota"])) {
            $data = $cobro->ObtenerCuotaPorId($_POST["idPlanCuota"]);
            if ($data) {
                $list[] = array(
                    "idPlanCuota" => $data['idPlanCuota'],
                    "NumeroCuotas" => $data['NumeroCuotas'],
                    "FechaCuota" => $data['FechaCuota'],
                    "valorCuota" => $data['valorCuota'],
                    "valorInteres" => $data['valorInteres'],
                    "valorCapital" => $data['valorCapital'],
                    "mora" => $data['mora']

                );
                echo json_encode($list);
            }
        }

        break;


    case "actualizar_pagoCuota_movimiento":
        if (
            isset($_POST["idPlanCuota"], $_POST["montoPago"], $_POST["fechaDeposito"])
            && !empty($_POST["idPlanCuota"]) && !empty($_POST["montoPago"]) && !empty($_POST["fechaDeposito"])
        ) {

            $idPlanCuota = $_POST["idPlanCuota"];
            $montoPago = $_POST["montoPago"];
            $abonoCapital = $_POST["abonoCapital"];
            $fechaDeposito = $_POST["fechaDeposito"];
            $pagoAdicional = $_POST["pagoAdicional"] == '' ? 0.00 : $_POST["pagoAdicional"];
            $idSolicitud = $_POST["idSolicitud"];
            $resultado=$cobro->AgregarPagoPlanCuotas($idPlanCuota, $fechaDeposito, $montoPago, $abonoCapital, $pagoAdicional,$idSolicitud);
            if ($resultado) {
                $response ="success";
            } else {
                $response = "error";
            }
        } else {
            $response = "requerid"; //validad que ingresa todo los datos requeridos
        }

        echo $response;

        break;


    case "obtener_valorCapital":
        if (isset($_POST["idSolicitud"]) && !empty($_POST["idSolicitud"])) {
            $data = $cobro->ObtenerValorCapitalTotal($_POST["idSolicitud"]);
            if ($data) {
                $list[] = array(
                    "totalAbonoCapital" => $data['totalAbonoCapital']

                );
                echo json_encode($list);
            }
        }

        break;

    case "liquidar_prestamo":
        if (isset($_POST["idSolicitud"]) && !empty($_POST["idSolicitud"])) {
            $fechaDeposito = date('Y/m/d');
            if ($cobro->LiquidarPrestamo($_POST["idSolicitud"], $fechaDeposito)) {

                $response = "success";
            } else {
                $response = "error";
            }
        }
        echo $response;

        break;
}
