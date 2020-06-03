<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="SIMC Documentation",
     *      description="Api para criaçao e gerenciamento de prontuarios, juntamente com analise de batimentos cardiacos",
     *      @OA\Contact(
     *          url="https://github.com/gmatheus66",
     *      ),
     *      @OA\License(
     *          name="License: MIT",
     *      )
     * )
     *
     * @OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Demo API Server"
     * )

     *
     * @OA\Tag(
     *     name="Simc Projects",
     *     description="API Endpoints of Simc Projects"
     * )
     *  @OA\Get(
     *     path="/",
     *     description="Home page",
     *     @OA\Response(response="default", description="Welcome page")
     * )
    */
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
