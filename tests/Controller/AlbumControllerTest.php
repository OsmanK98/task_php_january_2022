<?php

namespace App\Tests\Controller;

use App\Tests\CustomWebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AlbumControllerTest extends CustomWebTestCase
{
    public function testListAlbums(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('GET', '/api/albums');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testShowAlbum(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('GET', '/api/albums/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testDeleteAlbum(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('DELETE', '/api/albums/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(204);
    }

    public function testCreateAlbum(): void
    {
        $this->markTestSkipped();
        $this->createAuthenticatedClient();
        $file =  new UploadedFile(
            'src/DataFixtures/grafika_testowa.png',
            'grafika_testowa.png');
        $this->client->request('POST', '/api/albums', [
                'band_id' => 1,
                'title' => 'Rekordowo letnie lato',
                'year' => 2019,
                'is_promoted' => true
            ],
            [ 'cover' => $file]
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }

    public function testUpdateAlbum(): void
    {
        $this->markTestSkipped();
        $this->createAuthenticatedClient();
        $file=new UploadedFile(
            'src/DataFixtures/grafika.png',
            'grafika.png');
        $this->client->request('POST', '/api/albums/1', [
                'band_id' => 1,
                'title' => 'Rekordowo letnie lato',
                'is_promoted' => true,
                'album_id' => 1,
                'year' => 2019
            ],
            [ 'cover' => $file]
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(202);
    }
}
