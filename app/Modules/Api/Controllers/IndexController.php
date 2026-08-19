<?php

namespace App\Modules\Api\Controllers;

use Phalcon\Http\ResponseInterface;

class IndexController extends AbstractController
{
    public function indexAction(): ResponseInterface
    {
        return $this->setRestResponse([]);
    }
}
