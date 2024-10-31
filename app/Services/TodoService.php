<?php

namespace App\Services;

use App\Models\Todo;
use Exception;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class TodoService implements TodoServiceInterface
{
    /**
     * @throws Exception
     */
    public function getAllTodos(array $filters = [], bool $paginate = false, int $perPage = 10): Collection|Paginator
    {
        $query = Todo::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $paginate ? $query->paginate($perPage) : $query->get();

    }

    /**
     * @throws Exception
     */
    public function getTodo(int $id): Todo
    {
        return Todo::query()->findOrFail($id);
    }

    /**
     * These operations try to create a record
     * if something went wrong it will roll back the transaction
     *
     * @throws Exception
     */
    public function createTodo(array $data): Todo
    {
        DB::beginTransaction();
        try {
            $todo = Todo::query()->create($data);
            DB::commit();

            return $todo;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @throws Throwable
     */
    public function updateTodo($id, array $data): Todo
    {
        DB::beginTransaction();
        try {
            $todo = self::getTodo($id);
            $todo->updateOrFail($data);
            DB::commit();

            return $todo->refresh();
        } catch (Exception|Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @throws Exception
     */
    public function deleteTodo($id): bool
    {
        DB::beginTransaction();
        try {
            $todo = self::getTodo($id);
            $deleted = $todo->delete();
            DB::commit();

            return $deleted;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
