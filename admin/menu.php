<?php
    $doc = $_SESSION['documento'];
    $sql = $con -> prepare("SELECT * FROM usuarios INNER JOIN roles ON usuarios.id_rol = roles.id_rol
    INNER JOIN estados ON usuarios.id_estado = estados.id_estado WHERE usuarios.documento = ?");
    $sql -> execute([$doc]);
    $u = $sql -> fetch();

    $sqlCategories = $con -> prepare("SELECT * FROM categorias");
    $sqlCategories -> execute();
    $Categories = $sqlCategories -> fetchALL(PDO::FETCH_ASSOC);
?>

<style>
.menu {
    background:rgb(42, 46, 51);
    padding: 1rem;
    position: fixed;
    top: 0;
    width: 100%;
    height: 15%;
    box-shadow: 0 2px 4px rgba(0,0,0,.1);
    z-index: 1000;
}

.menu-container {
    height: 100%;
    align-items: center;
    justify-content: center;
    max-width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    display: flex;
    align-items: center;
    color: white;
    text-decoration: none;
    font-weight: bold;
}

.logo span {
    margin-left: 10px;
    font-size: 20px;
}

.menu-toggle {
    display: none;
    flex-direction: column;
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
}

.menu-toggle span {
    width: 25px;
    height: 3px;
    background: white;
    margin: 2px 0;
    transition: 0.3s;
}

.menu-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.menu-list, .menu-user {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}

.menu-list li, .menu-user li {
    margin: 0 15px;
}

.menu-list a, .menu-user a {
    color: #fff;
    text-decoration: none;
    padding: 5px 0;
    position: relative;
    transition: color 0.3s;
}

.menu-list a::after, .menu-user a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: 0;
    left: 0;
    background: white;
    transition: width 0.3s;
}

.menu-list a:hover::after, .menu-user a:hover::after {
    width: 100%;
}

.dropdown {
    position: relative;
}

.dropdown-content {
    display: none;
    position: absolute;
    background: white;
    min-width: 160px;
    background:rgb(42, 46, 51);
    box-shadow: 0 2px 10px rgba(0,0,0,.1);
    border-radius: 4px;
    z-index: 1;
}

.dropdown-content a {
    color: white;
    padding: 12px 16px;
    display: block;
    transition: 0.3s;
}

.dropdown-content a:hover {
    background:rgb(42, 46, 51);
    transform: translateX(5px);
}

.divider {
    height: 1px;
    background: #ddd;
    margin: 5px 0;
}

.logout {
    color: #dc3545 !important;
}

.rol {
    background: #fff;
    color: #343a40;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8em;
    margin-left: 5px;
}

@media (max-width: 768px) {
    .menu {
        height: 10%;
    }
    .menu-toggle {
        display: flex;
    }

    .menu-content {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background:rgb(42, 46, 51);
        flex-direction: column;
        padding: 20px;
    }

    .menu-list li, .menu-user li {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        place-items: center;
    }

    .menu-content.active {
        display: flex;
    }

    .menu-list, .menu-user {
        flex-direction: column;
        width: 100%;
    }

    .menu-list li, .menu-user li {
        margin: 10px 0;
    }

    .dropdown-content {
        position: center;
        text-align: center;
        background: rgba(255,255,255);
        box-shadow: none;
    }
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<nav class="menu">
    <div class="menu-container">
        <a class="logo" href="#">
            <img src="../img/logo-nutrikids2.png" width="50" height="50" alt="Logo">
            <span>NUTRIKIDS</span>
        </a>
        
        <button class="menu-toggle" onclick="toggleMenu()">
            <span></span>
            <span></span> 
            <span></span>
        </button>

        <div class="menu-content">
            <ul class="menu-list">
                <li><a onclick="window.location.href='inicio.php'"><i class="fa-solid fa-house"></i> Inicio</a></li>
                <li><a onclick="window.location.href='directores.php'"><i class="fa-solid fa-user-tie"></i>  Directores</a></li>
                <li><a onclick="window.location.href='escuelas.php'"><i class="fa-solid fa-school"></i>  Escuelas</a></li>
                <li><a onclick="window.location.href='productos.php'"><i class="fa-solid fa-basket-shopping"></i>  Productos</a></li>
                <li><a onclick="window.location.href='licencias.php'"><i class="fa-solid fa-file-pen"></i>  Licencias</a></li>
            </ul>
            <ul class="menu-user">
                <li class="dropdown">
                    <a href="#" onclick="toggleDropdown('usuario')">
                        <i class="fa-solid fa-user"></i>
                        <?php echo $u['nombre'] . ' ' . $u['apellido']; ?>
                        <span class="rol"><?php echo $u['rol']; ?></span>
                    </a>
                    <div class="dropdown-content" id="usuario">
                        <a onclick="window.location.href='cuenta.php'">Mi Cuenta</a>
                        <div class="divider"></div>
                        <a onclick="window.location.href='../include/logout.php'" class="logout">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
function toggleMenu() {
    document.querySelector('.menu-content').classList.toggle('active');
}

function toggleDropdown(id) {
    const dropdown = document.getElementById(id);
    const allDropdowns = document.getElementsByClassName('dropdown-content');
    
    // Cerrar todos los dropdowns excepto el actual
    Array.from(allDropdowns).forEach(d => {
        if (d.id !== id) {
            d.style.display = 'none';
        }
    });
    
    // Alternar el dropdown actual
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}

// Cerrar dropdowns al hacer clic fuera
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown')) {
        const dropdowns = document.getElementsByClassName('dropdown-content');
        Array.from(dropdowns).forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    }
});
</script>
