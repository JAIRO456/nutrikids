// import "bootstrap/dist/css/bootstrap.min.css";

import { BrowserRouter, Routes, Route } from 'react-router-dom';

// ---------- Menús ---------- //
import Menu from './pages/menu.jsx';
import AdminMenu from './pages/admin/menu.jsx';
import CoordinadorMenu from './pages/coordinador/menu.jsx';
import VendedorMenu from './pages/vendedor/menu.jsx';
import AcudienteMenu from './pages/acudiente/menu.jsx';

// ---------- Index ---------- //
import Index from './pages/index.jsx';
import Productos from './pages/productos.jsx';
import Contacto from './pages/contacto.jsx';
import Login from './pages/login.jsx';

// ---------- Admin ---------- //
import AdminInicio from './pages/admin/inicio.jsx';

// ---------- Coordinador ---------- //
import CoordinadorInicio from './pages/coordinador/inicio.jsx';

// ---------- Vendedor ---------- //
import VendedorInicio from './pages/vendedor/inicio.jsx';

// ---------- Acudiente ---------- //
import AcudienteInicio from './pages/acudiente/inicio.jsx';

function App() {

  // Obtener el rol del usuario desde localStorage
  const userRole = localStorage.getItem('userRole');

  return (
    <div className="App">
      <BrowserRouter>
        {/* Mostrar el menú según el rol */}
        {userRole === '1' && <AdminMenu />}
        {userRole === '2' && <CoordinadorMenu />}
        {userRole === '3' && <VendedorMenu />}
        {userRole === '4' && <AcudienteMenu />}
        {!userRole && <Menu />}
          <Routes>
            {/* Rutas Index */}
            <Route path="/" element={<Index />} />
            <Route path="/Productos" element={<Productos />} />
            <Route path="/Contacto" element={<Contacto />} />
            <Route path="/Login" element={<Login />} />

            {/* Rutas del Administrador */}
            {userRole === '1' && (
              <Route path="/admin/inicio" element={<AdminInicio />} />

            )}

            {/* Rutas del Coordinador */}
            {userRole === '2' && (
              <Route path="/coordinador/inicio" element={<CoordinadorInicio />} />
            
            )}

            {/* Rutas del Vendedor */}
            {userRole === '3' && (
              <Route path="/vendedor/inicio" element={<VendedorInicio />} />
            
            )}

            {/* Rutas del Acudiente */}
            {userRole === '4' && (
              <Route path="/acudiente/inicio" element={<AcudienteInicio />} />
            
            )}
          </Routes>
      </BrowserRouter>
    </div>
  );
}

export default App;
