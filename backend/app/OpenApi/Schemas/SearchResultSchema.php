<?php

namespace App\OpenApi\Schemas;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SearchResult',
    required: ['articles', 'guitars', 'guitar_items'],
    properties: [
        new OA\Property(
            property: 'articles',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/Article')
        ),
        new OA\Property(
            property: 'guitars',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/Guitar')
        ),
        new OA\Property(
            property: 'guitar_items',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/GuitarItem')
        ),
    ]
)]
class SearchResultSchema
{
}
