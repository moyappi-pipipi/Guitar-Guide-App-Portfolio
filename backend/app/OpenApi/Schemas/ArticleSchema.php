<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Article',
    required: ['id', 'title', 'slug', 'category', 'excerpt', 'body', 'is_featured'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'title', type: 'string', example: '初心者におすすめのアコースティックギター'),
        new OA\Property(property: 'slug', type: 'string', example: 'recommended-acoustic-guitars'),
        new OA\Property(property: 'category', type: 'string', enum: ['beginner', 'guitar', 'gear', 'news'], example: 'guitar'),
        new OA\Property(property: 'excerpt', type: 'string'),
        new OA\Property(property: 'body', type: 'string'),
        new OA\Property(property: 'thumbnail_url', type: 'string', nullable: true),
        new OA\Property(property: 'is_featured', type: 'boolean', example: true),
        new OA\Property(property: 'published_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', nullable: true),
    ]
)]
class ArticleSchema
{
}
