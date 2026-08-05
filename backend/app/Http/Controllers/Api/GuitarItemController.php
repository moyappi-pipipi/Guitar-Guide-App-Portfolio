<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GuitarItem;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class GuitarItemController extends Controller
{
    #[OA\Get(
        path: '/guitar-items',
        operationId: 'listGuitarItems',
        summary: 'ギターアイテム一覧',
        tags: ['GuitarItems'],
        parameters: [
            new OA\Parameter(name: 'category', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['pick', 'capo', 'tuner', 'string', 'strap'])),
            new OA\Parameter(name: 'recommended', in: 'query', required: false, schema: new OA\Schema(type: 'boolean')),
            new OA\Parameter(name: 'q', in: 'query', required: false, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    required: ['data'],
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/GuitarItem')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(Request $request)
    {
        $query = GuitarItem::query()->orderBy('price');

        if ($category = $request->string('category')->toString()) {
            $query->where('category', $category);
        }

        if ($request->boolean('recommended')) {
            $query->where('is_recommended', true);
        }

        if ($q = $request->string('q')->toString()) {
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%");
            });
        }

        return response()->json([
            'data' => $query->get(),
        ]);
    }

    #[OA\Get(
        path: '/guitar-items/{id}',
        operationId: 'getGuitarItem',
        summary: 'ギターアイテム詳細',
        tags: ['GuitarItems'],
        parameters: [
            new OA\Parameter(name: 'id', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    required: ['data'],
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/GuitarItem'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Not Found'),
        ]
    )]
    public function show(int $id)
    {
        $item = GuitarItem::query()->findOrFail($id);

        return response()->json(['data' => $item]);
    }
}
