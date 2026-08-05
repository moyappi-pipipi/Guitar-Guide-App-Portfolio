import { useEffect, useState } from 'react'
import { ItemCard } from '../components/ItemCard'
import { api, type GuitarItem } from '../lib/api'

const categories = [
  { value: '', label: 'すべて' },
  { value: 'pick', label: 'ピック' },
  { value: 'capo', label: 'カポ' },
  { value: 'tuner', label: 'チューナー' },
  { value: 'string', label: '弦' },
  { value: 'strap', label: 'ストラップ' },
]

export function ItemsPage() {
  const [items, setItems] = useState<GuitarItem[]>([])
  const [q, setQ] = useState('')
  const [category, setCategory] = useState('')
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    let alive = true
    const timer = setTimeout(async () => {
      setLoading(true)
      setError(null)
      try {
        const data = await api.guitarItems({
          ...(q.trim() ? { q: q.trim() } : {}),
          ...(category
            ? { category: category as GuitarItem['category'] }
            : {}),
        })
        if (alive) setItems(data)
      } catch {
        if (alive) setError('ギターアイテム一覧の取得に失敗しました。')
      } finally {
        if (alive) setLoading(false)
      }
    }, 200)
    return () => {
      alive = false
      clearTimeout(timer)
    }
  }, [q, category])

  return (
    <div className="page">
      <header className="page-header">
        <h1>ギターアイテム一覧</h1>
        <p>ピック・カポ・チューナーなど、弾き語りを支えるアイテムを探せます。</p>
      </header>

      <div className="toolbar">
        <div className="filter-row">
          {categories.map((f) => (
            <button
              key={f.value || 'all'}
              type="button"
              className={`filter-btn ${category === f.value ? 'is-active' : ''}`}
              onClick={() => setCategory(f.value)}
            >
              {f.label}
            </button>
          ))}
        </div>
        <input
          className="local-search"
          type="search"
          placeholder="アイテム名・ブランドで検索"
          value={q}
          onChange={(e) => setQ(e.target.value)}
        />
      </div>

      {loading && <p className="status">読み込み中...</p>}
      {error && <p className="status error">{error}</p>}

      {!loading && !error && (
        <div className="grid cards-3">
          {items.map((item) => (
            <ItemCard key={item.id} item={item} />
          ))}
          {items.length === 0 && <p className="status">該当するアイテムがありません。</p>}
        </div>
      )}
    </div>
  )
}
