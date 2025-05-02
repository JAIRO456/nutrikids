import React, { useEffect, useState } from 'react';
// import { Link } from 'react-router-dom';

const Productos = () => {
    const [categorias, setCategorias] = useState([]);

    useEffect(() => {
        fetch('./././backend/ajax/get_categorias.php')
            .then(response => response.json())
            .then(data => setCategorias(data))
            .catch(error => console.error('Error al obtener categorías:', error));
    }, []);

    return (
        <main className="container-main">
            <section className="container-productos">
                {categorias.map(category => (
                    <div key={category.id_categoria} className="productos">
                        <a href={`productos2.php?categoria=${category.id_categoria}`}>
                            <img src={`img/categories/${category.imagen}`} alt="" />
                        </a>
                        <h3>{category.categoria}</h3>
                    </div>
                ))}
            </section>
        </main>
    );
};
  
export default Productos;