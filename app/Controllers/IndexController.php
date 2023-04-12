<?php

namespace App\Controllers;

use App\Models\Blog;
use App\Models\User;
use Core\BaseController;
use Core\Connection;
use Core\Responses\HtmlResponse;
use Core\Responses\JsonResponse;
use Core\Responses\Response;

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
        return new HtmlResponse('response.html.twig', ['request' => $this->request->getParams()]);
    }

    public function getUser(): JsonResponse
    {
        return new JsonResponse(User::find($this->request->getAttributes()['user_id'])->toArray());
    }

    public function getUsers(): JsonResponse
    {
        $limit = array_key_exists('limit', $this->request->getParams()) ? $this->request->getParams()['limit'] : null;
        return new JsonResponse(Connection::getInstance()
            ->fetchAssocAll('SELECT * FROM users', [], $limit));
    }
}