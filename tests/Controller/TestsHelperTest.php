<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: bgph
 * Date: 6/21/18
 * Time: 09:57
 */

namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;

class TestsHelperTest extends WebTestCase
{
    /**
     * @throws \Exception
     */
    protected function loadFixtures(): void
    {
        $client = static::createClient();
        $app = new Application($client->getKernel());
        $app->setAutoExit(false);

        $input = new StringInput('doctrine:fixtures:load -n');
        $app->run($input, new NullOutput());
    }


    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'admin', $password = 'admin')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            [
                '_username' => $username,
                '_password' => $password,
            ]
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client = static::createClient();
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }

    /**
     * Prevent warnings in console
     */
    public function testEmpty()
    {
        $this->assertTrue(true);
    }
}