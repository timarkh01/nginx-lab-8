<?php

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class ApiTest extends TestCase
{
    
    public function testHttpRequest()
    {
        $client = new Client();
        $response = $client->get('https://www.themealdb.com/api/json/v1/1/random.php');
        
        $this->assertEquals(200, $response->getStatusCode());
        
        $data = json_decode($response->getBody(), true);
        $this->assertArrayHasKey('meals', $data);
        $this->assertNotEmpty($data['meals']);
    }
}