<?php

namespace App\Tests\Controller;

use App\Tests\CustomWebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TrackControllerTest extends CustomWebTestCase
{
    public function testListTracks(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('GET', '/api/tracks');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
    }

    public function testDeleteTrack(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('DELETE', '/api/tracks/1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(204);
    }

    public function testCreateTrack(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('POST', '/api/tracks',
            [
                'album_id' => 1,
                'title' => 'nazwa piosenki',
                'url' => 'yt.com'
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }

    public function testUpdateTrack(): void
    {
        $this->createAuthenticatedClient();
        $this->client->request('PUT', '/api/tracks/1',
            [
                'album_id' => 1,
                'track_id' => 1,
                'title' => 'nazwa piosenki',
                'url' => 'yt.com'
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(202);
    }
}
