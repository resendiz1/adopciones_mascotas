# Project Context: Adopciones Mascotas

## Goal
Multi-phase Laravel adoption platform with auth/roles, mascotas CRUD, public catalog, favoritos, solicitudes, refugio review, adopciones, and health records.

## Stack
- Laravel (no auth packages), Bulma CSS, MySQL
- Roles: admin, refugio, adoptante

## Database Tables
- users, shelters, mascotas, fotos_mascota, favoritos
- solicitudes_adopcion, cuestionario_adopcion, adopciones
- vacunas (catálogo: Rabia, Moquillo, Parvovirus, Triple felina, Bordetella)
- mascota_vacunas (pivot con fecha_aplicacion, proxima_dosis, notas)
- eventos_medicos (fecha, tipo, titulo_evento, notas)

## Routes Structure
- `/` — welcome
- `/register`, `/login`, `/logout`
- `/dashboard/admin`, `/dashboard/refugio`, `/dashboard/adoptante`
- `/refugio/*` — shelter management (mascotas CRUD, solicitudes, adopciones, salud)
- `/adoptante/*` — favoritos, solicitudes
- `/mascotas` — public catalog, `/mascotas/{id}` — detail

## Key Business Rules
- Solicitud pendiente → mascota status = pendiente
- Aprobar solicitud → crea Adopcion (activa), mascota = adoptada, otras solicitudes pendientes = rechazadas
- Rechazar → mascota vuelve disponible si no hay otras pendientes
- Adopcion status: activa, finalizada, cancelada
- Refugio puede finalizar/cancelar adopciones
- Salud: vacunas desde catálogo + eventos médicos por mascota

## Seeded Data
- admin@example.com / refugio@example.com / adoptante@example.com (password: password)
- 3 mascotas (Luna, Misi, Max), 5 vacunas catálogo

## Implemented Phases
1. Auth, roles, dashboards, mascotas CRUD, public catalog
2. Favoritos, solicitudes, cuestionario
3. Adopciones (aprobación, rechazo, finalizar, cancelar)
4. Salud (vacunas + eventos médicos)
5. Navbar: refugio sees Solicitudes + Adopciones links; adoptante sees Mis adopciones
6. Post-adopción: visitas de seguimiento con fotos, reportes del adoptante
7. Panel admin completo: dashboard con estadísticas, listados de usuarios/refugios/mascotas/solicitudes/adopciones
8. Aprobación de refugios: admin autoriza perfiles de refugio (status pendiente/aprobado/rechazado), shelter pendiente no puede gestionar mascotas/solicitudes/adopciones hasta ser aprobado

## Last Task
- Implemented refugio approval flow: `status` column on shelters table, middleware `shelter.approved`, admin approve/reject, notifications on refugio dashboard
