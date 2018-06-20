<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/20/18
 * Time: 23:30
 */

namespace App\Controller;

use App\Entity\Team;
use App\Service\CRUDHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/team")
 * Class TeamController
 * @package App\Controller
 */
class TeamController extends Controller
{
    /**
     * @Route(path="/create", name="team_create", methods={"POST"})
     *
     * @param Request $request
     * @param CRUDHelper $helper
     * @return JsonResponse
     * @throws \App\Exception\EntityInvalidException
     * @throws \ReflectionException
     */
    public function create(Request $request, CRUDHelper $helper): JsonResponse
    {
        $helper->create(Team::class, $request->request->all());

        return new JsonResponse(['status' => 'ok', 'message' => 'created']);
    }

    /**
     * @Route(path="/update/{id}", name="team_update", methods={"PUT"})
     *
     * @param Request $request
     * @param CRUDHelper $helper
     * @param int $id
     * @return JsonResponse
     * @throws \App\Exception\EntityInvalidException
     * @throws \ReflectionException
     */
    public function edit(Request $request, CRUDHelper $helper, int $id): JsonResponse
    {
        $helper->edit($id,Team::class, $request->request->all());

        return new JsonResponse(['status' => 'ok', 'message' => 'updated']);
    }
}