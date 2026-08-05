import { useEffect, useState } from 'react'
import { Link, useParams } from 'react-router-dom'
import { api, bodyTypeLabel, formatYen, levelLabel, type Guitar } from '../lib/api'

export function GuitarDetailPage() {
  const { id } = useParams()
  const [guitar, setGuitar] = useState<Guitar | null>(null)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    if (!id) return
    let alive = true
    ;(async () => {
      try {
        const data = await api.guitar(Number(id))
        if (alive) setGuitar(data)
      } catch {
        if (alive) setError('ギターが見つかりませんでした。')
      }
    })()
    return () => {
      alive = false
    }
  }, [id])

  if (error) return <p className="status error">{error}</p>
  if (!guitar) return <p className="status">読み込み中...</p>

  return (
    <article className="detail product-detail">
      <Link to="/products/guitars" className="back-link">
        ← ギター一覧へ
      </Link>
      <div className="product-detail-grid">
        {guitar.image_url && <img src={guitar.image_url} alt="" />}
        <div>
          <span className="chip">{guitar.brand}</span>
          <h1>{guitar.name}</h1>
          <p className="price">{formatYen(guitar.price)}</p>
          <p className="meta">
            {bodyTypeLabel[guitar.body_type] ?? guitar.body_type} /{' '}
            {levelLabel[guitar.level] ?? guitar.level}
          </p>
          <p className="detail-excerpt">{guitar.description}</p>
        </div>
      </div>
    </article>
  )
}
