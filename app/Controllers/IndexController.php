<?php

namespace App\Controllers;

use App\HtmlResponse;
use App\JsonResponse;
use App\Response;
use App\Connection;

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

    public function getUser(): JsonResponse
    {
        return new JsonResponse(Connection::getInstance()
            ->fetchAssoc('SELECT * FROM users WHERE id=:user_id', $this->request->getAttributes()));
    }

    public function getUsers(): JsonResponse
    {
        if(array_key_exists('limit', $this->request->getParams()['limit']))
            $limit = $this->request->getParams()['limit'];
        else
        {
            $limit = null;
        }
        return new JsonResponse(Connection::getInstance()
            ->fetchAssocAll('SELECT * FROM users', [], $limit));
    }
}