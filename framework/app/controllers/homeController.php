<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

namespace app\controllers;

use app\models as Model;
use Ocrend\Kernel\Helpers as Helper;
use Ocrend\Kernel\Controllers\Controllers;
use Ocrend\Kernel\Controllers\IControllers;
use Ocrend\Kernel\Router\IRouter;
use Ocrend\Kernel\Helpers\Functions;

/**
 * Controlador home/
 *
 * @author Ocrend Software C.A <bnarvaez@ocrend.com>
*/
class homeController extends Controllers implements IControllers {

    public function __construct(IRouter $router) {
        parent::__construct($router,array(
            'users_logged' => true
        ));
      
        $d = new Model\Dashboard;
        $o = new Model\Orden;
        $u = new Model\Users;
        $di = new Model\Divisa;

        #Trae al usuario logeado
        $owner_user = $u->getOwnerUser();

        #Si el usuario logeado es un supervisor de un comercio afiliado
        $ordenes = false;
        if($owner_user["tipo"] == 3 and $owner_user["id_comercio_afiliado"]!=null){
            $ordenes = $o->getOrdenesComerciosAfiliados($owner_user["id_comercio_afiliado"]);
        }

        #Si el usuario logeado es un admin
        if($owner_user["tipo"] == 0 ){
            $ordenes = $o->getOrdenesComerciosAfiliados();
        }

        $ordenes_de_comercios = false;
        $this->template->display('home/home',array(
            'data'=> $d->getData(),
            'clientes'=> $u->getUsers('*','tipo=2'),
            'ordenes' => $ordenes,
            'precio_oro' => ($di->getDivisas("precio_dolares","nombre_divisa='Oro Franklin'"))[0]["precio_dolares"],
            'precio_plata' => ($di->getDivisas("precio_dolares","nombre_divisa='Plata Franklin'"))[0]["precio_dolares"],
            'precio_bolivar' => ($di->getDivisas("precio_dolares","nombre_divisa='Bolívar Soberano'"))[0]["precio_dolares"]
        ));
    }
}