<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Guitar;
use App\Models\GuitarItem;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class SearchController extends Controller
{
    #[OA\Get(
        path: '/search',
        operationId: 'searchAll',
        summary: '記事・ギター・アイテム横断検索',
        tags: ['Search'],
        parameters: [
            new OA\Parameter(name: 'q', in: 'query', required: true, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    required: ['data'],
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/SearchResult'),
                    ]
                )
            ),
        ]
    )]
    public function __invoke(Request $request)
    {
        $q = trim($request->string('q')->toString());

        if ($q === '') {
            return response()->json([
                'data' => [
                    'articles' => [],
                    'guitars' => [],
                    'guitar_items' => [],
                ],
            ]);
        }

        $articles = Article::query()
            ->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%");
            })
            ->orderByDesc('published_at')
            ->limit(10)
            ->get();

        $guitars = Guitar::query()
            ->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            })
            ->orderBy('price')
            ->limit(10)
            ->get();

        $items = GuitarItem::query()
            ->where(function ($builder) use ($q) {
                $builder->where('name', 'like', "%{$q}%")
                    ->orWhere('brand', 'like', "%{$q}%")
                    ->orWhere('category', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            })
            ->orderBy('price')
            ->limit(10)
            ->get();

        return response()->json([
            'data' => [
                'articles' => $articles,
                'guitars' => $guitars,
                'guitar_items' => $items,
            ],
        ]);
    }
}
