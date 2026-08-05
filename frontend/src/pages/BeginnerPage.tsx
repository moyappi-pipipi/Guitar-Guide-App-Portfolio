import { useEffect, useMemo, useState } from 'react'
import { useSearchParams } from 'react-router-dom'
import { ArticleCard } from '../components/ArticleCard'
import { api, type Article } from '../lib/api'

const filters = [
  { value: '', label: 'すべて' },
  { value: 'beginner', label: '初心者入門' },
  { value: 'guitar', label: 'ギター' },
  { value: 'gear', label: 'ギターアイテム' },
  { value: 'news', label: '新着' },
]

export function BeginnerPage() {
  const [params, setParams] = useSearchParams()
  const category = params.get('category') ?? ''
  const [articles, setArticles] = useState<Article[]>([])
  const [q, setQ] = useState('')
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    let alive = true
    ;(async () => {
      setLoading(true)
      setError(null)
      try {
        const data = await api.articles(
          category
            ? { category: category as NonNullable<Article['category']> }
            : undefined,
        )
        if (alive) setArticles(data)
      } catch {
        if (alive) setError('記事一覧の取得に失敗しました。')
      } finally {
        if (alive) setLoading(false)
      }
    })()
    return () => {
      alive = false
    }
  }, [category])

  const filtered = useMemo(() => {
    const keyword = q.trim().toLowerCase()
    if (!keyword) return articles
    return articles.filter(
      (a) =>
        a.title.toLowerCase().includes(keyword) ||
        a.excerpt.toLowerCase().includes(keyword),
    )
  }, [articles, q])

  return (
    <div className="page">
      <header className="page-header">
        <h1>初心者入門</h1>
        <p>弾き語りを始めるための記事一覧です。ギター紹介やアイテム解説もこちらから。</p>
      </header>

      <div className="toolbar">
        <div className="filter-row">
          {filters.map((f) => (
            <button
              key={f.value || 'all'}
              type="button"
              className={`filter-btn ${category === f.value ? 'is-active' : ''}`}
              onClick={() => {
                if (f.value) setParams({ category: f.value })
                else setParams({})
              }}
            >
              {f.label}
            </button>
          ))}
        </div>
        <input
          className="local-search"
          type="search"
          placeholder="このページ内で検索"
          value={q}
          onChange={(e) => setQ(e.target.value)}
        />
      </div>

      {loading && <p className="status">読み込み中...</p>}
      {error && <p className="status error">{error}</p>}

      {!loading && !error && (
        <div className="grid cards-3">
          {filtered.map((article) => (
            <ArticleCard key={article.id} article={article} />
          ))}
          {filtered.length === 0 && <p className="status">該当する記事がありません。</p>}
        </div>
      )}
    </div>
  )
}
