import { Link } from 'react-router-dom';

const Footer = () => {
    return (
        <footer className="container-footer">
            <div className="container-div-footer">
                <div className="footer-left">
                    <p><i className="bi bi-c-circle-fill"></i> 2024 NUTRIKIDS.</p>
                </div>

                <div className="footer-center">
                    <nav>
                        <Link to="#">Política de privacidad</Link>
                        <Link to="#">Términos de uso</Link>
                    </nav>
                </div>

                <div className="footer-right">
                    <p>Síguenos en nuestras redes sociales:</p>
                    <div className="social-icons">
                        <a href="#" className="social-icon"><i className="bi bi-facebook"></i></a>
                        <a href="#" className="social-icon"><i className="bi bi-twitter-x"></i></a>
                        <a href="#" className="social-icon"><i className="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
        </footer>
    );
};
  
export default Footer;