<?php

namespace App\Controllers;

use App\HtmlResponse;
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

    public function twigAction(): HtmlResponse
    {
        return new HtmlResponse('response.html.twig',['request' => $this->request->getParams()]);
    }
}