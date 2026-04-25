document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // 1. ANIMACIONES VISUALES (Fade-In al hacer Scroll)
    // ==========================================
    const observerOptions = {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px"
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target); // Solo animar la primera vez
            }
        });
    }, observerOptions);

    // Seleccionamos todo lo que tiene la clase fade-in para observarlo
    document.querySelectorAll('.fade-in').forEach(element => {
        observer.observe(element);
    });

    // ==========================================
    // 2. CONEXIÓN API PHP (Formulario Manual)
    // ==========================================
    const manualForm = document.querySelector('.modern-form');
    
    if (manualForm) {
        manualForm.addEventListener('submit', async (e) => {
            e.preventDefault(); // Evitamos recargar la página
            
            const emailInput = manualForm.querySelector('input[type="email"]');
            const submitBtn = manualForm.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerText;
            
            // UX: Estado de carga
            submitBtn.innerText = 'Conectando a BD...';
            submitBtn.disabled = true;

            try {
                // Llamamos a nuestra nueva API en PHP
                const response = await fetch('api/index.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email: emailInput.value })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    alert('✅ ' + data.message);
                    emailInput.value = ''; // Limpiamos el campo
                } else {
                    alert('❌ Error: ' + data.message);
                }
            } catch (error) {
                console.error(error);
                alert('❌ Ocurrió un error de red al conectar con el servidor.');
            } finally {
                // Restauramos el botón
                submitBtn.innerText = originalText;
                submitBtn.disabled = false;
            }
        });
    }

    // ==========================================
    // 3. SIMULACIÓN DE BOTONES SOCIAL LOGIN
    // ==========================================
    const btnGoogle = document.querySelector('.btn-google');
    const btnMicrosoft = document.querySelector('.btn-microsoft');

    if (btnGoogle) {
        btnGoogle.addEventListener('click', async () => {
            const originalHTML = btnGoogle.innerHTML;
            btnGoogle.innerHTML = '⏳ Autorizando con Google...';
            btnGoogle.disabled = true;

            // Simulamos el tiempo de espera de la ventana de Google
            setTimeout(async () => {
                try {
                    // Supongamos que Google nos devolvió este correo
                    const mockEmail = `contacto${Math.floor(Math.random() * 1000)}@gmail.com`;
                    
                    const response = await fetch('api/index.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ email: mockEmail })
                    });

                    const data = await response.json();
                    if (data.success) {
                        alert(`✅ ¡Simulación de Google Exitosa!\n\nGoogle autorizó el correo: ${mockEmail}\nEl Trigger de Postgres ya creó el local. ¡Revisa tu pgAdmin!`);
                    }
                } catch (e) {
                    alert('❌ Ocurrió un error conectando a tu base de datos local.');
                } finally {
                    btnGoogle.innerHTML = originalHTML;
                    btnGoogle.disabled = false;
                }
            }, 1500); // 1.5 segundos de simulación
        });
    }

    if (btnMicrosoft) {
        btnMicrosoft.addEventListener('click', () => {
            alert('ℹ️ En producción, este botón abrirá la ventana oficial de Microsoft Azure AD.');
        });
    }
});
