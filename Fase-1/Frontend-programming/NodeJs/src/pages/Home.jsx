import { useState } from 'react'
import vacations from '../data/vacations'
import VacationCard from '../components/VacationCard'

export default function Home() {
  const [query, setQuery] = useState('')

  const filtered = vacations.filter((v) =>
    v.title.toLowerCase().includes(query.toLowerCase()) ||
    v.shortDesc.toLowerCase().includes(query.toLowerCase())
  )

  return (
    <main className="container">
      <section className="search">
        <input
          placeholder="Zoek bestemming of land..."
          value={query}
          onChange={(e) => setQuery(e.target.value)}
        />
      </section>

      <section className="grid">
        {filtered.map((v) => (
          <VacationCard key={v.id} v={v} />
        ))}
        {filtered.length === 0 && <p>Geen resultaten</p>}
      </section>
    </main>
  )
}
