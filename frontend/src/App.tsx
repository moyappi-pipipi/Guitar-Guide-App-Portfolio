import { Navigate, Route, Routes } from 'react-router-dom'
import { Header } from './components/Header'
import { HomePage } from './pages/HomePage'
import { BeginnerPage } from './pages/BeginnerPage'
import { ArticleDetailPage } from './pages/ArticleDetailPage'
import { GuitarsPage } from './pages/GuitarsPage'
import { GuitarDetailPage } from './pages/GuitarDetailPage'
import { ItemsPage } from './pages/ItemsPage'
import { ItemDetailPage } from './pages/ItemDetailPage'
import { SearchPage } from './pages/SearchPage'
import { MyPage } from './pages/MyPage'
import './App.css'

export default function App() {
  return (
    <div className="app-shell">
      <Header />
      <main className="main">
        <Routes>
          <Route path="/" element={<HomePage />} />
          <Route path="/beginner" element={<BeginnerPage />} />
          <Route path="/articles/:slug" element={<ArticleDetailPage />} />
          <Route path="/products" element={<Navigate to="/products/guitars" replace />} />
          <Route path="/products/guitars" element={<GuitarsPage />} />
          <Route path="/products/guitars/:id" element={<GuitarDetailPage />} />
          <Route path="/products/items" element={<ItemsPage />} />
          <Route path="/products/items/:id" element={<ItemDetailPage />} />
          <Route path="/search" element={<SearchPage />} />
          <Route path="/mypage" element={<MyPage />} />
        </Routes>
      </main>
      <footer className="site-footer">
        <p>Guitar Guide — 弾き語りスタートを応援するポートフォリオアプリ</p>
      </footer>
    </div>
  )
}
