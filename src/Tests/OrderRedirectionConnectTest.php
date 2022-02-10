<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class OrderRedirectionConnectTest extends WebTestCase
{
    public function OrderRedirectionConnectTest(){
        $client = static::createClient();
        $client->request('GET', '/commande');
        $this->assertResponseRedirects('/connexion');
    }
}