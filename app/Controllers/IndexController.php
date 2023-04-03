<?php

namespace App\Controllers;

use App\JsonResponse;
use App\Response;

class IndexController extends BaseController
{
    public function indexAction(): Response
    {
        return new Response(implode(", ", $this->request->getParams()));
    }

    public function indexJsonAction(): JsonResponse
    {
        return new JsonResponse($this->request->getParams());
    }
}