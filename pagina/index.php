<?php
/**
 * index.php — Coming Soon CAJAYA ELITE (V52 - Security Shield)
 */
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CajaYa — Muy Pronto el Estreno Élite</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@500;700;900&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        :root {
            --primary: #6A37B7;
            --primary-glow: #9D6CFF;
            --bg-dark: #0D0B14;
            --text-light: #f1f5f9;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; -webkit-font-smoothing: antialiased; }
        body { 
            background: var(--bg-dark); 
            color: var(--text-light); 
            font-family: 'Inter', sans-serif; 
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* BACKGROUND ANIMATION */
        .bg-glow {
            position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
            width: 600px; height: 600px; background: radial-gradient(circle, rgba(106,55,183,0.15) 0%, transparent 70%);
            z-index: 1; filter: blur(60px); animation: pulse 8s infinite ease-in-out;
        }
        @keyframes pulse { 0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; } 50% { transform: translate(-50%, -50%) scale(1.3); opacity: 0.8; } }

        .container { position: relative; z-index: 10; text-align: center; padding: 20px; width: 100%; max-width: 600px; }
        .logo { height: 60px; margin-bottom: 40px; animation: modalUp 0.8s ease; }
        
        h1 { font-family: 'Outfit', sans-serif; font-size: clamp(2.5rem, 8vw, 4.5rem); line-height: 0.9; margin-bottom: 20px; letter-spacing: -3px; }
        h1 span { color: var(--primary-glow); }
        
        p { font-size: 1.2rem; color: #94a3b8; margin-bottom: 50px; line-height: 1.6; }

        .coming-soon-badge {
            display: inline-block; background: rgba(157, 108, 255, 0.1); border: 1px solid var(--primary-glow);
            color: var(--primary-glow); padding: 8px 20px; border-radius: 50px; font-size: 12px; font-weight: 900;
            text-transform: uppercase; letter-spacing: 2px; margin-bottom: 25px;
        }

        /* FORM */
        .glass-card {
            background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05); padding: 40px; border-radius: 35px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5);
        }
        .form-grid { display: grid; grid-template-columns: 1fr; gap: 15px; }
        .input-wrap { position: relative; }
        .input-wrap i { position: absolute; left: 20px; top: 50%; transform: translateY(-50%); color: var(--primary-glow); opacity: 0.6; }
        .form-input { 
            width: 100%; padding: 18px 20px 18px 55px; border-radius: 18px; border: 1px solid rgba(255,255,255,0.1); 
            background: rgba(0,0,0,0.3); color: #fff; font-size: 16px; transition: 0.3s;
        }
        .form-input:focus { outline: none; border-color: var(--primary-glow); background: rgba(0,0,0,0.5); }

        .btn-primary { 
            background: var(--primary); color: #fff; padding: 20px; border-radius: 18px; border: none;
            font-weight: 800; text-transform: uppercase; cursor: pointer; transition: 0.3s;
            box-shadow: 0 15px 30px rgba(106,55,183,0.3); width: 100%; margin-top: 10px;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 20px 40px rgba(106,55,183,0.4); background: var(--primary-glow); }

        @keyframes modalUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        /* COUNTDOWN STYLE (V53) */
        .countdown-container {
            display: flex; justify-content: center; gap: 20px; margin-bottom: 50px; animation: modalUp 1s ease;
        }
        .countdown-item {
            background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);
            backdrop-filter: blur(10px); padding: 20px; border-radius: 20px; min-width: 90px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
        .countdown-value {
            display: block; font-family: 'Outfit', sans-serif; font-size: 2.5rem; font-weight: 900;
            color: var(--primary-glow); line-height: 1; text-shadow: 0 0 20px rgba(157, 108, 255, 0.4);
        }
        .countdown-label {
            display: block; font-size: 10px; text-transform: uppercase; letter-spacing: 2px;
            color: #94a3b8; margin-top: 5px; font-weight: 700;
        }

        @media (max-width: 480px) {
            h1 { font-size: 2.8rem; }
            .glass-card { padding: 30px 20px; }
            .countdown-container { gap: 10px; }
            .countdown-item { min-width: 70px; padding: 15px 10px; }
            .countdown-value { font-size: 1.8rem; }
        }
    </style>
