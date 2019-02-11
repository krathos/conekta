<?
require_once("assets/conekta/lib/Conekta.php");
\Conekta\Conekta::setApiKey("key_uuzavZSityqQzqNDu28HRQ");
\Conekta\Conekta::setApiVersion("2.0.0");

$total = 70000;

try{
    $order = \Conekta\Order::create(
        array(
            "line_items" => array(
                array(
                    "name" => "Tacos",
                    "unit_price" => $total,
                    "quantity" => 1
                )//first line_item
            ), //line_items
            "shipping_lines" => array(
                array(
                    "amount" => 0,
                    "carrier" => "FEDEX"
                )
            ), //shipping_lines - physical goods only
            "currency" => "MXN",
            "customer_info" => array(
                "name" => "Fulanito Pérez",
                "email" => "fulanito@conekta.com",
                "phone" => "+5218181818181"
            ), //customer_info
            "shipping_contact" => array(
                "address" => array(
                    "street1" => "Calle 123, int 2",
                    "postal_code" => "06100",
                    "country" => "MX"
                )//address
            ), //shipping_contact - required only for physical goods
            "charges" => array(
                array(
                    "payment_method" => array(
                        "type" => "spei"
                    )//payment_method
                ) //first charge
            ) //charges
        )//order
    );
} catch (\Conekta\ParameterValidationError $error){
    echo $error->getMessage();
} catch (\Conekta\Handler $error){
    echo $error->getMessage();
}


echo "ID: ". $order->id;
echo "Bank: ". $order->charges->data[0]->payment_method->receiving_account_bank;
echo "CLABE: ". $order->charges->data[0]->payment_method->receiving_account_number;
echo "$". $order->amount/100 . $order->currency;
echo "Order";
echo $order->line_items->data[0]->quantity .
    "-". $order->line_items->data[0]->name .
    "- $". $order->line_items->data->unit_price/100;

// Response
// ID: ord_2fsQdMUmsFNP2WjqS
// Bank: STP
// CLABE: 646180111812345678
// $ 135.0 MXN
// Order
// 12 - Tacos - $10.0



?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<link href="assets/conekta/spei/styles.css" media="all" rel="stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
</head>

<body>

<div class="ps">
    <div class="ps-header">
        <div class="ps-reminder">Ficha digital. No es necesario imprimir.</div>
        <div class="ps-info">
            <div class="ps-brand"><img src="images/spei_brand.png" alt="Banorte"></div>
            <div class="ps-amount">
                <h3>Monto a pagar</h3>
                <h2>$ <?=$order->amount/100;?> <sup>MXN</sup></h2>
                <p>Utiliza exactamente esta cantidad al realizar el pago.</p>
            </div>
        </div>
        <div class="ps-reference">
            <h3>CLABE</h3>
            <h1>0000000000000000000</h1>
        </div>
    </div>
    <div class="ps-instructions">
        <h3>Instrucciones</h3>
        <ol>
            <li>Accede a tu banca en línea.</li>
            <li>Da de alta la CLABE en esta ficha. <strong>El banco deberá de ser STP</strong>.</li>
            <li>Realiza la transferencia correspondiente por la cantidad exacta en esta ficha, <strong>de lo contrario se rechazará el cargo</strong>.</li>
            <li>Al confirmar tu pago, el portal de tu banco generará un comprobante digital. <strong>En el podrás verificar que se haya realizado correctamente.</strong> Conserva este comprobante de pago.</li>
        </ol>
        <div class="ps-footnote">Al completar estos pasos recibirás un correo de <strong>Planeta Envios</strong> confirmando tu pago.</div>
    </div>
</div>

</body>
</html>