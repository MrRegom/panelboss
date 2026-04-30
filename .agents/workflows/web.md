---
description: web
---

Regla de intervención controlada sobre cajaya.cl

Importante: Las modificaciones deben ser estrictamente acotadas.

No se permite la alteración completa del archivo index.
No se debe reestructurar la arquitectura general del sitio.
Solo se deben aplicar cambios en las secciones explícitamente indicadas en cada requerimiento.

Lineamientos técnicos:

Scope cerrado
Modificar únicamente los bloques/elementos especificados.
No tocar <head>, scripts globales ni estilos base, salvo indicación explícita.

Integridad del sistema

Mantener compatibilidad con JS existente.
No romper eventos, listeners ni integraciones activas.
Estrategia recomendada

Trabajar con identificadores únicos (id, data-*) para aislar cambios.
Evitar sobreescritura masiva de CSS.
Preferir inyección modular (componentes o funciones JS encapsuladas).