<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/21/18
 * Time: 08:41
 */

namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;

class LeagueControllerTest extends TestsHelperTest
{
    /**
     * @throws \Exception
     */
    public function setUp()
    {
        $this->loadFixtures();
    }

    /**
     * @return \Generator
     */
    public function getApiUrls()
    {
        yield ['GET', '/api/league/show/1'];
        yield ['DELETE', '/api/league/delete/1'];
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

    /**
     * @dataProvider getApiUrls
     * @param string $httpMethod
     * @param string $url
     */
    public function testLeagueApiEndpoints(string $httpMethod, string $url)
    {
        $client = $this->createAuthenticatedClient();

        $client->request($httpMethod, $url);

        $this->assertSame(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}