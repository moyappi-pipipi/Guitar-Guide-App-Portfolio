<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class OpenApiTest extends TestCase
{
    public function test_serves_openapi_yaml(): void
    {
        $response = $this->get('/api/openapi.yaml');

        $response->assertOk();
        $this->assertStringContainsString('Guitar Guide API', $response->getContent());
        $this->assertStringContainsString('openapi:', $response->getContent());
    }

    public function test_serves_openapi_json(): void
    {
        $response = $this->getJson('/api/openapi.json');

        $response->assertOk()
            ->assertJsonPath('info.title', 'Guitar Guide API')
            ->assertJsonStructure([
                'openapi',
                'info' => ['title', 'version'],
                'paths',
                'components',
            ]);
    }
}
