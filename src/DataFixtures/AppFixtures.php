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
use App\Service\Hydrator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private const LEAGUES = [
        [
            'id' => 1,
            'name' => 'Premier'
        ],
        [
            'id' => 2,
            'name' => 'First'
        ],
        [
            'id' => 3,
            'name' => 'Second'
        ]
    ];

    private const TEAMS = [
        [
            'id' => 1,
            'name' => 'Manchester United',
            'strip' => 'red-white'
        ],
        [
            'id' => 2,
            'name' => 'Manchester City',
            'strip' => 'red-blue'
        ],
        [
            'id' => 3,
            'name' => 'Liverpool',
            'strip' => 'red'
        ],
        [
            'id' => 4,
            'name' => 'Chelsea',
            'strip' => 'blue-white'
        ],
        [
            'id' => 5,
            'name' => 'Everton',
            'strip' => 'blue'
        ],
        [
            'id' => 6,
            'name' => 'Tottenham',
            'strip' => 'white'
        ],
    ];

    /** @var Hydrator */
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @param ObjectManager $manager
     * @throws \ReflectionException
     */
    public function load(ObjectManager $manager): void
    {
        $loadedLeagues = $this->loadLeagues($manager);
        $this->loadTeams($manager, $loadedLeagues);
    }

    /**
     * @param ObjectManager $manager
     * @return array
     * @throws \ReflectionException
     */
    private function loadLeagues(ObjectManager $manager): array
    {
        $loadedLeagues = [];
        foreach (self::LEAGUES as $leagueArr) {
            $league = $this->hydrator->hydrate(League::class, $leagueArr);

            // Implicitly set ids for tests
            $metadata = $manager->getClassMetadata(get_class($league));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            $manager->persist($league);
            $loadedLeagues[] = $leagueArr['id'];
        }

        $manager->flush();
        return $loadedLeagues;
    }

    /**
     * @param ObjectManager $manager
     * @param array $loadedLeagues
     * @throws \ReflectionException
     */
    private function loadTeams(ObjectManager $manager, array $loadedLeagues): void
    {
        foreach (self::TEAMS as $teamArr) {
            $teamName = $teamArr['name'];
            $strip = $teamArr['strip'];
            $teamId = $teamArr['id'];
            $leagueId = $loadedLeagues[rand(0, count($loadedLeagues) - 1)];

            $team = $this->hydrator->hydrate(Team::class,
                [
                    'id' => $teamId,
                    'name' => $teamName,
                    'strip' => $strip,
                    'league' => $leagueId
                ]);

            $metadata = $manager->getClassMetadata(get_class($team));
            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

            $manager->persist($team);
        }

        $manager->flush();
    }
}