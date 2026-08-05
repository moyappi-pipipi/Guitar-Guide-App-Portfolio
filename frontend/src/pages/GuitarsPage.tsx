import { useEffect, useState } from 'react'
import { GuitarCard } from '../components/GuitarCard'
import { api, type Guitar } from '../lib/api'

export function GuitarsPage() {
  const [guitars, setGuitars] = useState<Guitar[]>([])
  const [q, setQ] = useState('')
  const [level, setLevel] = useState('')
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    let alive = true
    const timer = setTimeout(async () => {
      setLoading(true)
      setError(null)
      try {
        const data = await api.guitars({
          ...(q.trim() ? { q: q.trim() } : {}),
          ...(level ? { level: level as Guitar['level'] } : {}),
        })
        if (alive) setGuitars(data)
      } catch {
        if (alive) setError('ギター一覧の取得に失敗しました。')
      } finally {
        if (alive) setLoading(false)
      }
    }, 200)
    return () => {
      alive = false
      clearTimeout(timer)
    }
  }, [q, level])

  return (
    <div className="page">
      <header className="page-header">
        <h1>ギター一覧</h1>
        <p>弾き語り向けアコギをレベルやキーワードで探せます。</p>
      </header>

      <div className="toolbar">
        <div className="filter-row">
          {[
            { value: '', label: 'すべて' },
            { value: 'beginner', label: '初心者' },
            { value: 'intermediate', label: '中級者' },
            { value: 'advanced', label: '上級者' },
          ].map((f) => (
            <button
              key={f.value || 'all'}
              type="button"
              className={`filter-btn ${level === f.value ? 'is-active' : ''}`}
              onClick={() => setLevel(f.value)}
            >
              {f.label}
            </button>
          ))}
        </div>
        <input
          className="local-search"
          type="search"
          placeholder="ギター名・ブランドで検索"
          value={q}
          onChange={(e) => setQ(e.target.value)}
        />
      </div>

      {loading && <p className="status">読み込み中...</p>}
      {error && <p className="status error">{error}</p>}

      {!loading && !error && (
        <div className="grid cards-3">
          {guitars.map((guitar) => (
            <GuitarCard key={guitar.id} guitar={guitar} />
          ))}
          {guitars.length === 0 && <p className="status">該当するギターがありません。</p>}
        </div>
      )}
    </div>
  )
}
