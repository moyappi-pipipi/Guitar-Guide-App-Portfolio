import createClient from 'openapi-fetch'
import type { components, paths } from '../generated/schema'

export type Article = components['schemas']['Article']
export type Guitar = components['schemas']['Guitar']
export type GuitarItem = components['schemas']['GuitarItem']
export type SearchResult = components['schemas']['SearchResult']

type ListArticlesQuery = NonNullable<paths['/articles']['get']['parameters']['query']>
type ListGuitarsQuery = NonNullable<paths['/guitars']['get']['parameters']['query']>
type ListGuitarItemsQuery = NonNullable<
  paths['/guitar-items']['get']['parameters']['query']
>

const API_BASE = import.meta.env.VITE_API_BASE_URL ?? 'http://localhost:8000/api'

const client = createClient<paths>({ baseUrl: API_BASE })

async function assertData<T>(
  result: { data?: T; error?: unknown; response: Response },
  label: string,
): Promise<T> {
  if (result.error || !result.response.ok || result.data === undefined) {
    throw new Error(`API error (${label}): ${result.response.status}`)
  }
  return result.data
}

export const api = {
  articles: async (params?: ListArticlesQuery) => {
    const result = await client.GET('/articles', { params: { query: params } })
    const body = await assertData(result, 'listArticles')
    return body.data
  },

  article: async (slug: string) => {
    const result = await client.GET('/articles/{slug}', {
      params: { path: { slug } },
    })
    const body = await assertData(result, 'getArticle')
    return body.data
  },

  guitars: async (params?: ListGuitarsQuery) => {
    const result = await client.GET('/guitars', { params: { query: params } })
    const body = await assertData(result, 'listGuitars')
    return body.data
  },

  guitar: async (id: number) => {
    const result = await client.GET('/guitars/{id}', {
      params: { path: { id } },
    })
    const body = await assertData(result, 'getGuitar')
    return body.data
  },

  guitarItems: async (params?: ListGuitarItemsQuery) => {
    const result = await client.GET('/guitar-items', {
      params: { query: params },
    })
    const body = await assertData(result, 'listGuitarItems')
    return body.data
  },

  guitarItem: async (id: number) => {
    const result = await client.GET('/guitar-items/{id}', {
      params: { path: { id } },
    })
    const body = await assertData(result, 'getGuitarItem')
    return body.data
  },

  search: async (q: string) => {
    const result = await client.GET('/search', {
      params: { query: { q } },
    })
    const body = await assertData(result, 'searchAll')
    return body.data
  },
}

export function formatYen(price: number): string {
  return new Intl.NumberFormat('ja-JP', {
    style: 'currency',
    currency: 'JPY',
    maximumFractionDigits: 0,
  }).format(price)
}

export const categoryLabel: Record<string, string> = {
  beginner: '初心者入門',
  guitar: 'ギター',
  gear: 'ギターアイテム',
  news: '新着',
  pick: 'ピック',
  capo: 'カポ',
  tuner: 'チューナー',
  string: '弦',
  strap: 'ストラップ',
}

export const bodyTypeLabel: Record<string, string> = {
  dreadnought: 'ドレッドノート',
  concert: 'コンサート',
  mini: 'ミニ',
  classical: 'クラシック',
}

export const levelLabel: Record<string, string> = {
  beginner: '初心者',
  intermediate: '中級者',
  advanced: '上級者',
}
