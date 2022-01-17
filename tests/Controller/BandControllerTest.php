<?php

namespace App\Tests\Controller;

use App\Tests\CustomWebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BandControllerTest extends CustomWebTestCase
{
    public function testShowBand(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('GET', '/api/bands/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testDeleteBand(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('DELETE', '/api/bands/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(204);
    }

    public function testCreateBand(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('POST', '/api/bands',['name' => 'Nowy zespół']);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }

    public function testUpdateBand(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('PUT', '/api/bands/1', ['name' => 'Nowy zespół']);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(202);
    }
}
