#!/usr/bin/env bash
set -euo pipefail

git config --global --add safe.directory /workspace || true

echo "==> Backend: composer install"
cd /workspace/backend
if [ ! -f .env ]; then
  cp .env.example .env
fi
composer install --no-interaction --prefer-dist
php artisan key:generate --force || true

echo "==> Backend: wait for MySQL"
until mysqladmin ping -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" --silent; do
  sleep 2
done

php artisan migrate --force
php artisan db:seed --force

echo "==> Backend: generate OpenAPI"
php artisan openapi:generate

echo "==> Frontend: npm install"
cd /workspace/frontend
if [ ! -f .env ]; then
  cp .env.example .env
fi
npm install --legacy-peer-deps

echo "==> Frontend: generate TypeScript from OpenAPI"
npm run generate:api

echo "==> Ready"
echo "  Backend : cd backend && php artisan serve --host=0.0.0.0 --port=8000"
echo "  Frontend: cd frontend && npm run dev -- --host 0.0.0.0 --port 5173"
echo "  OpenAPI : http://localhost:8000/api/openapi.yaml"
