# Workflow: Desarrollo Web CajaYa Elite

Este workflow guía el desarrollo y despliegue del ecosistema CajaYa, asegurando la integridad entre el entorno local y el servidor real.

## 🚨 REGLA CRÍTICA: ARQUITECTURA DUAL
**El proyecto vive en dos mundos:**
1. **LOCAL (XAMPP):** Donde desarrollamos y probamos.
2. **PRODUCCIÓN (Hostinger - panel.cajaya.cl):** Donde vive la web real.

### Protocolo de Base de Datos
- **Problema:** Los comandos de consola en el agente SOLO afectan a la BD Local.
- **Solución Obligatoria:** Implementar lógica de **Auto-Sanación (Self-Healing)** en los controladores/vistas administrativas. 
- **Ejemplo:** Antes de mostrar un recurso crítico (como un plan de precios), el código debe verificar si existe en la BD actual y crearlo si no existe. Esto asegura que al hacer `git pull` en Hostinger, la base de datos remota se actualice sola.

## Estándares de Diseño
- **Estética:** Premium, modo oscuro, tipografía 'Outfit'.
- **Componentes:** Usar el sistema de diseño de CajaYa (Morado corporativo #6A1B9A, Neón, KenBurns en Hero).
- **Responsive:** Mobile-First. Probar siempre que el Hero y las tablas de precios se adapten a celulares.

## Despliegue
1. Validar cambios en Local.
2. `git add .`
3. `git commit -m "Descripción técnica"`
4. `git push origin main`
5. (Manual) Ejecutar `git pull` en el terminal de Hostinger.

## 🛡️ INTEGRIDAD DEL CÓDIGO Y ESTABILIDAD
**¡REGLA CRÍTICA DE MODIFICACIÓN!**
- **PROHIBICIÓN TOTAL:** No reescribas ni elimines secciones de la landing page (`index.php`) o el panel que ya estén aprobadas y funcionales (FAQ, Animaciones, Estilos, Footer).
- **MODIFICACIÓN QUIRÚRGICA:** Solo modifica los elementos específicos solicitados por el usuario.
- **RESPETO AL DISEÑO:** Si el usuario dice que la web está "espectacular", cualquier cambio debe realizarse SIN alterar el CSS global o la estructura de las secciones existentes, a menos que sea estrictamente necesario para la funcionalidad solicitada.
- **BACKUP MENTAL:** Antes de cada cambio, verifica que no estás simplificando el código eliminando detalles "premium" previos.