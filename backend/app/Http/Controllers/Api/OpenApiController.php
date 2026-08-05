<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OpenApiController extends Controller
{
    public function yaml(): Response
    {
        return $this->fileResponse('openapi.yaml', 'application/yaml');
    }

    public function json(): Response
    {
        return $this->fileResponse('openapi.json', 'application/json');
    }

    private function fileResponse(string $filename, string $contentType): Response
    {
        $path = base_path('openapi/'.$filename);

        if (! File::exists($path)) {
            throw new NotFoundHttpException('OpenAPI document not found. Run: php artisan openapi:generate');
        }

        return response(File::get($path), 200, [
            'Content-Type' => $contentType,
            'Cache-Control' => 'no-cache',
        ]);
    }
}
