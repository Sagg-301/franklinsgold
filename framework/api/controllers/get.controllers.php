<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

use app\models as Model;

$app->get('/', function() use($app) {
    return $app->json(array()); 
});

$app->get('origenes/get', function() use($app) {
    $o = new Model\Origen; 

    return $app->json($o->getOrigenes());
});

$app->get('/transaccion/get/{id}', function($id) use($app) {
    $t = new Model\Transaccion; 
  
    return $app->json($t->getByUser($id));   
  });

$app->get('afiliados/getTelefonos/{id}', function($id) use($app) {
    $a = new Model\Afiliados; 

    return $app->json($a->getTelefonos($id));
});

$app->get('afiliados/getIntercambios/{id}', function($id) use($app) {
    $a = new Model\Afiliados; 

    return $app->json($a->getIntercambios($id));
});

$app->get('afiliados/getIntercambiosUser/{id}/{id_comercio}', function($id,$id_comercio) use($app) {
    $t = new Model\Transaccion; 

    return $app->json($t->getIntercambiosUsers($id,$id_comercio));
});

$app->get('/get/datos_generales', function() use($app) {
    $m = new Model\Monedas; 
  
    return $app->json($m->datosGenerales());   
});

$app->get('/get/datos_generales_usuario', function() use($app) {
    $u = new Model\Users; 
  
    return $app->json($u->datosGenerales());   
});

<<<<<<< HEAD
$app->get('/get/transaccion_en_espera/{id}', function($id) use($app) {
    $t = new Model\Transaccion; 
  
    return $app->json($t->getTransaccionEnEspera($id));   
=======
$app->get('/get/monedas/BySucursal/{id}', function($id) use($app) {
    $m = new Model\Monedas; 
  
    $inner = "INNER JOIN sucursal s ON s.id_sucursal='$id'
              INNER JOIN user_moneda um ON um.id_usuario=s.id_user and um.codigo_moneda=moneda.codigo";

    return $app->json($m->getMonedas('*',$inner));   
>>>>>>> comprayventa
});