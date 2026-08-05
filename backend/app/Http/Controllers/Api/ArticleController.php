<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ArticleController extends Controller
{
    #[OA\Get(
        path: '/articles',
        operationId: 'listArticles',
        summary: '記事一覧',
        tags: ['Articles'],
        parameters: [
            new OA\Parameter(name: 'category', in: 'query', required: false, schema: new OA\Schema(type: 'string', enum: ['beginner', 'guitar', 'gear', 'news'])),
            new OA\Parameter(name: 'featured', in: 'query', required: false, schema: new OA\Schema(type: 'boolean')),
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
                            items: new OA\Items(ref: '#/components/schemas/Article')
                        ),
                    ]
                )
            ),
        ]
    )]
    public function index(Request $request)
    {
        $query = Article::query()->orderByDesc('published_at');

        if ($category = $request->string('category')->toString()) {
            $query->where('category', $category);
        }

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        if ($q = $request->string('q')->toString()) {
            $query->where(function ($builder) use ($q) {
                $builder->where('title', 'like', "%{$q}%")
                    ->orWhere('excerpt', 'like', "%{$q}%")
                    ->orWhere('body', 'like', "%{$q}%");
            });
        }

        return response()->json([
            'data' => $query->get(),
        ]);
    }

    #[OA\Get(
        path: '/articles/{slug}',
        operationId: 'getArticle',
        summary: '記事詳細',
        tags: ['Articles'],
        parameters: [
            new OA\Parameter(name: 'slug', in: 'path', required: true, schema: new OA\Schema(type: 'string')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    required: ['data'],
                    properties: [
                        new OA\Property(property: 'data', ref: '#/components/schemas/Article'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Not Found'),
        ]
    )]
    public function show(string $slug)
    {
        $article = Article::query()->where('slug', $slug)->firstOrFail();

        return response()->json(['data' => $article]);
    }
}
