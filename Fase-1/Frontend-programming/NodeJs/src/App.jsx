import './App.css'
import { BrowserRouter, Routes, Route } from 'react-router-dom'
import Header from './components/Header'
import Home from './pages/Home'
import Detail from './pages/Detail'
import Booking from './pages/Booking'

function App() {
  return (
    <BrowserRouter>
      <Header />
      <Routes>
        <Route path="/" element={<Home />} />
        <Route path="/vacation/:id" element={<Detail />} />
        <Route path="/vakantie/:id" element={<Detail />} />
        <Route path="/book/:id" element={<Booking />} />
        <Route path="/boeken/:id" element={<Booking />} />
      </Routes>
    </BrowserRouter>
  )
}

export default App
