<?php
/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     host=API_HOST,
 *     basePath="/",
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Laravel and Swagger",
 *         description="Getting started with Laravel and Swagger",
 *         termsOfService="",
 *         @SWG\Contact(
 *             "url"= "https://github.com/gmatheus66",
 *         ),
 *     ),
 * )
 * @OA\Info(
 *      version="1.0.0",
 *      title="L5 OpenApi",
 *      description="Api para criaçao e gerenciamento de prontuarios, juntamente com analise de batimentos cardiacos"
 * )
 * @OA\Get(
 *     path="/",
 *     description="Home page",
 *     @OA\Response(response="default", description="Welcome page")
 * )
 */
