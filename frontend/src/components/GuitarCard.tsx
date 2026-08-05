import { Link } from 'react-router-dom'
import type { Guitar } from '../lib/api'
import { bodyTypeLabel, formatYen, levelLabel } from '../lib/api'
import './Cards.css'

type Props = {
  guitar: Guitar
}

export function GuitarCard({ guitar }: Props) {
  return (
    <article className="card product-card">
      <Link to={`/products/guitars/${guitar.id}`} className="card-media">
        {guitar.image_url ? (
          <img src={guitar.image_url} alt="" loading="lazy" />
        ) : (
          <div className="card-fallback" />
        )}
      </Link>
      <div className="card-body">
        <span className="chip">{guitar.brand}</span>
        <h3>
          <Link to={`/products/guitars/${guitar.id}`}>{guitar.name}</Link>
        </h3>
        <p className="price">{formatYen(guitar.price)}</p>
        <p className="meta">
          {bodyTypeLabel[guitar.body_type] ?? guitar.body_type} /{' '}
          {levelLabel[guitar.level] ?? guitar.level}
        </p>
      </div>
    </article>
  )
}
