import { describe, expect, it } from 'vitest'
import { bodyTypeLabel, categoryLabel, formatYen, levelLabel } from '../lib/api'

describe('formatYen', () => {
  it('formats price in Japanese yen', () => {
    expect(formatYen(38500)).toBe('￥38,500')
  })

  it('formats zero yen', () => {
    expect(formatYen(0)).toBe('￥0')
  })
})

describe('label maps', () => {
  it('maps article and item categories', () => {
    expect(categoryLabel.guitar).toBe('ギター')
    expect(categoryLabel.pick).toBe('ピック')
  })

  it('maps body types and levels', () => {
    expect(bodyTypeLabel.concert).toBe('コンサート')
    expect(levelLabel.beginner).toBe('初心者')
  })
})
