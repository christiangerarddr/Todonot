<?php

namespace App\Http\Controllers;

use App\Http\Responses\ResponseInterface;
use App\Services\TodoServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TodoController
{
    protected ResponseInterface $response;

    protected TodoServiceInterface $todoService;

    public function __construct(ResponseInterface $response, TodoServiceInterface $todoService)
    {
        $this->response = $response;
        $this->todoService = $todoService;
    }

    /**
     * Renders Todos page and returns initial todos collection
     */
    public function index(): Response
    {
        $todos = $this->todoService->getAllTodos([], true, 6);

        return Inertia::render('Todo', ['todos' => $todos]);
    }

    /**
     * Lists and filters todos
     */
    public function listTodos(): JsonResponse
    {
        $todos = $this->todoService->getAllTodos([], true, 6);

        return $this->response->json($todos);
    }

    public function update(Request $request, string $id)
    {
        return $this->response->json($this->todoService->updateTodo($id, $request->todo));
    }

    public function destroy($id)
    {
        return $this->response->success($this->todoService->deleteTodo($id));
    }
}
