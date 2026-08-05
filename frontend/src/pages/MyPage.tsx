export function MyPage() {
  return (
    <div className="page">
      <header className="page-header">
        <h1>マイページ</h1>
        <p>お気に入りや学習メモを管理するスペースです（デモ表示）。</p>
      </header>

      <div className="mypage-panel">
        <div>
          <h2>ログイン中（デモ）</h2>
          <p>弾き語りデモユーザー / demo@example.com</p>
        </div>
        <ul>
          <li>お気に入りギター：YAMAHA FS820</li>
          <li>お気に入りアイテム：Tortex Standard 0.73mm</li>
          <li>最近読んだ記事：弾き語り初心者が最初に知るべき5つのこと</li>
        </ul>
      </div>
    </div>
  )
}
