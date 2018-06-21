<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/20/18
 * Time: 23:20
 */

namespace App\Controller;

use App\Entity\League;
use App\Service\CRUDHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/api/league")
 *
 * Class LeagueController
 * @package App\Controller
 */
class LeagueController extends Controller
{
    /**
     * @Route(path="/show/{id}", name="league_show", methods={"GET"})
     *
     * @param int $id
     * @param CRUDHelper $helper
     * @return JsonResponse
     */
    public function show(int $id, CRUDHelper $helper): JsonResponse
    {
        return new JsonResponse($helper->show($id, League::class, ['groups' => [League::GROUP_SHOW_LEAGUE]]));
    }

    /**
     * @Route(path="/delete/{id}", name="league_delete", methods={"DELETE"})
     *
     * @param int $id
     * @param CRUDHelper $helper
     * @return JsonResponse
     */
    public function delete(int $id, CRUDHelper $helper)
    {
        $helper->delete($id, League::class);

        return new JsonResponse(['status' => 'ok', 'message' => 'deleted']);
    }
}