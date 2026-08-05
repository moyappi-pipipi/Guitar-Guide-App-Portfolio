import { Link } from 'react-router-dom'
import type { Article } from '../lib/api'
import { categoryLabel } from '../lib/api'
import './Cards.css'

type Props = {
  article: Article
}

export function ArticleCard({ article }: Props) {
  return (
    <article className="card article-card">
      <Link to={`/articles/${article.slug}`} className="card-media">
        {article.thumbnail_url ? (
          <img src={article.thumbnail_url} alt="" loading="lazy" />
        ) : (
          <div className="card-fallback" />
        )}
      </Link>
      <div className="card-body">
        <span className="chip">{categoryLabel[article.category] ?? article.category}</span>
        <h3>
          <Link to={`/articles/${article.slug}`}>{article.title}</Link>
        </h3>
        <p>{article.excerpt}</p>
      </div>
    </article>
  )
}