</head>
<body>
    <div class="bg-glow"></div>

    <div class="container">
        <img src="assets/img/logo.png" class="logo" style="filter: brightness(0) invert(1);">
        
        <div class="coming-soon-badge">Estreno Muy Pronto</div>
        <h1>El Futuro del <span>Retail</span> está llegando.</h1>
        
        <div class="countdown-container">
            <div class="countdown-item"><span class="countdown-value" id="days">10</span><span class="countdown-label">Días</span></div>
            <div class="countdown-item"><span class="countdown-value" id="hours">00</span><span class="countdown-label">Horas</span></div>
            <div class="countdown-item"><span class="countdown-value" id="minutes">00</span><span class="countdown-label">Min</span></div>
            <div class="countdown-item"><span class="countdown-value" id="seconds">00</span><span class="countdown-label">Seg</span></div>
        </div>

        <p>Estamos afinando los últimos detalles para el lanzamiento más importante del año. Inscríbete para ser el primero en recibir acceso exclusivo.</p>

        <div class="glass-card" id="formContainer">
            <form onsubmit="handleLead(event, this)" class="form-grid">
                <div class="input-wrap">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="nombre" class="form-input" placeholder="Tu nombre" required>
                </div>
                <div class="input-wrap">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" class="form-input" placeholder="Tu correo electrónico" required>
                </div>
                <div class="input-wrap">
                    <i class="fa-solid fa-whatsapp"></i>
                    <input type="text" name="whatsapp" class="form-input" placeholder="WhatsApp (Ej: +569...)" required>
                </div>
                <input type="hidden" name="provider" value="coming_soon">
                <button type="submit" class="btn-primary">Avisarme del Lanzamiento</button>
            </form>
        </div>
    </div>

    <script>
        // CONFIGURACIÓN DEL LANZAMIENTO (V53)
        // Definimos la fecha objetivo: 10 días a partir de hoy
        const targetDate = new Date();
        targetDate.setDate(targetDate.getDate() + 10);
        targetDate.setHours(0,0,0,0);

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            const d = Math.floor(distance / (1000 * 60 * 60 * 24));
            const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const s = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').innerText = d.toString().padStart(2, '0');
            document.getElementById('hours').innerText = h.toString().padStart(2, '0');
            document.getElementById('minutes').innerText = m.toString().padStart(2, '0');
            document.getElementById('seconds').innerText = s.toString().padStart(2, '0');

            if (distance < 0) {
                clearInterval(interval);
                document.querySelector('.countdown-container').innerHTML = "<h2>¡EL DÍA HA LLEGADO!</h2>";
            }
        }

        const interval = setInterval(updateCountdown, 1000);
        updateCountdown();

        async function handleLead(e, f) {
            e.preventDefault();
            const b = f.querySelector('button'); 
            const originalText = b.innerHTML;
            b.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> REGISTRANDO...';
            b.disabled = true;
            
            try {
                const r = await fetch('save_lead.php', { method: 'POST', body: new FormData(f) });
                if(r.ok) {
                    confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 }, colors: ['#6A37B7', '#ffffff'] });
                    document.getElementById('formContainer').innerHTML = `
                        <div style="text-align:center; padding:20px; animation: modalUp 0.8s ease;">
                            <i class="fa-solid fa-check-circle" style="font-size:4rem; color:#25D366; margin-bottom:20px;"></i>
                            <h2 style="font-family:'Outfit'; font-size:2rem; margin-bottom:10px;">¡Estás en la lista!</h2>
                            <p style="color:#94a3b8;">Te contactaremos muy pronto con noticias exclusivas.</p>
                        </div>
                    `;
                }
            } catch(e) { 
                b.innerHTML = 'REINTENTAR'; 
                b.disabled = false;
                setTimeout(() => { b.innerHTML = originalText; }, 2000);
            }
        }
    </script>
</body>
</html>
