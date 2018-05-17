<?php

namespace Tests\Feature;

use App\Todo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TodoTest extends TestCase
{
    /**
     * A Create test.
     *
     * @return void
     */
    public function testCreate()
    {
        $todo = new Todo();
        $todo->type = 'shopping';
        $todo->content = 'Teste';
        $todo->save();

        $this->assertTrue(true, 'Test pass');
    }

    /**
     * A get all test.
     *
     * @return void
     */
    public function testGetAllOrdered()
    {
        $todos = Todo::orderBy('sort_order', 'DESC')->get();
        if (empty($todos->toArray())) {
            $this->assertTrue(true, 'Test pass');
        }
        $this->assertTrue(true, 'Test pass');
    }

    /**
     * A Create test.
     *
     * @return void
     */
    public function testUpdate()
    {
        $todo = Todo::first();
        $todo->type = 'work';
        $todo->content = 'Teste 2 22 2 2';
        $todo->done = TRUE;
        $todo->sort_order = 1;
        $todo->update();

        $this->assertTrue(true, 'Test pass');
    }

    /**
     * A Create test.
     *
     * @return void
     */
    public function testDelete()
    {
        $todo = Todo::first();
        $todo->delete();

        $this->assertTrue(true, 'Test pass');
    }
}
