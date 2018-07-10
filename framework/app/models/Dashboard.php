<?php

/*
 * This file is part of the Ocrend Framewok 3 package.
 *
 * (c) Ocrend Software <info@ocrend.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace app\models;

use app\models as Model;
use Ocrend\Kernel\Helpers as Helper;
use Ocrend\Kernel\Models\Models;
use Ocrend\Kernel\Models\IModels;
use Ocrend\Kernel\Models\ModelsException;
use Ocrend\Kernel\Models\Traits\DBModel;
use Ocrend\Kernel\Router\IRouter;

/**
 * Modelo Dashboard
 */
class Dashboard extends Models implements IModels {
    use DBModel;

    /**
     * Respuesta generada por defecto para el endpoint
     * 
     * @return array
    */ 
    public function getData() : array {
        $tiempo = time();

        $ventas_diarias = $this->db->select("COUNT(id_transaccion) as total",'transaccion',null,
        "tipo = 1 AND fecha > ($tiempo - 86400) AND fecha <= $tiempo");

        $ventas_mensuales = $this->db->select("COUNT(id_transaccion) as total",'transaccion',null,
        "tipo = 1 AND fecha > ($tiempo - 2416200) AND fecha <= $tiempo");

        $ventas_anuales = $this->db->select("COUNT(id_transaccion) as total",'transaccion',null,
        "tipo = 1 AND fecha > ($tiempo - 29030400) AND fecha <= $tiempo");

        $usuarios = $this->db->select("COUNT(id_user) as total",'users');


        dump($ventas_diarias);
        $ventas_diarias = $ventas_diarias == false?array():$ventas_diarias;

        return array(
            'diarias' => $ventas_diarias[0],
            'mensuales' => $ventas_mensuales[0],
            'anuales' => $ventas_anuales[0],
            'usuarios' => $usuarios[0]
        );
    }


    /**
     * __construct()
    */
    public function __construct(IRouter $router = null) {
        parent::__construct($router);
		$this->startDBConexion();
    }
}