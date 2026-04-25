-- ======================================================================
-- SCRIPT DE INICIALIZACIÓN PARA POSTGRES (Supabase / Local)
-- Proyecto: CajaYa POS
-- ======================================================================

-- 1. SOLUCIÓN AL ERROR DE UUID
-- En versiones modernas de PostgreSQL es mejor usar la función nativa `gen_random_uuid()`.
-- Por si acaso, habilitamos la extensión clásica:
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- ======================================================================
-- 2. SIMULACIÓN DE SUPABASE (Solo necesario en tu pgAdmin local)
-- Si corres esto en la nube de Supabase, estas dos instrucciones no son 
-- necesarias porque Supabase ya trae el esquema "auth" por defecto.
-- ======================================================================
CREATE SCHEMA IF NOT EXISTS auth;
CREATE TABLE IF NOT EXISTS auth.users (
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    email VARCHAR(255) UNIQUE,
    raw_user_meta_data JSONB
);

-- ======================================================================
-- 3. CÓDIGO REAL DE TU APLICACIÓN (Arquitectura Multi-Tenant)
-- ======================================================================

-- Tabla para aislar a cada Minimarket (El "Tenant")
CREATE TABLE IF NOT EXISTS public.tenants (
    -- Usamos gen_random_uuid() para evitar el error de librería en pgAdmin
    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    name VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT now(),
    is_demo BOOLEAN DEFAULT true
);

-- Tabla de Usuarios (Cajeros/Dueños) vinculados al Minimarket
CREATE TABLE IF NOT EXISTS public.profiles (
    id UUID PRIMARY KEY REFERENCES auth.users(id) ON DELETE CASCADE,
    tenant_id UUID REFERENCES public.tenants(id),
    email VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    role VARCHAR(50) DEFAULT 'admin'
);

-- ======================================================================
-- 4. LA MAGIA: TRIGGER DE AUTOMATIZACIÓN
-- ======================================================================
CREATE OR REPLACE FUNCTION public.handle_new_user()
RETURNS trigger AS $$
DECLARE
    new_tenant_id UUID;
BEGIN
    -- A. Crea automáticamente el local de Demo
    INSERT INTO public.tenants (name, is_demo) 
    VALUES ('Local Demo de ' || NEW.email, true)
    RETURNING id INTO new_tenant_id;

    -- B. Vincula al usuario de Google/Microsoft con ese nuevo local
    INSERT INTO public.profiles (id, tenant_id, email, full_name)
    VALUES (NEW.id, new_tenant_id, NEW.email, NEW.raw_user_meta_data->>'full_name');

    RETURN NEW;
END;
$$ LANGUAGE plpgsql SECURITY DEFINER;

-- Limpiamos el trigger si ya existía (por si corres el script varias veces)
DROP TRIGGER IF EXISTS on_auth_user_created ON auth.users;

-- Se activa cada vez que entra un correo nuevo en la tabla auth.users
CREATE TRIGGER on_auth_user_created
    AFTER INSERT ON auth.users
    FOR EACH ROW EXECUTE FUNCTION public.handle_new_user();
