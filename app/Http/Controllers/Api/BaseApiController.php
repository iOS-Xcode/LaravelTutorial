<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseApiController extends Controller
{
    public function __construct() {
    	//컴트럴러의 기본 드리아버를 api로 설정.
		auth()->setDefaultDriver('api');
	}
}
