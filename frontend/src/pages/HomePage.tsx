import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import { ArticleCard } from '../components/ArticleCard'
import { api, type Article } from '../lib/api'
import './HomePage.css'

export function HomePage() {
  const [latest, setLatest] = useState<Article[]>([])
  const [guitarArticles, setGuitarArticles] = useState<Article[]>([])
  const [gearArticles, setGearArticles] = useState<Article[]>([])
  const [error, setError] = useState<string | null>(null)
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    let alive = true
    ;(async () => {
      try {
        const [all, guitars, gear] = await Promise.all([
          api.articles(),
          api.articles({ category: 'guitar' }),
          api.articles({ category: 'gear' }),
        ])
        if (!alive) return
        setLatest(all.slice(0, 4))
        setGuitarArticles(guitars.slice(0, 4))
        setGearArticles(gear.slice(0, 4))
      } catch {
        if (alive) setError('記事の取得に失敗しました。APIサーバーを確認してください。')
      } finally {
        if (alive) setLoading(false)
      }
    })()
    return () => {
      alive = false
    }
  }, [])

  return (
    <div className="home">
      <section className="hero">
        <div className="hero-copy">
          <p className="eyebrow">弾き語りをはじめよう</p>
          <h1>Guitar Guide</h1>
          <p className="lede">
            ギター選びからピック・カポまで。初めての弾き語りを迷わずスタートできるガイドです。
          </p>
          <div className="hero-actions">
            <Link className="btn primary" to="/beginner">
              初心者入門を見る
            </Link>
            <Link className="btn ghost" to="/products/guitars">
              おすすめギター一覧
            </Link>
          </div>
        </div>
      </section>

      {loading && <p className="status">読み込み中...</p>}
      {error && <p className="status error">{error}</p>}

      {!loading && !error && (
        <>
          <section className="section">
            <div className="section-head">
              <h2>新着記事</h2>
              <Link to="/beginner">一覧を見る</Link>
            </div>
            <div className="grid cards-4">
              {latest.map((article) => (
                <ArticleCard key={article.id} article={article} />
              ))}
            </div>
          </section>

          <section className="section">
            <div className="section-head">
              <h2>おすすめのギター記事</h2>
              <Link to="/beginner?category=guitar">記事を見る</Link>
            </div>
            <div className="grid cards-4">
              {guitarArticles.map((article) => (
                <ArticleCard key={article.id} article={article} />
              ))}
            </div>
          </section>

          <section className="section">
            <div className="section-head">
              <h2>おすすめのギターアイテム記事</h2>
              <Link to="/beginner?category=gear">記事を見る</Link>
            </div>
            <div className="grid cards-4">
              {gearArticles.map((article) => (
                <ArticleCard key={article.id} article={article} />
              ))}
            </div>
          </section>
        </>
      )}
    </div>
  )
}
