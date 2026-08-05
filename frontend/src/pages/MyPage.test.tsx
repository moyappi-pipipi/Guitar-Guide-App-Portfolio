import { render, screen } from '@testing-library/react'
import { MemoryRouter } from 'react-router-dom'
import { describe, expect, it } from 'vitest'
import { MyPage } from '../pages/MyPage'

describe('MyPage', () => {
  it('renders demo profile content', () => {
    render(
      <MemoryRouter>
        <MyPage />
      </MemoryRouter>,
    )

    expect(
      screen.getByRole('heading', { name: 'マイページ' }),
    ).toBeInTheDocument()
    expect(screen.getByText(/demo@example.com/)).toBeInTheDocument()
  })
})
