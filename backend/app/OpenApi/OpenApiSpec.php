<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: '1.0.0',
    title: 'Guitar Guide API',
    description: '弾き語りスタートガイド向け REST API'
)]
#[OA\Server(
    url: 'http://localhost:8000/api',
    description: 'Local development'
)]
#[OA\Tag(name: 'Articles', description: '記事')]
#[OA\Tag(name: 'Guitars', description: 'ギター商品')]
#[OA\Tag(name: 'GuitarItems', description: 'ギターアイテム')]
#[OA\Tag(name: 'Search', description: '横断検索')]
class OpenApiSpec
{
}
