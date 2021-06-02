<?php

namespace Juancrrn\Carrier\Common\Api;

abstract class ApiModel
{

    abstract public function consume(object $requestContent): void;
}