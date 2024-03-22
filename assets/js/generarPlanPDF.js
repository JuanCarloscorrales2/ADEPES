function PlanPagosPDF(){
  var idSolicitud =$('#idprestamo').val();
  var nombre =$('#nombre').val();
  var monto =$('#prestamo').val();
  var tasaInteres =$('#tasa').val();
  var fechaEmision =  $('#fecha').val();
  var cuota =$('#cuota').val();

// Envía el idSoli al script PHP que genera el PDF
  window.location.href = '../pages/fpdf/planPDF.php?idSoli=' + idSolicitud + '&nombre=' + nombre
  + '&monto=' + monto + '&tasaInteres=' + tasaInteres + '&fechaEmision=' + fechaEmision + '&cuota=' + cuota;
}
   