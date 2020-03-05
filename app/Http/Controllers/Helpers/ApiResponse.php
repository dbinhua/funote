<?php
namespace App\Http\Controllers\Helpers;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use Illuminate\Support\Facades\Response;

trait ApiResponse
{
    protected $code = FoundationResponse::HTTP_OK;

    public function response(array $data = [], string $msg = '')
    {
        $res = ['code' => $this->code];

        if ($this->code == FoundationResponse::HTTP_OK){
            $data && $res['data'] = $data;
        }else{
            $res['msg'] = $msg;
        }

        return Response::json($res, $this->code);
    }

    /*
     * 格式
     * data:
     *  code:422
     *  message:xxx
     *  status:'error'
     */
    public function failed(string $msg = 'failed', int $code = FoundationResponse::HTTP_BAD_REQUEST)
    {
        $this->code = $code;
        return $this->response([], $msg);
    }

    /**
     * @param $data
     * @param string $status
     * @return mixed
     */
    public function success(array $data = [])
    {
        return $this->response($data);
    }
}
