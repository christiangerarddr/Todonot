<?php

namespace Tests\Unit;

use App\Models\Todo;
use App\Services\TodoService;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TodoServiceTest extends TestCase
{
    use RefreshDatabase;

    protected TodoService $todoService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->todoService = new TodoService;
    }

    public function testGetAllTodosReturnsCollectionOrPaginator()
    {
        Todo::factory()->count(5)->create(['status' => 0]);

        $result = $this->todoService->getAllTodos(['status' => 0], true);
        $this->assertInstanceOf(Paginator::class, $result);

        $result = $this->todoService->getAllTodos(['status' => 0]);
        $this->assertInstanceOf(Collection::class, $result);

        $this->assertCount(5, $result);
    }

    public function testGetTodoReturnsTodo()
    {
        $todo = Todo::factory()->create(['title' => 'Todo']);

        $todo = $this->todoService->getTodo($todo->id);

        $this->assertInstanceOf(Todo::class, $todo);
        $this->assertEquals('Todo', $todo->title);
    }

    public function testCreateTodoReturnsTodo()
    {
        $data = [
            'title' => 'New Todo',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
            'status' => 'pending',
        ];

        $todo = $this->todoService->createTodo($data);

        $this->assertInstanceOf(Todo::class, $todo);
        $this->assertEquals('New Todo', $todo->title);
    }

    public function testUpdateTodoReturnsTodo()
    {
        $todo = Todo::factory()->create(['title' => 'Old Title']);

        $data = [
            'title' => 'New Todo',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
            'status' => 'pending',
        ];

        $todo = $this->todoService->updateTodo($todo->id, $data);

        $this->assertInstanceOf(Todo::class, $todo);
        $this->assertEquals('New Todo', $todo->title);
    }

    public function testDeleteTodoReturnsBoolean()
    {
        $todo = Todo::factory()->create();

        $deleted = $this->todoService->deleteTodo($todo->id);

        $this->assertTrue($deleted);
        $this->assertNull(Todo::query()->find($todo->id)); // Ensure it's deleted
    }
}
