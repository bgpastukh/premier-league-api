<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/21/18
 * Time: 00:31
 */

namespace App\EventListener;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class RequestListener
 * @package App\EventListener
 */
class RequestListener
{
    /**
     * Transform request json content to associative array
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (!$this->isJsonRequest($request)) {
            return;
        }

        if (empty($request->getContent())) {
            return;
        }

        $decodedRequest = $this->transformRequest($request);

        if ($decodedRequest) {
            $request->request->replace($decodedRequest);
        }
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isJsonRequest(Request $request): bool
    {
        return 'json' === $request->getContentType();
    }

    /**
     * @param Request $request
     * @return array|null
     */
    private function transformRequest(Request $request): ?array
    {
        $request = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        return $request;
    }
}