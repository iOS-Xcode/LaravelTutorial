<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="3.3.6",
 *      title="Kim's Project",
 *      description="api document tutorial",
 *      @OA\Contact(
 *          email="wjapp72@email.com"
 *      ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

/**
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_TEST_HOST,
 *      description="테스트 서버"
 *  )
 *
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_REAL_HOST,
 *      description="실전 서버"
 *  )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
