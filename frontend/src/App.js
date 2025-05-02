// import "bootstrap/dist/css/bootstrap.min.css";

import { BrowserRouter, Routes, Route } from 'react-router-dom';

import Menu from './pages/menu.jsx';
import Footer from './pages/footer.jsx';
import Index from './pages/index.jsx';
import Productos from './pages/productos.jsx';
import Contacto from './pages/contacto.jsx';
import Login from './pages/login.jsx';

function App() {
  return (
    <div className="App">
      <BrowserRouter>
        <Menu />
          <Routes>
              <Route path="/" element={<Index />} />
              <Route path="/Productos" element={<Productos />} />
              <Route path="/Contacto" element={<Contacto />} />
              <Route path="/Login" element={<Login />} />
          </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;
