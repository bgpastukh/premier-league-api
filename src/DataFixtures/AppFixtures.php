<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/20/18
 * Time: 22:56
 */

namespace App\DataFixtures;

use App\Entity\League;
use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const LEAGUES = ['Premier', 'First', 'Second'];

    private const TEAMS = [
        [
            'name' => 'Manchester United',
            'strip' => 'red-white'
        ],
        [
            'name' => 'Manchester City',
            'strip' => 'red-blue'
        ],
        [
            'name' => 'Liverpool',
            'strip' => 'red'
        ],
        [
            'name' => 'Chelsea',
            'strip' => 'blue-white'
        ],
        [
            'name' => 'Everton',
            'strip' => 'blue'
        ],
        [
            'name' => 'Tottenham',
            'strip' => 'white'
        ],
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $loadedLeagues = $this->loadLeagues($manager);
        $this->loadTeams($manager, $loadedLeagues);

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @return League[]
     */
    private function loadLeagues(ObjectManager $manager): array
    {
        $loadedLeagues = [];
        foreach (self::LEAGUES as $leagueName) {
            $league = (new League())
                ->setName($leagueName);

            $manager->persist($league);
            $loadedLeagues[] = $league;
        }

        return $loadedLeagues;
    }

    /**
     * @param ObjectManager $manager
     * @param array $loadedLeagues
     */
    private function loadTeams(ObjectManager $manager, array $loadedLeagues): void
    {
        foreach (self::TEAMS as $teamArr) {
            $teamName = $teamArr['name'];
            $strip = $teamArr['strip'];
            $league = $loadedLeagues[rand(0, count($loadedLeagues) - 1)];

            $team = (new Team())
                ->setName($teamName)
                ->setStrip($strip)
                ->setLeague($league);

            $manager->persist($team);
        }
    }
}