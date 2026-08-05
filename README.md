# Guitar Guide App Portfolio

弾き語り初心者のはじめの一歩をサポートするサイトです。  
参考: [弾き語りすとLABO](https://hikigatarisuto-labo.jp/)

## 構成

- `frontend/` — React (Vite + TypeScript)
- `backend/` — PHP Laravel 12 API
- `db` — MySQL 8.4（Dev Container）
- `.devcontainer/` — Dev Container 定義

## 画面

| ヘッダー | 内容 |
|---|---|
| Home | 新着記事 / おすすめギター記事 / おすすめギターアイテム記事 |
| 初心者入門 | 記事一覧（カテゴリ・検索） |
| 商品一覧 | ギター一覧 / ギターアイテム一覧（検索・絞り込み） |
| マイページ | デモ用プロフィール |
| 検索 | 記事・ギター・アイテム横断検索 |

すべてレスポンシブ対応です。

## OpenAPI → TypeScript 自動生成

PHP 側の Attribute（`zircote/swagger-php`）から OpenAPI を生成し、フロントはそれを元に TypeScript 型を生成します。

```bash
# 1) OpenAPI 生成（backend）
cd backend
php artisan openapi:generate
# => backend/openapi/openapi.yaml
# => backend/openapi/openapi.json

# 2) TypeScript 生成（frontend）
cd frontend
npm run generate:api
# => frontend/src/generated/schema.d.ts
```

公開エンドポイント:

- http://localhost:8000/api/openapi.yaml
- http://localhost:8000/api/openapi.json

フロントの API 呼び出しは `openapi-fetch` + 生成型（`src/lib/api.ts`）を使います。

## Dev Container での起動（推奨）

ローカルに PHP は不要です。Docker / Colima があれば起動できます。

1. Cursor / VS Code でこのフォルダを開き、「Reopen in Container」
2. `post-create.sh` が依存関係インストール・マイグレーション・OpenAPI/TS 生成・シーディングを実行
3. コンテナ内ターミナルで:

```bash
# ターミナル1
cd backend && php artisan serve --host=0.0.0.0 --port=8000

# ターミナル2
cd frontend && npm run dev -- --host 0.0.0.0 --port 5173
```

4. ブラウザ
   - Frontend: http://localhost:5173
   - API: http://localhost:8000/api/articles

## 手動で compose を使う場合

```bash
docker compose -f .devcontainer/docker-compose.yml up -d --build
docker compose -f .devcontainer/docker-compose.yml exec app bash .devcontainer/post-create.sh
```

## API 一覧

- `GET /api/articles?category=&q=&featured=`
- `GET /api/articles/{slug}`
- `GET /api/guitars?level=&body_type=&q=&recommended=`
- `GET /api/guitars/{id}`
- `GET /api/guitar-items?category=&q=&recommended=`
- `GET /api/guitar-items/{id}`
- `GET /api/search?q=`
- `GET /api/openapi.yaml`
- `GET /api/openapi.json`

## デモユーザー

- email: `demo@example.com`
- password: `password`
