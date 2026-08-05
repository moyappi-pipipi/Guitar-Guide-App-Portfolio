<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guitar;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class GuitarController extends Controller
{
    #[OA\Get(
        path: '/guitars',
        operationId: 'listGuitars',
        summary: 'ギター一覧',
        tags: ['Guitars'],
        parameters: [
            new OA\Parameter(name: 'level', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['beginner', 'intermediate', 'advanced'])),
            new OA\Parameter(name: 'body_type', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['dreadnought', 'concert', 'mini', 'classical'])),
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
                            items: new OA\Items(ref: '#/components/schemas/Guitar')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(Request $request)
    {
        $query = Guitar::query()->orderBy('price');

        if ($level = $request->string('level')->toString()) {
            $query->where('level', $level);
        }

        if ($bodyType = $request->string('body_type')->toString()) {
            $query->where('body_type', $bodyType);
        }

        if ($request->boolean('recommended')) {
            $query->where('is_recommended', true);
        }

        if ($q = $request->string('q')->toString()) {
            $query->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        return response()->json([
            'data' => $query->get(),
        ]);
    }

    #[OA\Get(
        path: '/guitars/{id}',
        operationId: 'getGuitar',
        summary: 'ギター詳細',
        tags: ['Guitars'],
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
                        new OA\Property(property: 'data', ref: '#/components/schemas/Guitar'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Not Found'),
        ]
    )]
    public function show(int $id)
    {
        $guitar = Guitar::query()->findOrFail($id);

        return response()->json(['data' => $guitar]);
    }
}
