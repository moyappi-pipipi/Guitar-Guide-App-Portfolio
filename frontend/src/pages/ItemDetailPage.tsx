import { useEffect, useState } from 'react'
import { Link, useParams } from 'react-router-dom'
import { api, categoryLabel, formatYen, type GuitarItem } from '../lib/api'

export function ItemDetailPage() {
  const { id } = useParams()
  const [item, setItem] = useState<GuitarItem | null>(null)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    if (!id) return
    let alive = true
    ;(async () => {
      try {
        const data = await api.guitarItem(Number(id))
        if (alive) setItem(data)
      } catch {
        if (alive) setError('アイテムが見つかりませんでした。')
      }
    })()
    return () => {
      alive = false
    }
  }, [id])

  if (error) return <p className="status error">{error}</p>
  if (!item) return <p className="status">読み込み中...</p>

  return (
    <article className="detail product-detail">
      <Link to="/products/items" className="back-link">
        ← ギターアイテム一覧へ
      </Link>
      <div className="product-detail-grid">
        {item.image_url && <img src={item.image_url} alt="" />}
        <div>
          <span className="chip">{categoryLabel[item.category] ?? item.category}</span>
          <h1>{item.name}</h1>
          <p className="price">{formatYen(item.price)}</p>
          <p className="meta">
            {item.brand}
            {item.specs ? ` / ${item.specs}` : ''}
          </p>
          <p className="detail-excerpt">{item.description}</p>
        </div>
      </div>
    </article>
  )
}
