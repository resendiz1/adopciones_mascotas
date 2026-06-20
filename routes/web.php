<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Dashboard\AdoptanteDashboardController;
use App\Http\Controllers\Dashboard\RefugioDashboardController;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\MascotaPublicController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\AdopcionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SaludController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\VisitaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', AdminDashboardController::class)->name('dashboard.admin');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
        Route::get('/refugios', [AdminController::class, 'refugios'])->name('refugios');
        Route::get('/mascotas', [AdminController::class, 'mascotas'])->name('mascotas');
        Route::get('/solicitudes', [AdminController::class, 'solicitudes'])->name('solicitudes');
        Route::get('/adopciones', [AdminController::class, 'adopciones'])->name('adopciones');
    });
});

Route::middleware(['auth', 'role:refugio'])->group(function () {
    Route::get('/dashboard/refugio', RefugioDashboardController::class)->name('dashboard.refugio');
    Route::prefix('refugio')->name('refugio.')->group(function () {
        Route::get('/perfil', [ShelterController::class, 'edit'])->name('shelter.edit');
        Route::put('/perfil', [ShelterController::class, 'update'])->name('shelter.update');
        Route::get('/mascotas', [MascotaController::class, 'index'])->name('mascotas.index');
        Route::get('/mascotas/crear', [MascotaController::class, 'create'])->name('mascotas.create');
        Route::post('/mascotas', [MascotaController::class, 'store'])->name('mascotas.store');
        Route::get('/mascotas/{mascota}/editar', [MascotaController::class, 'edit'])->name('mascotas.edit');
        Route::put('/mascotas/{mascota}', [MascotaController::class, 'update'])->name('mascotas.update');
        Route::delete('/mascotas/{mascota}', [MascotaController::class, 'destroy'])->name('mascotas.destroy');
        Route::get('/solicitudes', [SolicitudController::class, 'recibidas'])->name('solicitudes.recibidas');
        Route::get('/solicitudes/{solicitud}', [SolicitudController::class, 'detalle'])->name('solicitudes.detalle');
        Route::post('/solicitudes/{solicitud}/aprobar', [SolicitudController::class, 'aprobar'])->name('solicitudes.aprobar');
        Route::post('/solicitudes/{solicitud}/rechazar', [SolicitudController::class, 'rechazar'])->name('solicitudes.rechazar');
        Route::get('/adopciones', [AdopcionController::class, 'index'])->name('adopciones.index');
        Route::post('/adopciones/{adopcion}/finalizar', [AdopcionController::class, 'finalizar'])->name('adopciones.finalizar');
        Route::post('/adopciones/{adopcion}/cancelar', [AdopcionController::class, 'cancelar'])->name('adopciones.cancelar');
        Route::get('/mascotas/{mascota}/salud', [SaludController::class, 'index'])->name('mascotas.salud');
        Route::post('/mascotas/{mascota}/vacunas', [SaludController::class, 'storeVacuna'])->name('mascotas.vacunas.store');
        Route::put('/mascotas/{mascota}/vacunas/{vacuna}', [SaludController::class, 'updateVacuna'])->name('mascotas.vacunas.update');
        Route::delete('/mascotas/{mascota}/vacunas/{vacuna}', [SaludController::class, 'destroyVacuna'])->name('mascotas.vacunas.destroy');
        Route::post('/mascotas/{mascota}/eventos', [SaludController::class, 'storeEvento'])->name('mascotas.eventos.store');
        Route::put('/mascotas/{mascota}/eventos/{evento}', [SaludController::class, 'updateEvento'])->name('mascotas.eventos.update');
        Route::delete('/mascotas/{mascota}/eventos/{evento}', [SaludController::class, 'destroyEvento'])->name('mascotas.eventos.destroy');
        Route::get('/adopciones/{adopcion}/visitas', [VisitaController::class, 'index'])->name('adopciones.visitas.index');
        Route::post('/adopciones/{adopcion}/visitas', [VisitaController::class, 'store'])->name('adopciones.visitas.store');
        Route::put('/adopciones/{adopcion}/visitas/{visita}', [VisitaController::class, 'update'])->name('adopciones.visitas.update');
        Route::delete('/adopciones/{adopcion}/visitas/{visita}', [VisitaController::class, 'destroy'])->name('adopciones.visitas.destroy');
        Route::post('/visitas/{visita}/fotos', [VisitaController::class, 'storeFoto'])->name('visitas.fotos.store');
        Route::delete('/visitas/{visita}/fotos/{foto}', [VisitaController::class, 'destroyFoto'])->name('visitas.fotos.destroy');
        Route::get('/adopciones/{adopcion}/reportes', [ReporteController::class, 'index'])->name('adopciones.reportes.index');
        Route::put('/adopciones/{adopcion}/reportes/{reporte}', [ReporteController::class, 'update'])->name('adopciones.reportes.update');
    });
});

Route::middleware(['auth', 'role:adoptante'])->group(function () {
    Route::get('/dashboard/adoptante', AdoptanteDashboardController::class)->name('dashboard.adoptante');
    Route::get('/favoritos', [FavoritoController::class, 'index'])->name('favoritos.index');
    Route::post('/favoritos/{mascota}', [FavoritoController::class, 'toggle'])->name('favoritos.toggle');
    Route::get('/solicitudes', [SolicitudController::class, 'misSolicitudes'])->name('solicitudes.mis-solicitudes');
    Route::post('/solicitudes/{mascota}', [SolicitudController::class, 'create'])->name('solicitudes.create');
    Route::get('/solicitudes/{solicitud}/cuestionario', [SolicitudController::class, 'cuestionario'])->name('solicitudes.cuestionario');
    Route::post('/solicitudes/{solicitud}/cuestionario', [SolicitudController::class, 'guardarCuestionario'])->name('solicitudes.guardar-cuestionario');
    Route::get('/adopciones', [ReporteController::class, 'misAdopciones'])->name('adoptante.adopciones.index');
    Route::get('/adopciones/{adopcion}/reportes/crear', [ReporteController::class, 'create'])->name('adoptante.reportes.create');
    Route::post('/adopciones/{adopcion}/reportes', [ReporteController::class, 'store'])->name('adoptante.reportes.store');
    Route::get('/reportes/{reporte}/fotos', [ReporteController::class, 'fotosForm'])->name('adoptante.reportes.fotos');
    Route::post('/reportes/{reporte}/fotos', [ReporteController::class, 'storeFoto'])->name('adoptante.reportes.fotos.store');
    Route::delete('/reportes/{reporte}/fotos/{foto}', [ReporteController::class, 'destroyFoto'])->name('adoptante.reportes.fotos.destroy');
});

Route::get('/mascotas', [MascotaPublicController::class, 'index'])->name('mascotas.public.index');
Route::get('/mascotas/{mascota}', [MascotaPublicController::class, 'show'])->name('mascotas.public.show');
