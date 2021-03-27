<?php

namespace App\Http\Controllers\Api\Auth;
//"message": "Class \"\\App\\Models\\User\"
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\RegisterRequest;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JWTAuthController extends BaseApiController
{
	public function __construct() {
		// 부모 클래스에서 설정한 생성자 메소드를 호출한다.
		parent::__construct();

		// 미들웨어 설정
        // login 이랑 register 메소드를 할때는 JWT 미들웨어를 생략 한다. 즉 토큰이 없어도 된다.
        $this->middleware('JWT', ['except' => ['login', 'register']]);
//        $this->middleware('JWT', ['except' => ['register']]);
	}

    public function login(Request $request){
    	//사용자가 입력한 정보
    	$credentials = request(['email', 'password']);
    	//입력된 정보로 토큰 값을 가져온다.
    	$token = auth()->attempt($credentials);

    	//dd($token);

    	if(!$token) {
    		//로그인한 사용자가 인증되지 않았으묜 401에러 보내주기.
    		return response()->json(['error' => 'Unauthorized'], RESPONSE::HTTP_UNAUTHORIZED);
    	}

    	//return response()->json(['access_token' => $token]);
    	return $this->respondWithToken($token);

    }

        // 토큰 반환 형식을 만들어 준다.
    protected function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //토큰 만료시간
           // 'expires_in' => auth()->factory()->getTTL() * 60,
            // 'expires_in' => auth()->factory()->getTTL(),
            'expires_in' => auth('api')->factory()->getTTL() * 60,

            'current_user' => auth()->user()
        ]);
    }

    //회원가입
    public function register(RegisterRequest $request) {
    	//새로운 사용자 만들기
    	$newUser = User::create($request->all());

    	//dd($newUser);

    	//방금 생성한 사용자로 로그인 한다.
    	return $this->login($request);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
}
