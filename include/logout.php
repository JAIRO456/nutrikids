<?php
    session_start();
    unset($_SESSION['documento'], $_SESSION['rol'], $_SESSION['estate']);
    session_destroy();
    session_write_close();

    echo "  <style>
                .modal {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    justify-content: center;
                    align-items: center;
                }
                .modal-content {
                    background: white;
                    padding: 20px;
                    border-radius: 8px;
                    text-align: center;
                    width: 300px;
                }
                button {
                    padding: 10px 20px;
                    background: #007bff;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }
                button:hover {
                    background: #0056b3;
                }
            </style>
            <div id='validateSesionModal' class='modal'>
                <div class='modal-content'>
                    <p id='Message'></p>
                    <button onclick='closeModal()'>Cerrar</button>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    showModal('Sesión cerrada');
                    setTimeout(() => {
                        window.location.href = '../login.html';
                    }, 2000);
                });

                const validateSesionModal = document.getElementById('validateSesionModal');
                const message = document.getElementById('Message');

                function showModal(msg) {
                    message.textContent = msg;
                    validateSesionModal.style.display = 'flex';
                }
                function closeModal() {
                    validateSesionModal.style.display = 'none';
                }
            </script>";
    exit();
?>