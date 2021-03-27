<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Todo
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends BaseApiController
{
    public function __construct() {
        parent::__construct();
                // 미들웨어 설정
        // login 이랑 register 메소드를 할때는 JWT 미들웨어를 생략 한다. 즉 토큰이 없어도 된다.
        $this->middleware('JWT', ['except' => []]);
    }
    
    /**
     * @OA\Get(
     *      path="/todos",
     *      operationId="getTodosList",
     *      tags={"할 일 관련"},
     *      summary="모든 할 일 목록 가져오기",
     *      description="모든 할 일 목록을 가져온다.",
     *      @OA\Response(
     *          response=200,
     *          description="응답 성공"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //데이타 목록 가져 오기
    public function index()
    {
        //
        $allTodos = Todo::all();
        //$allTodos = Todo::select('id', 'title', 'content')->get();
        $filteredTodos = TodoResource::collection($allTodos);
        return $filteredTodos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //새 데이타를 만드는 화면 반환, API에는 필요 없음
    public function create()
    {
        //
    }

    /** @OA\Post(
     *      path="/todos",
     *      operationId="storeTodo",
     *      tags={"할 일 관련"},
     *      summary="할 일 추가하기",
     *      description="할 일을 추가하고 할 일을 반환한다.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TodoRequest")
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="응답 성공, created new file",
     *          @OA\JsonContent(ref="#/components/schemas/Todo")
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //새 데이타 추가, 룰을 적용
    public function store(TodoRequest $request)
    {
        //
        $userInputData = $request->all();
        $newTodo = Todo::create($userInputData);
        return new TodoResource($newTodo);
    }

    /** @OA\Get(
     *      path="/todos/{id}",
     *      operationId="getTodoById",
     *      tags={"할 일 관련"},
     *      summary="특정 할 일 가져오기",
     *      description="특정 할 일 목록을 가져온다.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Todo_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="응답 성공",
     *          @OA\JsonContent(ref="#/components/schemas/Todo")
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //특정 데이타 가져 오기
    public function show($id)
    // 아래와 같이 사용도 가능. 기본적으로 해당 모델의 id로 찾게 됨 id가 fetchedTodo 임.
    //    public function show(Todo $fetchedTodo)
    {
        //find는 쿼리문 select * from todos where id = 2
        $fetchedTodo = Todo::find($id);
        //Resource 로 감싸면 data 어레이가 root 가 됨.
        $filteredTodo = new TodoResource($fetchedTodo);
        return $filteredTodo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //기존 데이타를 수정하는 화면을 반환
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /** @OA\Put(
     *      path="/todos/{id}",
     *      operationId="updateTodo",
     *      tags={"할 일 관련"},
     *      summary="기존 할 일 추가하기",
     *      description="기존 할 일을 추가하고 수정된 할 일을 반환한다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="Todo_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TodoRequest")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="응답 성공",
     *          @OA\JsonContent(ref="#/components/schemas/Todo")
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    //1.룰을 적용함. Request.php
        //기존 데이터를 수정해서 -> 수정된 데이타 반환
    //public function update(TodoRequest $request, $id)
    //2.아래와 같이 사용 가능.
    public function update(TodoRequest $request, Todo $todo)
    // 단 Api 의 Route::put('/todos/{id}', [TodoController::class, 'update']);
    //부분의 id를 todo로 수정해야 함.
    //todo 변수의 이름은 api의 todo 이름과 같아야 함.

    {
        //$fetchedTodo = Todo::find($id);
        $todo->update($request->all());

        $updatedTodo = new TodoResource($todo);
        return $updatedTodo;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     /** @OA\Delete(
     *      path="/todos/{id}",
     *      operationId="deleteTodo",
     *      tags={"할 일 관련"},
     *      summary="기존 할 일 삭제하기",
     *      description="기존 할 일을 삭제한다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="Todo_id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=204,
     *          description="NO_CONTENT",
     *          @OA\JsonContent(ref="#/components/schemas/Todo")
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    //기존 데이타를 삭제
    public function destroy($id)
    {
        $fetchedTodo = Todo::find($id);
        $fetchedTodo->delete();
        return response( content: null, status: Response::HTTP_NO_CONTENT);
    }
}
