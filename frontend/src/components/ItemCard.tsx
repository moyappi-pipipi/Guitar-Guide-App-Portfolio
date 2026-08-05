import { Link } from 'react-router-dom'
import type { GuitarItem } from '../lib/api'
import { categoryLabel, formatYen } from '../lib/api'
import './Cards.css'

type Props = {
  item: GuitarItem
}

export function ItemCard({ item }: Props) {
  return (
    <article className="card product-card">
      <Link to={`/products/items/${item.id}`} className="card-media">
        {item.image_url ? (
          <img src={item.image_url} alt="" loading="lazy" />
        ) : (
          <div className="card-fallback" />
        )}
      </Link>
      <div className="card-body">
        <span className="chip">{categoryLabel[item.category] ?? item.category}</span>
        <h3>
          <Link to={`/products/items/${item.id}`}>{item.name}</Link>
        </h3>
        <p className="price">{formatYen(item.price)}</p>
        <p className="meta">{item.brand}{item.specs ? ` / ${item.specs}` : ''}</p>
      </div>
    </article>
  )
}
