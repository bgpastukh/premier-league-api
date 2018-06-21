<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/21/18
 * Time: 09:56
 */

namespace App\Tests\Controller;


use App\Entity\Team;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class TeamControllerTest extends TestsHelperTest
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * @throws \Exception
     */
    public function setUp()
    {
        $this->loadFixtures();

        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    /**
     * @return \Generator
     */
    public function getApiUrls()
    {
        yield ['POST', '/api/team/create', [
            'name' => 'Arsenal',
            'strip' => 'red-white',
            'league' => 1
        ]];
        yield ['PUT', '/api/team/update/1', [
            'name' => 'Fulham'
        ]];
    }

    /**
     * @dataProvider getApiUrls
     * @param string $httpMethod
     * @param string $url
     */
    public function testAccessDeniedForUnauthorizedUrls(string $httpMethod, string $url)
    {
        $client = static::createClient();

        $client->request($httpMethod, $url);
        $this->assertSame(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
    }

    public function testCreateTeam()
    {
        $teamsBeforeTest = count($this->em->getRepository(Team::class)->findAll());
        $client = $this->createAuthenticatedClient();

        $client->request('POST', '/api/team/create', [
            'name' => 'Arsenal',
            'strip' => 'red-white',
            'league' => 1
        ]);

        $response = json_decode($client->getResponse()->getContent(), true);
        $teamsAfterTest = count($this->em->getRepository(Team::class)->findAll());
        $this->assertEquals($response['status'], 'ok');
        $this->assertEquals($teamsAfterTest, $teamsBeforeTest + 1);
    }

    public function testUpdateTeam()
    {
        $entity = $this->em->getRepository(Team::class)->find(1);
        $oldName = $entity->getName();

        $this->assertNotEquals($oldName, 'Fulham');

        $client = $this->createAuthenticatedClient();

        $client->request('PUT', '/api/team/update/1', [
            'name' => 'Fulham',
            'strip' => 'white',
            'league' => 1
        ]);

        $entity = $this->em->getRepository(Team::class)->find(1);
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($response['status'], 'ok');

        $newName = $entity->getName();
        $this->assertEquals($newName, 'Fulham');
    }

    /** TODO */
//    public function testValidationErrors()
}