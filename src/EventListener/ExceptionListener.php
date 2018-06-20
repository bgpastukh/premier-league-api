<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/21/18
 * Time: 02:27
 */

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ExceptionListener
 * @package App\EventListener
 */
class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $message = $exception->getMessage();
        $response = new JsonResponse(['status' => 'failed', 'message' => $message]);

        $event->setResponse($response);
    }
}