import { NavLink, useNavigate } from 'react-router-dom'
import { useState, type FormEvent } from 'react'
import './Header.css'

const productLinks = [
  { to: '/products/guitars', label: 'ギター' },
  { to: '/products/items', label: 'ギターアイテム' },
]

export function Header() {
  const [open, setOpen] = useState(false)
  const [productsOpen, setProductsOpen] = useState(false)
  const [q, setQ] = useState('')
  const navigate = useNavigate()

  function onSearch(e: FormEvent) {
    e.preventDefault()
    const query = q.trim()
    if (!query) return
    setOpen(false)
    navigate(`/search?q=${encodeURIComponent(query)}`)
  }

  return (
    <header className="site-header">
      <div className="header-inner">
        <NavLink to="/" className="brand" onClick={() => setOpen(false)}>
          <span className="brand-mark">G</span>
          <span className="brand-text">
            <strong>Guitar Guide</strong>
            <small>弾き語りスタートガイド</small>
          </span>
        </NavLink>

        <button
          className="menu-toggle"
          type="button"
          aria-expanded={open}
          aria-label="メニュー"
          onClick={() => setOpen((v) => !v)}
        >
          <span />
          <span />
          <span />
        </button>

        <nav className={`nav ${open ? 'is-open' : ''}`}>
          <NavLink to="/" end onClick={() => setOpen(false)}>
            Home
          </NavLink>
          <NavLink to="/beginner" onClick={() => setOpen(false)}>
            初心者入門
          </NavLink>

          <div className={`nav-dropdown ${productsOpen ? 'is-open' : ''}`}>
            <button
              type="button"
              className="nav-dropdown-trigger"
              aria-expanded={productsOpen}
              onClick={() => setProductsOpen((v) => !v)}
            >
              商品一覧
            </button>
            <div className="nav-dropdown-menu">
              {productLinks.map((link) => (
                <NavLink
                  key={link.to}
                  to={link.to}
                  onClick={() => {
                    setOpen(false)
                    setProductsOpen(false)
                  }}
                >
                  {link.label}
                </NavLink>
              ))}
            </div>
          </div>

          <NavLink to="/mypage" onClick={() => setOpen(false)}>
            マイページ
          </NavLink>

          <form className="search-form" onSubmit={onSearch} role="search">
            <label className="sr-only" htmlFor="global-search">
              検索
            </label>
            <input
              id="global-search"
              type="search"
              placeholder="記事・ギター・アイテムを検索"
              value={q}
              onChange={(e) => setQ(e.target.value)}
            />
            <button type="submit">検索</button>
          </form>
        </nav>
      </div>
    </header>
  )
}
