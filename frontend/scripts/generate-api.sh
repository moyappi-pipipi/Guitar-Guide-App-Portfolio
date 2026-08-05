#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
SPEC="${ROOT_DIR}/../backend/openapi/openapi.yaml"
OUT_DIR="${ROOT_DIR}/src/generated"
OUT_FILE="${OUT_DIR}/schema.d.ts"

if [ ! -f "$SPEC" ]; then
  echo "OpenAPI spec not found: $SPEC"
  echo "Run first: cd backend && php artisan openapi:generate"
  exit 1
fi

mkdir -p "$OUT_DIR"
npx openapi-typescript "$SPEC" -o "$OUT_FILE"
echo "Generated: $OUT_FILE"
