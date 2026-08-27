-- Regen Med Health — Supabase (Postgres) Schema
-- Run this in Supabase Dashboard > SQL Editor
-- Tables: registrants, health_practitioners (+ scan_submissions for uploads)

-- Enable UUID generation
create extension if not exists "pgcrypto";

-- 1) Registrants: people who register on Regen Med Health
create table if not exists public.registrants (
  id uuid primary key default gen_random_uuid(),
  user_id uuid references auth.users(id) on delete set null,
  full_name text not null,
  email text unique not null,
  phone text,
  whatsapp text,
  date_of_birth date,
  gender text check (gender in ('male','female','other','prefer_not_to_say')),
  address text,
  city text,
  state text,
  country text default 'Nigeria',
  registration_type text default 'self' check (registration_type in ('self','family','referral','practitioner_referral')),
  referred_by uuid references public.registrants(id) on delete set null,
  medical_history jsonb default '{}'::jsonb,
  allergies text,
  current_medications text,
  status text not null default 'active' check (status in ('active','inactive','archived')),
  consent_given boolean default false,
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now()
);

-- 2) Health Practitioners: doctors, nurses, specialists, therapists
create table if not exists public.health_practitioners (
  id uuid primary key default gen_random_uuid(),
  user_id uuid references auth.users(id) on delete set null,
  full_name text not null,
  email text unique not null,
  phone text,
  whatsapp text,
  specialization text not null, -- e.g. Cardiology, Radiology, Regenerative Medicine
  specializations text[] default '{}',
  license_number text unique,
  qualification text, -- e.g. MBBS, FWACP, US Board Certified
  institution text, -- hospital / clinic name
  years_experience int check (years_experience >= 0),
  bio text,
  avatar_url text,
  is_verified boolean not null default false,
  verification_notes text,
  consultation_fee numeric(10,2),
  currency text default 'NGN',
  availability jsonb default '{}'::jsonb, -- { mon:[{start:"09:00",end:"17:00"}], ...}
  languages text[] default '{English}',
  status text not null default 'pending' check (status in ('pending','active','suspended','archived')),
  created_at timestamptz not null default now(),
  updated_at timestamptz not null default now()
);

-- 3) Scan submissions: uploaded lab scans awaiting/after AI analysis
create table if not exists public.scan_submissions (
  id uuid primary key default gen_random_uuid(),
  registrant_id uuid references public.registrants(id) on delete set null,
  practitioner_id uuid references public.health_practitioners(id) on delete set null,
  modality text not null check (modality in ('Knee MRI','Retinal OCT','Prostate mpMRI','Fertility Ultrasound','General','MRI','CT','Ultrasound','OCT','X-ray','PET','Other')),
  file_name text,
  file_path text, -- Supabase Storage path (bucket: scans)
  file_size int,
  file_type text,
  notes text,
  ai_backend text check (ai_backend in ('heuristic','local-gpu','cloud-gpu')),
  ai_findings text,
  ai_confidence numeric(5,2),
  gpu_info jsonb default '{}'::jsonb,
  status text not null default 'pending' check (status in ('pending','processing','reviewed','archived')),
  created_at timestamptz not null default now(),
  reviewed_at timestamptz
);

-- Updated_at triggers
create or replace function public.handle_updated_at()
returns trigger language plpgsql as $$
begin new.updated_at = now(); return new; end; $$;

drop trigger if exists trg_registrants_updated on public.registrants;
create trigger trg_registrants_updated before update on public.registrants for each row execute function public.handle_updated_at();

drop trigger if exists trg_practitioners_updated on public.health_practitioners;
create trigger trg_practitioners_updated before update on public.health_practitioners for each row execute function public.handle_updated_at();

-- Indexes
create index if not exists idx_registrants_email on public.registrants(email);
create index if not exists idx_registrants_phone on public.registrants(phone);
create index if not exists idx_registrants_created on public.registrants(created_at desc);
create index if not exists idx_practitioners_email on public.health_practitioners(email);
create index if not exists idx_practitioners_specialization on public.health_practitioners(specialization);
create index if not exists idx_practitioners_verified on public.health_practitioners(is_verified);
create index if not exists idx_scan_registrant on public.scan_submissions(registrant_id);
create index if not exists idx_scan_practitioner on public.scan_submissions(practitioner_id);
create index if not exists idx_scan_created on public.scan_submissions(created_at desc);

-- Row Level Security
alter table public.registrants enable row level security;
alter table public.health_practitioners enable row level security;
alter table public.scan_submissions enable row level security;

-- Permissive policies for now (tighten after you enable Supabase Auth as needed)
-- Allow service_role full access (bypasses RLS anyway), and anon/authenticated read/write for app
drop policy if exists "Allow all for registrants" on public.registrants;
create policy "Allow all for registrants" on public.registrants for all using (true) with check (true);

drop policy if exists "Allow all for practitioners" on public.health_practitioners;
create policy "Allow all for practitioners" on public.health_practitioners for all using (true) with check (true);

drop policy if exists "Allow all for scans" on public.scan_submissions;
create policy "Allow all for scans" on public.scan_submissions for all using (true) with check (true);

-- Storage bucket for scan uploads (run separately if bucket not exists)
-- insert into storage.buckets (id, name, public) values ('scans','scans', false) on conflict (id) do nothing;
-- Then add storage policies for bucket 'scans' in Dashboard > Storage.

-- Sample seed (optional, comment out if not needed)
-- insert into public.health_practitioners (full_name, email, specialization, qualification, institution, years_experience, is_verified, status) values
-- ('Dr. David Ikudayisi','david.ikudayisi@example.com','Regenerative Medicine','MD — US Board Certified Internist','Glory Wellness & Regenerative Centre', 20, true, 'active');
