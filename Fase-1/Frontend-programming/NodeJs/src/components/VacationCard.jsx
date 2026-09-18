import { Link } from 'react-router-dom'

export default function VacationCard({ v }) {
  return (
    <article className="card">
      <img src={v.image} alt={v.title} />
      <div className="card-body">
        <h3>{v.title}</h3>
        <p className="muted">{v.shortDesc}</p>
        <div className="card-meta">
          <strong>{v.price}</strong>
          <Link className="button" to={`/vacation/${v.id}`}>
            Details
          </Link>
        </div>
      </div>
    </article>
  )
}
