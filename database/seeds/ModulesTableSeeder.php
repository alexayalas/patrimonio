<?php

use Illuminate\Database\Seeder;
use App\Module;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Module::create([
            'name'                  => 'Dashboard',
            'idparent'              => '0',
            'name_router'           => 'Dashboard',
            'icono'                 => 'fa fa-dashboard',
            'name_template'         => 'Dashboard',
            'type'                  => 'menu',
            'orden'                 => '1',
        ]);
        Module::create([
            'name'                  => 'Administracion',
            'idparent'              => '0',
            'name_router'           => null,
            'icono'                 => 'fa fa-sitemap',
            'name_template'         => 'ADMINISTRACIÓN',
            'type'                  => 'menu',
            'orden'                 => '1',
        ]);
        Module::create([
            'name'                  => 'Gestion de Bienes',
            'idparent'              => '0',
            'name_router'           => null,
            'icono'                 => 'fa fa-folder-open',
            'name_template'         => 'GESTIÓN DE BIENES',
            'type'                  => 'menu',
            'orden'                 => '1',
        ]);
        Module::create([
            'name'                  => 'Maestros',
            'idparent'              => '0',
            'name_router'           => null,
            'icono'                 => 'fa fa-file-text',
            'name_template'         => 'MAESTROS',
            'type'                  => 'menu',
            'orden'                 => '1',
        ]);          
        
        // roles
        Module::create([
            'name'                  => 'Seguridad',
            'idparent'              => '0',
            'name_router'           => null,
            'icono'                 => 'fa fa-unlock-alt',
            'name_template'         => 'SEGURIDAD',
            'type'                  => 'menu',
            'orden'                 => '1',
        ]);
        Module::create([
            'name'                  => 'Reportes',
            'idparent'              => '0',
            'name_router'           => null,
            'icono'                 => '',
            'name_template'         => 'REPORTES',
            'type'                  => 'menu',
            'orden'                 => '1',
        ]);
        Module::create([
            'name'                  => 'Empresas',
            'idparent'              => '2',
            'name_router'           => 'Empresas',
            'icono'                 => 'fa fa-circle-o',
            'name_template'         => 'Empresas',
            'type'                  => 'option',
            'orden'                 => '1',
        ]);
        Module::create([
            'name'                  => 'Sedes',
            'idparent'              => '2',
            'name_router'           => 'Sedes',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Sedes',
            'type'                  => 'option',
            'orden'                 => '2',
        ]);        
        Module::create([
            'name'                  => 'Areas',
            'idparent'              => '2',
            'name_router'           => 'Areas',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Areas',
            'type'                  => 'option',
            'orden'                 => '3',
        ]);

        // bienes
        Module::create([
            'name'                  => 'Ubicaciones',
            'idparent'              => '2',
            'name_router'           => 'Ubicaciones',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Ubicaciones',
            'type'                  => 'option',
            'orden'                 => '4',
        ]);
        Module::create([
            'name'                  => 'Empleados',
            'idparent'              => '2',
            'name_router'           => 'Empleados',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Empleados',
            'type'                  => 'option',
            'orden'                 => '5',
        ]);
        Module::create([
            'name'                  => 'Proveedores',
            'idparent'              => '2',
            'name_router'           => 'Proveedores',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Proveedores',
            'type'                  => 'option',
            'orden'                 => '6',
        ]);
        Module::create([
            'name'                  => 'Bienes',
            'idparent'              => '3',
            'name_router'           => 'EmpresaBienes',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Bienes',
            'type'                  => 'option',
            'orden'                 => '1',
        ]);        
        Module::create([
            'name'                  => 'Grupos',
            'idparent'              => '3',
            'name_router'           => 'Grupos',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Grupos',
            'type'                  => 'option',
            'orden'                 => '2',
        ]);  
        
        // mantenimientos
        Module::create([
            'name'                  => 'Clases',
            'idparent'              => '3',
            'name_router'           => 'Clases',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Clases',
            'type'                  => 'option',
            'orden'                 => '3',
        ]);
        Module::create([
            'name'                  => 'Traslados',
            'idparent'              => '3',
            'name_router'           => 'Traslados',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Traslados',
            'type'                  => 'option',
            'orden'                 => '4',
        ]);
        Module::create([
            'name'                  => 'Bajas',
            'idparent'              => '3',
            'name_router'           => 'Bajas',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Bajas',
            'type'                  => 'option',
            'orden'                 => '5',
        ]);
        Module::create([
            'name'                  => 'Mantenimientos',
            'idparent'              => '3',
            'name_router'           => 'Mantenimientos',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Mantenimientos',
            'type'                  => 'option',
            'orden'                 => '6',
        ]);        
        Module::create([
            'name'                  => 'Tipos Ingresos',
            'idparent'              => '4',
            'name_router'           => 'Tipoingresos',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Tipos Ingresos',
            'type'                  => 'option',
            'orden'                 => '1',
        ]);  
        
        // bajas
        Module::create([
            'name'                  => 'Documentos',
            'idparent'              => '4',
            'name_router'           => 'Documentos',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Documentos',
            'type'                  => 'option',
            'orden'                 => '2',
        ]);
        Module::create([
            'name'                  => 'Garantias',
            'idparent'              => '4',
            'name_router'           => 'Garantias',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Garantias',
            'type'                  => 'option',
            'orden'                 => '3',
        ]);
        Module::create([
            'name'                  => 'Cuentas',
            'idparent'              => '4',
            'name_router'           => 'Cuentas',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Cuentas',
            'type'                  => 'option',
            'orden'                 => '4',
        ]);
        Module::create([
            'name'                  => 'Roles',
            'idparent'              => '5',
            'name_router'           => 'Roles',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Roles',
            'type'                  => 'option',
            'orden'                 => '1',
        ]);        
        Module::create([
            'name'                  => 'Usuarios',
            'idparent'              => '5',
            'name_router'           => 'Usuarios',
            'icono'                 => 'fa fa-circle-o',            
            'name_template'         => 'Usuarios',
            'type'                  => 'option',
            'orden'                 => '2',
        ]);
    }
}
