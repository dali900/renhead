<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Respons with JSON data
     *
     * @param array $data
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseJSON(array $data = [], int $code = 200)
    {
        return response()->json($data, $code);
    }

    /**
     * Validation error response
     *
     * @param array $errors
     * @param string $msg
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseValidationError(array $errors = [], string $msg = "Validation error", int $code = 422)
    {
        return $this->responseValidationErrorMsg($msg, $errors, $code);
    }

    /**
     * Validation error with message
     *
     * @param array $errors = []
     * @param string $msg = 'Error'
     * @param integer $code = 500
     * @return \Illuminate\Http\Response
     */
    public function responseValidationErrorMsg(string $msg = "Validation error", array $errors = [], int $code = 422)
    {
        $data = [
            "status" => "Invalid data",
            "success" => false,
            "message" => $msg,
            "errors" => $errors
        ];

        return response()->json($data, $code);
    }

    /**
     * Forbidden response
     *
     * @param array $errors
     * @param string $msg
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseForbidden(string $msg = "Forbidden", int $code = Response::HTTP_FORBIDDEN)
    {
        $data = [
            "status" => "Forbidden",
            "success" => false,
            "message" => $msg,
        ];

        return response()->json($data, $code);
    }

    /**
     * Resource not found respons 
     *
     * @param string $msg
     * @param array $errors
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseNotFound(array $errors = [], string $msg = "Resource not found", int $code = 404)
    {
        return $this->responseNotFoundMsg($msg, $errors, $code);
    }

    /**
     * Resource not found respons with message
     *
     * @param array $errors = []
     * @param string $msg
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseNotFoundMsg(string $msg = "Resource not found", array $errors = [], int $code = 404)
    {
        $data = [
            "status" => "Not found",
            "success" => false,
            "message" => $msg,
            "errors" => $errors
        ];

        return response()->json($data, $code);
    }

    /**
     * error respons 
     *
     * @param array $errors = []
     * @param string $msg = 'Error'
     * @param integer $code = 500
     * @return \Illuminate\Http\Response
     */
    public function responseError(array $errors = [], string $msg = "Server error", int $code = 500)
    {
        return $this->responseErrorMsg($msg, $errors, $code);
    }

    /**
     * error with msg
     *
     * @param array $errors = []
     * @param string $msg = 'Error'
     * @param integer $code = 500
     * @return \Illuminate\Http\Response
     */
    public function responseErrorMsg(string $msg = "Error", array $errors = [], int $code = 500)
    {
        $data = [
            "status" => "Error",
            "success" => false,
            "message" => $msg,
            "errors" => $errors
        ];

        return response()->json($data, $code);
    }

    /**
     * Creating model error response
     *
     * @param string $msg
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseErrorCreatingModel(string $msg = "Error while creating model.", int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $data = [
            "status" => "Server error",
            "success" => false,
            "message" => $msg,
        ];

        return response()->json($data, $code);
    }

    /**
     * Saving model error response
     *
     * @param string $msg
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseErrorSavingModel(string $msg = "Error while saving model.", int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $data = [
            "status" => "Server error",
            "success" => false,
            "message" => $msg,
        ];

        return response()->json($data, $code);
    }

    /**
     * Delete model error response
     *
     * @param string $msg
     * @param integer $code
     * @return \Illuminate\Http\Response
     */
    public function responseErrorDeletingModel(string $msg = "Error while deleting model.", int $code = Response::HTTP_INTERNAL_SERVER_ERROR)
    {
        $data = [
            "status" => "Server error",
            "success" => false,
            "message" => $msg,
        ];

        return response()->json($data, $code);
    }

    /**
     * Unauthenticated response with message
     *
     * @param array $errors = []
     * @param string $msg = 'Error'
     * @param integer $code = 500
     * @return \Illuminate\Http\Response
     */
    public function responseUnauthenticated($msg = "Unauthenticated", $code = 401)
    {
        $data = [
            "status" => "Unauthenticated",
            "success" => false,
            "message" => $msg
        ];

        return response()->json($data, $code);
    }

    /**
     * Success response
     *
     * @param array $attributes = []
     * @param string $msg = 'Success'
     * @param integer $code = 200
     * @return \Illuminate\Http\Response
     */
    public function responseSuccess($data = [], $msg = "Success", $code = 200)
    {
        return $this->responseSuccessMsg($msg, $data, $code);
    }

    /**
     * Success response message
     *
     * @param array $attributes = []
     * @param string $msg = 'Success'
     * @param integer $code = 200
     * @return \Illuminate\Http\Response
     */
    public function responseSuccessMsg($msg = "Success", $data = [], $code = 200)
    {
        $data = [
            "status" => "Ok",
            "success" => true,
            "message" => $msg,
            "data" => $data
        ];

        return response()->json($data, $code);
    }
}
