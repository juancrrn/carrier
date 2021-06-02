<?php

namespace Juancrrn\Carrier\Common\Controller;

/**
 * Modelo para grupos de rutas a usar por el controlador
 * 
 * @package carrier
 *
 * @author juancrrn
 *
 * @version 0.0.1
 */

interface RouteGroupModel
{

    public function runAll(): void;
}