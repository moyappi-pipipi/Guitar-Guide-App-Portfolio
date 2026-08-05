import { render, screen } from '@testing-library/react'
import userEvent from '@testing-library/user-event'
import { createMemoryRouter, RouterProvider } from 'react-router-dom'
import { describe, expect, it } from 'vitest'
import { Header } from './Header'

function renderWithRouter(initialPath = '/') {
  const router = createMemoryRouter(
    [
      {
        path: '*',
        element: <Header />,
      },
    ],
    { initialEntries: [initialPath] },
  )

  render(<RouterProvider router={router} />)
  return router
}

describe('Header', () => {
  it('renders main navigation links', () => {
    renderWithRouter()

    expect(screen.getByRole('link', { name: /Guitar Guide/i })).toHaveAttribute(
      'href',
      '/',
    )
    expect(screen.getByRole('link', { name: 'Home' })).toBeInTheDocument()
    expect(screen.getByRole('link', { name: '初心者入門' })).toBeInTheDocument()
    expect(screen.getByRole('button', { name: '商品一覧' })).toBeInTheDocument()
    expect(screen.getByRole('link', { name: 'マイページ' })).toBeInTheDocument()
  })

  it('navigates to search page on submit', async () => {
    const user = userEvent.setup()
    const router = renderWithRouter('/')

    await user.type(
      screen.getByPlaceholderText('記事・ギター・アイテムを検索'),
      'ピック',
    )
    await user.click(screen.getByRole('button', { name: '検索' }))

    expect(router.state.location.pathname).toBe('/search')
    expect(router.state.location.search).toBe(`?q=${encodeURIComponent('ピック')}`)
  })
})
