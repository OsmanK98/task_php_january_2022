<?php

namespace App\Tests\Controller;

use App\Tests\CustomWebTestCase;

class RegistrationControllerTest extends CustomWebTestCase
{
    public function testRegistration(): void
    {
        $this->client->request('POST', '/api/registration', [
                'username' => 'test2@test.pl',
                'password' => 'haslo123'
            ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }
}
