<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'GuitarItem',
    required: ['id', 'name', 'brand', 'category', 'price', 'description', 'is_recommended'],
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Tortex Standard 0.73mm'),
        new OA\Property(property: 'brand', type: 'string', example: 'Dunlop'),
        new OA\Property(property: 'category', type: 'string', enum: ['pick', 'capo', 'tuner', 'string', 'strap'], example: 'pick'),
        new OA\Property(property: 'price', type: 'integer', example: 120),
        new OA\Property(property: 'specs', type: 'string', nullable: true, example: '0.73mm / Tortex'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'image_url', type: 'string', nullable: true),
        new OA\Property(property: 'is_recommended', type: 'boolean', example: true),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time', nullable: true),
        new OA\Property(property: 'updated_at', type: 'string', format: 'date-time', nullable: true),
    ]
)]
class GuitarItemSchema
{
}
