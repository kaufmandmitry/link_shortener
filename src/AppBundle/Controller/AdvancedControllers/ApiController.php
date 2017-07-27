<?php
namespace AppBundle\Controller\AdvancedControllers;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ApiController extends Controller
{

    /**
     * Render data
     *
     * @param array $data
     *
     * @return Response
     */
    public function renderData($data = [])
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ];
        $body = [
            'success' => true,
            'data' => $data
        ];
        return new Response(json_encode($body), 200, $headers);
    }

    /**
     * Render error
     *
     * @param integer $code
     * @param string $message
     *
     * @return Response
     */
    public function renderError($code, $message)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ];
        $body = [
            'success' => false,
            'error' => [
                'code' => $code,
                'message' => $message,
            ]
        ];
        return new Response(json_encode($body), 200, $headers);
    }

    /**
     * Show exception
     *
     * @param FlattenException $exception
     *
     * @param DebugLoggerInterface $logger
     *
     * @return Response
     */
    public function showExceptionAction($exception, $logger)
    {

        $headers = [
            'Content-Type' => 'application/json',
            'Access-Control-Allow-Origin' => '*'
        ];
        $statusCode = $exception->getStatusCode();
        $message = $exception->getMessage();

        $body = [
            'success' => false,
            'error' => [
                'code' => $statusCode,
                'message' => $message,
            ]
        ];
        return new Response(json_encode($body), 200, $headers);
    }
}