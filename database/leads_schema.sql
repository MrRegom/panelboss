-- ======================================================================
-- TABLA DE LEADS (PROSPECTOS)
-- Para capturar info de Google/Microsoft OAuth
-- ======================================================================

CREATE TABLE IF NOT EXISTS leads (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    email VARCHAR(255) UNIQUE NOT NULL,
    full_name VARCHAR(255),
    provider VARCHAR(50), -- 'google', 'microsoft', 'manual'
    provider_id VARCHAR(255), -- ID único que nos da Google/MS
    avatar_url TEXT,
    demo_license_key VARCHAR(50), -- La llave que le regalamos
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Index para búsquedas rápidas por email
CREATE INDEX IF NOT EXISTS idx_leads_email ON leads(email);
