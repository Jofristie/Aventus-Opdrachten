import { Link, useParams } from 'react-router-dom'
import vacations from '../data/vacations'

export default function Detail() {
  const { id } = useParams()
  const v = vacations.find((x) => x.id === id)

  if (!v) return <main className="container">Vakantie niet gevonden</main>

  return (
    <main className="container detail">
      <img className="detail-img" src={v.image} alt={v.title} />
      <div className="detail-body">
        <h2>{v.title}</h2>
        <p className="muted">{v.price}</p>
        <p>{v.longDesc}</p>
        <h4>Highlights</h4>
        <ul>
          {v.highlights.map((h) => (
            <li key={h}>{h}</li>
          ))}
        </ul>

        <div className="actions">
          <Link className="button primary" to={`/book/${v.id}`}>
            Boek nu
          </Link>
        </div>
      </div>
    </main>
  )
}
