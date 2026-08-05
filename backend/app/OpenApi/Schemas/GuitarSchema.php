<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'Guitar',
    required: ['id', 'name', 'brand', 'price', 'body_type', 'level', 'description', 'is_recommended'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'FS820'),
        new OA\Property(property: 'brand', type: 'string', example: 'YAMAHA'),
        new OA\Property(property: 'price', type: 'integer', example: 38500),
        new OA\Property(property: 'body_type', type: 'string', enum: ['dreadnought', 'concert', 'mini', 'classical'], example: 'concert'),
        new OA\Property(property: 'level', type: 'string', enum: ['beginner', 'intermediate', 'advanced'], example: 'beginner'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'image_url', type: 'string', nullable: true),
        new OA\Property(property: 'is_recommended', type: 'boolean', example: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', nullable: true),
    ]
)]
class GuitarSchema
{
}
