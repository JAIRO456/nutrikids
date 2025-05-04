import React, { useEffect, useState } from 'react';
import { useNavigate } from 'react-router-dom';

function Login() {
    const [documento, setDocumento] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState('');
    const navigate = useNavigate();

    const handleSubmit = (e) => {
        e.preventDefault();
    
        const data = { documento, password };
        fetch("http://localhost/react/nutrikids/backend/include/validate_login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                // Guardar el rol del usuario en localStorage, es como una "caja" del navegador .-.
                localStorage.setItem('userRole', data.rol);
            // Redirigir o mostrar mensaje de éxito :V
                switch (data.rol) {
                    case 1:
                        navigate('/admin/inicio');
                        let userRole = data.rol;
                        break;
                    case 2:
                        navigate('/coordinador/inicio');
                        break;
                    case 3:
                        navigate('/vendedor/inicio');
                        break;
                    case 4:
                        navigate('/acudiente/inicio');
                        break;
                    default:
                        navigate('/');
                }
            } 
            else {
                setError(data.message || "Error en el login.");
            }
        })
        .catch(err => {
            setError("Error de conexión.");
            console.error(err);
        });
    };

    return (
        <main className="container-main">
            <section className="container-section">
                <h1 className="title">NUTRIKIDS</h1>
                <p className="subtitle">"Elige sabiamente para garantizar el bienestar y el futuro de tus hijos..."</p>
            </section>
    
            <section className="container-section2">
                <h1 className="title2">INICIO SESION</h1>
                <form className="form1" onSubmit={handleSubmit}>
                    <div className="x_grupo" id="x_documento">
                        <label htmlFor="documento">Documento</label>
                        <div className="x_input">
                            <input 
                                type="number"
                                id="documento"
                                name="documento"
                                placeholder="Ingrese sus documentos"
                                value={documento}
                                onChange={(e) => setDocumento(e.target.value)}
                              />
                            <i className="form_estado bi bi-exclamation-circle-fill"></i>
                        </div>
                    </div>
    
                    <div className="x_grupo" id="x_password">
                        <label htmlFor="password">Contraseña</label>
                        <div className="x_input">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Ingrese su contraseña"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                            />
                            <i className="form_estado bi bi-exclamation-circle-fill"></i>
                        </div>
                    </div>
    
                    {error && <p className="x_typerror">{error}</p>}
                    <button type="submit" id="botton">ENVIAR</button>
                    <button type="button" className="btn red">REGRESAR</button>
                </form>
            </section>
        </main>
      );
    };
    
export default Login;