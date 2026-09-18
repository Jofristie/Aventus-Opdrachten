import { Link } from 'react-router-dom'

export default function Header() {
  return (
    <header className="site-header">
      <div className="container">
        <h1 className="logo">
          <Link to="/">Sunny Travels</Link>
        </h1>
        <nav>
          <Link to="/">Home</Link>
        </nav>
      </div>
    </header>
  )
}
