<?php

namespace App\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

trait PublicJsonResponse
{
    public function messageResponse($message, $code = 406, $success = false , $inModal = false)
    {
        $finalMessage = [
            "id"      => "all",
            "content" => $message
        ];

        $responseParam = [
            "success" => $success,
            "code"    => $code,
            "in_modal"    => $inModal,
            "data"    => [
                "has_paginate" => 0,
                "results"      => [],
            ],
            "message" => [$finalMessage]
        ];

        return response()->json($responseParam, $code);
    }

    public function dataResponse($message, $data,$code = 200 ,$inModal = false)
    {
        if (is_null($data)) {
            $data = [];
        } else {
            if ($data instanceof Collection) {
                $data = $data->toArray();
            }
            else {
                if(is_array($data)) {
                    if(!empty($data)) {
                        $data =  [$data];
                    }
                }elseif($data instanceof JsonResource){
                    $data =   [$data];
                }
                else {
                    $data =   [$data->toArray()];
                }
            }
        }

        $data = [
            "has_paginate" => 0,
            "results"      => $data,
        ];
        $responseParam = [
            "success" => true,
            "code"    => $code,
            "in_modal"    => $inModal,
            "data"    => $data,
            "message" => [
                [
                    "id"      => "all",
                    "content" => $message
                ]
            ]
        ];

        return response()->json($responseParam);
    }

    public function successResponse($data = [], $message = '' , $inModal = false): \Illuminate\Http\JsonResponse
    {
        $data = $this->parseData($data);

        $responseParam = [
            "success"       => true,
            "code"          => 200,
            "in_modal"      => $inModal,
            "data"          => $data,
            "message"       => [
                [
                    "id"      => "all",
                    "content" => $message
                ]
            ]
        ];
        return response()->json($responseParam);
    }

}
