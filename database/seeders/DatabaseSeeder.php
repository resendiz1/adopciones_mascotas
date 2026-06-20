<?php

namespace Database\Seeders;

use App\Models\Mascota;
use App\Models\Shelter;
use App\Models\User;
use App\Models\Vacuna;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $refugio = User::factory()->create([
            'name' => 'Refugio Ejemplo',
            'email' => 'refugio@example.com',
            'password' => bcrypt('password'),
            'role' => 'refugio',
        ]);

        $shelter = Shelter::create([
            'user_id' => $refugio->id,
            'name' => 'Refugio Ejemplo',
            'description' => 'Un refugio de ejemplo para pruebas.',
            'address' => 'Calle Principal 123',
            'ciudad' => 'Ciudad de México',
            'estado' => 'CDMX',
            'phone' => '555-1234',
        ]);

        Mascota::create([
            'refugio_id' => $shelter->id,
            'nombre' => 'Luna',
            'especie' => 'perro',
            'raza' => 'Labrador',
            'edad_meses' => 24,
            'sexo' => 'hembra',
            'tamano' => 'grande',
            'peso' => 28.50,
            'descripcion' => 'Luna es una perrita muy cariñosa y juguetona. Le encanta correr y pasar tiempo con niños.',
            'esterilizado' => true,
            'desparasitado' => true,
            'status' => 'disponible',
        ]);

        Mascota::create([
            'refugio_id' => $shelter->id,
            'nombre' => 'Misi',
            'especie' => 'gato',
            'raza' => null,
            'edad_meses' => 6,
            'sexo' => 'hembra',
            'tamano' => 'pequeno',
            'peso' => null,
            'descripcion' => 'Misi es una gatita rescatada de la calle. Es muy independiente pero cariñosa.',
            'esterilizado' => false,
            'desparasitado' => true,
            'status' => 'disponible',
        ]);

        Mascota::create([
            'refugio_id' => $shelter->id,
            'nombre' => 'Max',
            'especie' => 'perro',
            'raza' => 'Pastor Alemán',
            'edad_meses' => 36,
            'sexo' => 'macho',
            'tamano' => 'grande',
            'peso' => 32.00,
            'descripcion' => 'Max es un perro guardian entrenado. Muy leal y protector de su familia.',
            'esterilizado' => true,
            'desparasitado' => true,
            'status' => 'disponible',
        ]);

        User::factory()->create([
            'name' => 'Adoptante Ejemplo',
            'email' => 'adoptante@example.com',
            'password' => bcrypt('password'),
            'role' => 'adoptante',
        ]);

        $vacunas = [
            ['nombre' => 'Rabia', 'descripcion' => 'Vacuna antirrábica.'],
            ['nombre' => 'Moquillo', 'descripcion' => 'Vacuna contra el moquillo canino.'],
            ['nombre' => 'Parvovirus', 'descripcion' => 'Vacuna contra el parvovirus canino.'],
            ['nombre' => 'Triple felina', 'descripcion' => 'Vacuna triple para gatos (herpes, calicivirus, panleucopenia).'],
            ['nombre' => 'Bordetella', 'descripcion' => 'Vacuna contra la bordetella (tos de las perreras).'],
        ];

        foreach ($vacunas as $vacuna) {
            Vacuna::create($vacuna);
        }
    }
}
