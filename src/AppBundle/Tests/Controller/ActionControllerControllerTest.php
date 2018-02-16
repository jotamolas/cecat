<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ActionControllerControllerTest extends WebTestCase
{
    public function testAccredit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/accredit');
    }

}
