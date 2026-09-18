import { useState } from 'react'
import { useParams } from 'react-router-dom'
import vacations from '../data/vacations'

export default function Booking() {
  const { id } = useParams()
  const v = vacations.find((x) => x.id === id)
  const [form, setForm] = useState({ name: '', email: '', persons: 1, date: '' })
  const [confirmed, setConfirmed] = useState(null)

  if (!v) return <main className="container">Vakantie niet gevonden</main>

  const submit = (e) => {
    e.preventDefault()
    setConfirmed({
      title: v.title,
      name: form.name,
      persons: form.persons,
      date: form.date,
    })
  }

  if (confirmed)
    return (
      <main className="container booking">
        <div className="confirmation">
          <h2>Bedankt voor uw boeking!</h2>
          <p>
            Beste <strong>{confirmed.name}</strong>, uw boeking voor <strong>{confirmed.title}</strong> is
            ontvangen.
          </p>
          <p>Aantal personen: {confirmed.persons}</p>
          <p>Vertrekdatum: {confirmed.date || 'Niet opgegeven'}</p>
          <p className="muted">Dit is een fictieve bevestiging — er volgt geen betaling.</p>
        </div>
      </main>
    )

  return (
    <main className="container booking">
      <h2>Boeken: {v.title}</h2>
      <form onSubmit={submit} className="form">
        <label>
          Naam
          <input value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} required />
        </label>
        <label>
          Email
          <input type="email" value={form.email} onChange={(e) => setForm({ ...form, email: e.target.value })} required />
        </label>
        <label>
          Aantal personen
          <input type="number" min="1" value={form.persons} onChange={(e) => setForm({ ...form, persons: e.target.value })} />
        </label>
        <label>
          Vertrekdatum
          <input type="date" value={form.date} onChange={(e) => setForm({ ...form, date: e.target.value })} />
        </label>

        <div className="actions">
          <button className="button primary" type="submit">Boek</button>
        </div>
      </form>
    </main>
  )
}
