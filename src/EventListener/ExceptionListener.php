<?php

namespace App\EventListener;

use App\Service\ServiceException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof ServiceException) {
            assert($exception instanceof  ServiceException);
            $exceptionData = $exception->getExceptionData();

        }
        $response = new JsonResponse(isset($exceptionData) ? $exceptionData->toArray() : ['error' => $exception->getMessage(), 'file' => $exception->getFile(), 'line' => $exception->getLine()]);
        if ($exception instanceof HttpExceptionInterface) {
        $response->setStatusCode($exception->getStatusCode());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}