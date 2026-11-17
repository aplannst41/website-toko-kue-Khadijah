# Project: Sweet Crumbs Bakery (Toko Kue)
Framework: Laravel 10/11 (PHP 8.2+) + Blade + TailwindCSS + MySQL

## Model Usage Guidelines
- **Complex Architecture / Deep Reasoning:** Use `Gemini 4 Argon` or `Claude Opus` (e.g. payment calculations, checkout multi-step flow, tricky database migrations).
- **Standard Feature Implementation:** Use `Claude Sonnet` or `Cursor Sol (cx/gpt-6.1-sol)` (controllers, Eloquent queries, form validation).
- **Fast UI & Blade Tweaks:** Use `Gemini Flash` (rapid template tweaks, responsive styling, quick checks).

## 9Router Gateway Integration
- Local Gateway URL: `http://localhost:20128/v1`
- Test connection script available: `.\test-argon.ps1`
- Environment variables: `.env.ai`

## Coding Standards for This Project
1. **Security & Validation:** Always validate incoming requests using Form Requests or `$request->validate([...])`.
2. **Eloquent & Database:** Use proper Eloquent relationships (`belongsTo`, `hasMany`) and avoid N+1 query issues.
3. **Frontend UI:** Use clean Blade templating, extend `layouts.frontend` or `layouts.admin`, and follow the bakery's warm, premium design aesthetic.
4. **Indonesian Localization:** Customer-facing texts, error messages, and payment labels should be natural and friendly in Indonesian.
