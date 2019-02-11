<?
$body = @file_get_contents('php://input');
$data = json_decode($body);
http_response_code(200); // Return 200 OK

if ($data->type == 'charge.paid'){
    $payment_method = $data->charges->data->object->payment_method->type;
    $id_order = $data->object->id;
    $msg = "Tu pago ha sido comprobado. Orden: $id_order";
    mail("pagos@planetaenvios.com","Pago ". $payment_method ." confirmado",$msg);
}



?>