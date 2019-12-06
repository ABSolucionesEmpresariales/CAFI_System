<?php
// SDK de Mercado Pago
require __DIR__ .  '/vendor/autoload.php';

// Agrega credenciales
MercadoPago\SDK::setAccessToken('APP_USR-580643193217270-120220-0b71eb7a52a2394b42265d46837ed6f6-496115156');

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->title = 'Paquete Basico';
$item->quantity = 1;
$item->unit_price = 450.00;
$preference->items = array($item);
$preference->save();
?>

<form action="/procesar-pago" method="POST">
  <script
   src="https://www.mercadopago.com.mx/integrations/v1/web-payment-checkout.js"
   data-preference-id="<?php echo $preference->id; ?>">
  </script>
</form>