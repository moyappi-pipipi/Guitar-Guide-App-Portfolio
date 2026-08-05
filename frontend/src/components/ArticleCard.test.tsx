import { render, screen } from '@testing-library/react'
import { MemoryRouter } from 'react-router-dom'
import { describe, expect, it } from 'vitest'
import { ArticleCard } from './ArticleCard'
import type { Article } from '../lib/api'

const article: Article = {
  id: 1,
  title: '初心者におすすめのアコースティックギター',
  slug: 'recommended-acoustic-guitars',
  category: 'guitar',
  excerpt: '弾き語り向けのおすすめモデル',
  body: '本文',
  thumbnail_url: 'https://example.com/thumb.jpg',
  is_featured: true,
  published_at: '2026-08-01T00:00:00.000000Z',
}

describe('ArticleCard', () => {
  it('renders title, excerpt and category label', () => {
    render(
      <MemoryRouter>
        <ArticleCard article={article} />
      </MemoryRouter>,
    )

    expect(
      screen.getByRole('heading', {
        name: '初心者におすすめのアコースティックギター',
      }),
    ).toBeInTheDocument()
    expect(screen.getByText('弾き語り向けのおすすめモデル')).toBeInTheDocument()
    expect(screen.getByText('ギター')).toBeInTheDocument()
    expect(
      screen.getByRole('link', {
        name: '初心者におすすめのアコースティックギター',
      }),
    ).toHaveAttribute('href', '/articles/recommended-acoustic-guitars')
  })
})
