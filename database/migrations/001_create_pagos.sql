-- Migración: Tabla de pagos para registro de transacciones Flow y MercadoPago
-- Ejecutar en PostgreSQL: psql -U postgres -d cajaya -f 001_create_pagos.sql

CREATE TABLE IF NOT EXISTS pagos (
    id               SERIAL PRIMARY KEY,

    -- Referencia de la orden interna (ej: CJY-LIFETIME-1714500000)
    commerce_order   VARCHAR(100) NOT NULL UNIQUE,

    -- Token de la pasarela (Flow token o MP payment_id)
    flow_token       VARCHAR(255),
    mp_payment_id    VARCHAR(100),

    -- Datos del comprador
    email            VARCHAR(255) NOT NULL,

    -- Plan contratado: mensual | anual | lifetime | empresa
    plan             VARCHAR(50)  NOT NULL DEFAULT 'lifetime',

    -- Monto en CLP
    amount           INTEGER      NOT NULL DEFAULT 0,

    -- Estado del pago: paid | pending | failed | cancelled | refunded
    status           VARCHAR(30)  NOT NULL DEFAULT 'pending',

    -- Pasarela usada: flow | mercadopago
    gateway          VARCHAR(30)  NOT NULL DEFAULT 'flow',

    -- Licencia generada asociada al pago
    license_key      VARCHAR(50),

    -- Cuándo vence (NULL = lifetime)
    expires_at       TIMESTAMP,

    -- Timestamps
    created_at       TIMESTAMP    NOT NULL DEFAULT NOW(),
    updated_at       TIMESTAMP    NOT NULL DEFAULT NOW()
);

-- Índices para búsquedas frecuentes
CREATE INDEX IF NOT EXISTS idx_pagos_email       ON pagos (email);
CREATE INDEX IF NOT EXISTS idx_pagos_flow_token  ON pagos (flow_token);
CREATE INDEX IF NOT EXISTS idx_pagos_license_key ON pagos (license_key);
CREATE INDEX IF NOT EXISTS idx_pagos_status      ON pagos (status);

-- Trigger para actualizar updated_at automáticamente
CREATE OR REPLACE FUNCTION update_pagos_timestamp()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_pagos_updated ON pagos;
CREATE TRIGGER trg_pagos_updated
    BEFORE UPDATE ON pagos
    FOR EACH ROW
    EXECUTE FUNCTION update_pagos_timestamp();

COMMENT ON TABLE  pagos IS 'Registro de todos los pagos recibidos vía Flow y MercadoPago';
COMMENT ON COLUMN pagos.gateway IS 'Pasarela de pago: flow | mercadopago';
COMMENT ON COLUMN pagos.status  IS 'paid | pending | failed | cancelled | refunded';
