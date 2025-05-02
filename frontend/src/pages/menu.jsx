import { Link } from 'react-router-dom';

const Menu = () => {
    const toggleMenu = () => {
        const menu = document.getElementById('menu');
        menu.classList.toggle('active');
    }
    
    return (
        <header className="container-header">
            <div className="container-div-menu">
                <div className="container-logo-header">
                    <Link to="/">
                        <img className="logo" src="img/logo-nutrikids.png" alt="Logo Nutrikids" />
                    </Link>
                </div>

                <div className="menu-icon" onClick={toggleMenu}>
                    <i className="menu-icons bi bi-list"></i>
                </div>

                <nav className="container-opciones-header" id="menu"> 
                    <Link to="/">INICIO</Link>
                    <Link to="/productos">PRODUCTOS</Link>
                    <Link to="/contacto">CONTACTO</Link>
                </nav>

                <div className="container-login-header">
                    <Link to="/login">
                        <button className="login">INICIAR SESIÓN</button>
                    </Link>
                </div>
            </div>  
        </header>
    );
};

export default Menu;