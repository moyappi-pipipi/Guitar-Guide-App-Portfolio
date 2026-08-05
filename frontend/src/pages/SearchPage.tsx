import { useEffect, useState, type FormEvent } from 'react'
import { useSearchParams } from 'react-router-dom'
import { ArticleCard } from '../components/ArticleCard'
import { GuitarCard } from '../components/GuitarCard'
import { ItemCard } from '../components/ItemCard'
import { api, type SearchResult } from '../lib/api'

export function SearchPage() {
  const [params, setParams] = useSearchParams()
  const initial = params.get('q') ?? ''
  const [input, setInput] = useState(initial)
  const [result, setResult] = useState<SearchResult | null>(null)
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    setInput(initial)
    if (!initial.trim()) {
      setResult({ articles: [], guitars: [], guitar_items: [] })
      return
    }
    let alive = true
    ;(async () => {
      setLoading(true)
      setError(null)
      try {
        const data = await api.search(initial.trim())
        if (alive) setResult(data)
      } catch {
        if (alive) setError('検索に失敗しました。')
      } finally {
        if (alive) setLoading(false)
      }
    })()
    return () => {
      alive = false
    }
  }, [initial])

  function onSubmit(e: FormEvent) {
    e.preventDefault()
    const q = input.trim()
    setParams(q ? { q } : {})
  }

  const empty =
    result &&
    result.articles.length === 0 &&
    result.guitars.length === 0 &&
    result.guitar_items.length === 0

  return (
    <div className="page">
      <header className="page-header">
        <h1>検索</h1>
        <p>記事・ギター・ギターアイテムをまとめて探せます。</p>
      </header>

      <form className="search-page-form" onSubmit={onSubmit}>
        <input
          type="search"
          value={input}
          onChange={(e) => setInput(e.target.value)}
          placeholder="キーワードを入力"
        />
        <button type="submit">検索</button>
      </form>

      {loading && <p className="status">検索中...</p>}
      {error && <p className="status error">{error}</p>}

      {!loading && !error && result && (
        <>
          {empty && <p className="status">「{initial}」に一致する結果はありません。</p>}

          {result.articles.length > 0 && (
            <section className="section">
              <div className="section-head">
                <h2>記事</h2>
              </div>
              <div className="grid cards-3">
                {result.articles.map((article) => (
                  <ArticleCard key={article.id} article={article} />
                ))}
              </div>
            </section>
          )}

          {result.guitars.length > 0 && (
            <section className="section">
              <div className="section-head">
                <h2>ギター</h2>
              </div>
              <div className="grid cards-3">
                {result.guitars.map((guitar) => (
                  <GuitarCard key={guitar.id} guitar={guitar} />
                ))}
              </div>
            </section>
          )}

          {result.guitar_items.length > 0 && (
            <section className="section">
              <div className="section-head">
                <h2>ギターアイテム</h2>
              </div>
              <div className="grid cards-3">
                {result.guitar_items.map((item) => (
                  <ItemCard key={item.id} item={item} />
                ))}
              </div>
            </section>
          )}
        </>
      )}
    </div>
  )
}
