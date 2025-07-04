<?php

namespace Database\Seeders;

use App\Models\GrupoMenu;
use App\Models\Menu;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('nombre', 'Super Usuario')->first(); 
        $menuspadres = [ 
            //Sistem
            [
                'nombre' => 'Usuarios',
                'slug' => 'gestion-usuarios',
                'icono' => 'fas fa-user-friends',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Sistema')->value('id'),
                'orden' => 5,
            ],
            [
                'nombre' => 'Menús',
                'slug' => 'gestion-menus',
                'icono' => 'fas fa-list',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Sistema')->value('id'),
                'orden' => 6,
            ],
            [
                'nombre' => 'Marcaciones',
                'slug' => 'marcaciones',
                'icono' => 'fas fa-check',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Asistencia')->value('id'),
                'orden' => 8,
            ],
            [
                'nombre' => 'Reporte',
                'slug' => 'reporte-marcaciones',
                'icono' => 'fas fa-chart-bar',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Asistencia')->value('id'),
                'orden' => 8,
            ],
            [
                'nombre' => 'Reporte por Personal',
                'slug' => 'reporte-por-personal',
                'icono' => 'fas fa-chart-bar',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Asistencia')->value('id'),
                'orden' => 8,
            ],    
            [
                'nombre' => 'Personals',
                'slug' => 'personals',
                'icono' => 'fas fa-graduation-cap',
                'padre_id' => null,
                'grupo_id'  => GrupoMenu::where('titulo', 'Asistencia')->value('id'),
                'orden' => 8,
            ],   
 
        ];
        $menuIds = [];
        foreach($menuspadres as $row){
            $menu = Menu::firstOrCreate($row);
            $menuIds[] = $menu->id;
        }
        $role->menus()->sync($menuIds);

        //$role->menus()->attach($menuIds);
    }
}
