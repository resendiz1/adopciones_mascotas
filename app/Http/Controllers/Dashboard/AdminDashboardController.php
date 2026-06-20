<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Adopcion;
use App\Models\Mascota;
use App\Models\SolicitudAdopcion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        $totalUsers = User::count();
        $totalAdoptantes = User::where('role', 'adoptante')->count();
        $totalRefugios = User::where('role', 'refugio')->count();
        $totalMascotas = Mascota::count();
        $mascotasDisponibles = Mascota::where('status', 'disponible')->count();
        $mascotasPendientes = Mascota::where('status', 'pendiente')->count();
        $mascotasAdoptadas = Mascota::where('status', 'adoptada')->count();
        $solicitudesPendientes = SolicitudAdopcion::where('status', 'pendiente')->count();
        $solicitudesAprobadas = SolicitudAdopcion::where('status', 'aprobada')->count();
        $solicitudesRechazadas = SolicitudAdopcion::where('status', 'rechazada')->count();
        $totalAdopciones = Adopcion::count();

        $adopcionesPorMes = Adopcion::select(
            DB::raw("DATE_FORMAT(fecha_aprobacion, '%Y-%m') as mes"),
            DB::raw('count(*) as total')
        )
            ->whereNotNull('fecha_aprobacion')
            ->groupBy('mes')
            ->orderBy('mes', 'desc')
            ->limit(12)
            ->get();

        $refugiosTop = Adopcion::select(
            'refugio_id',
            DB::raw('count(*) as total')
        )
            ->groupBy('refugio_id')
            ->orderBy('total', 'desc')
            ->with('shelter')
            ->limit(5)
            ->get();

        $mascotasPorEspecie = Mascota::select('especie', DB::raw('count(*) as total'))
            ->groupBy('especie')
            ->get();

        return view('dashboard.admin', compact(
            'totalUsers', 'totalAdoptantes', 'totalRefugios',
            'totalMascotas', 'mascotasDisponibles', 'mascotasPendientes', 'mascotasAdoptadas',
            'solicitudesPendientes', 'solicitudesAprobadas', 'solicitudesRechazadas',
            'totalAdopciones', 'adopcionesPorMes', 'refugiosTop', 'mascotasPorEspecie'
        ));
    }
}
