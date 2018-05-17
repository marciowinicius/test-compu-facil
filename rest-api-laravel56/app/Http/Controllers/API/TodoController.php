<?php

namespace App\Http\Controllers\API;

use App\Services\TodoServices;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Todo;
use Validator;

class TodoController extends BaseController
{
    /**
     * @var
     */
    protected $todoService;

    public function __construct(TodoServices $todoServices)
    {
        $this->todoService = $todoServices;
        $this->middleware('auth:api', ['except' => ['index', 'store', 'show']]);
    }

    /**
     * @SWG\Get(
     *     path="/todos",
     *     summary="To do list",
     *     tags={"Todo"},
     *     @SWG\Response(response="200", description="Return todo data ordered by sort_order",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="status", type="string", example="success"),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(property="uuid", type="string", example="opiasopiads019209"),
     *                 @SWG\Property(property="type", type="string", example="shopping"),
     *                 @SWG\Property(property="content", type="string", example="Teste aleea"),
     *                 @SWG\Property(property="sort_order", type="integer", example="1"),
     *                 @SWG\Property(property="done", type="integer", example="0"),
     *             ),
     *             @SWG\Property(property="message", type="string", example=""),
     *          ),
     *     ),
     * )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = Todo::orderBy('sort_order', 'DESC')->get();
        if (empty($todos->toArray())) {
            return $this->sendResponse($todos->toArray(), 'Wow. You have nothing else to do. Enjoy the rest of your day!');
        }
        return $this->sendResponse($todos->toArray(), 'Retrieved successfully.');
    }

    /**
     * @SWG\Post(
     *     path="/todos",
     *     summary="Create a new task",
     *     tags={"Todo"},
     *     @SWG\Parameter(
     *         name="type",
     *         in="formData",
     *         description="Type of the task",
     *         required=true,
     *         type="string",
     *         enum={"shopping","work"},
     *     ),
     *     @SWG\Parameter(
     *         name="content",
     *         in="formData",
     *         description="Description of the task",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="sort_order",
     *         in="formData",
     *         description="The priority of the task",
     *         required=false,
     *         type="integer"
     *     ),
     *     @SWG\Response(response="200", description="Return todo data",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="status", type="string", example="success"),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(property="uuid", type="string", example="opiasopiads019209"),
     *                 @SWG\Property(property="type", type="string", example="shopping"),
     *                 @SWG\Property(property="content", type="string", example="Teste aleea"),
     *                 @SWG\Property(property="sort_order", type="integer", example="1"),
     *                 @SWG\Property(property="done", type="integer", example="0"),
     *             ),
     *             @SWG\Property(property="message", type="string", example=""),
     *          ),
     *     ),
     * )
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = $this->todoService->validation($input);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $todo = Todo::create($input);

        return $this->sendResponse($todo->toArray(), 'Created successfully.');
    }

    /**
     * @SWG\Get(
     *     path="/todos/{uuid}",
     *     summary="Details of task",
     *     tags={"Todo"},
     *     @SWG\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The uuid of the task",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(response="200", description="Return todo data",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="status", type="string", example="success"),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(property="uuid", type="string", example="opiasopiads019209"),
     *                 @SWG\Property(property="type", type="string", example="shopping"),
     *                 @SWG\Property(property="content", type="string", example="Teste aleea"),
     *                 @SWG\Property(property="sort_order", type="integer", example="1"),
     *                 @SWG\Property(property="done", type="integer", example="0"),
     *             ),
     *             @SWG\Property(property="message", type="string", example=""),
     *          ),
     *     ),
     * )
     */
    /**
     * @param $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $todo = Todo::find($uuid);

        if (is_null($todo)) {
            return $this->sendError('Todo not found.');
        }

        return $this->sendResponse($todo->toArray(), 'Retrieved successfully.');
    }

    /**
     * @SWG\Put(
     *     path="/todos/{uuid}",
     *     summary="Update a task",
     *     tags={"Todo"},
     *     security={
     *          {"default": {}},
     *      },
     *     @SWG\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The uuid of the task",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="type",
     *         in="formData",
     *         description="Type of the task",
     *         required=true,
     *         type="string",
     *         enum={"shopping","work"},
     *     ),
     *     @SWG\Parameter(
     *         name="content",
     *         in="formData",
     *         description="Description of the task",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Parameter(
     *         name="sort_order",
     *         in="formData",
     *         description="The priority of the task",
     *         required=false,
     *         type="integer"
     *     ),
     *     @SWG\Parameter(
     *         name="done",
     *         in="formData",
     *         description="If the task is done or not",
     *         required=false,
     *         type="boolean"
     *     ),
     *     @SWG\Response(response="200", description="Return todo data",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="status", type="string", example="success"),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(property="uuid", type="string", example="opiasopiads019209"),
     *                 @SWG\Property(property="type", type="string", example="shopping"),
     *                 @SWG\Property(property="content", type="string", example="Teste aleea"),
     *                 @SWG\Property(property="sort_order", type="integer", example="1"),
     *                 @SWG\Property(property="done", type="integer", example="0"),
     *             ),
     *             @SWG\Property(property="message", type="string", example=""),
     *          ),
     *     ),
     * )
     */
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {
        $input = $request->all();
        $input['done'] = $input['done'] == 'true' ? TRUE : FALSE;

        $validator = $this->todoService->validation($input);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $todo = Todo::find($uuid);

        if (is_null($todo)) {
            return $this->sendError("Are you a hacker or something? The task you were trying to edit doesn't exist.");
        }

        $todo->fill($input);
        $todo->update();

        return $this->sendResponse($todo->toArray(), 'Updated successfully.');
    }

    /**
     * @SWG\Delete(
     *     path="/todos/{uuid}",
     *     summary="Delete a task",
     *     tags={"Todo"},
     *     security={
     *          {"default": {}},
     *      },
     *     @SWG\Parameter(
     *         name="uuid",
     *         in="path",
     *         description="The uuid of the task",
     *         required=true,
     *         type="string"
     *     ),
     *     @SWG\Response(response="200", description="Return todo data deleted",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="status", type="string", example="success"),
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(property="uuid", type="string", example="opiasopiads019209"),
     *                 @SWG\Property(property="type", type="string", example="shopping"),
     *                 @SWG\Property(property="content", type="string", example="Teste aleea"),
     *                 @SWG\Property(property="sort_order", type="integer", example="1"),
     *                 @SWG\Property(property="done", type="integer", example="0"),
     *             ),
     *             @SWG\Property(property="message", type="string", example=""),
     *          ),
     *     ),
     * )
     */
    /**
     * @param $uid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid)
    {
        $todo = Todo::find($uid);
        if (is_null($todo)) {
            return $this->sendResponse([], "Good news! The task you were trying to delete didn't even exist.");
        }
        $todo->delete();

        return $this->sendResponse($todo->toArray(), 'Deleted successfully.');
    }
}