import { useEffect, useState } from 'react'
import { useParams, Link } from 'react-router-dom'
import { api, categoryLabel, type Article } from '../lib/api'

export function ArticleDetailPage() {
  const { slug } = useParams()
  const [article, setArticle] = useState<Article | null>(null)
  const [error, setError] = useState<string | null>(null)

  useEffect(() => {
    if (!slug) return
    let alive = true
    ;(async () => {
      try {
        const data = await api.article(slug)
        if (alive) setArticle(data)
      } catch {
        if (alive) setError('記事が見つかりませんでした。')
      }
    })()
    return () => {
      alive = false
    }
  }, [slug])

  if (error) return <p className="status error">{error}</p>
  if (!article) return <p className="status">読み込み中...</p>

  return (
    <article className="detail">
      <Link to="/beginner" className="back-link">
        ← 記事一覧へ
      </Link>
      <span className="chip">{categoryLabel[article.category] ?? article.category}</span>
      <h1>{article.title}</h1>
      <p className="detail-excerpt">{article.excerpt}</p>
      {article.thumbnail_url && (
        <img className="detail-hero" src={article.thumbnail_url} alt="" />
      )}
      <div className="detail-body">
        {article.body.split('\n').map((line, i) => (
          <p key={`${i}-${line.slice(0, 12)}`}>{line || '\u00A0'}</p>
        ))}
      </div>
    </article>
  )
}
