<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // usuarios
        Permission::create([
            'name'              => 'Navegar usuarios',
            'slug'              => 'users.index',
            'description'       => 'Lista y navega todos los usuarios del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un usuario',
            'slug'              => 'users.show',
            'description'       => 'Ver en detalle cada usuario del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de usuario',
            'slug'              => 'users.edit',
            'description'       => 'Editar cualquier dato de usuario del sistema',
        ]);
        Permission::create([
            'name'              => 'Eliminar usuario',
            'slug'              => 'users.destroy',
            'description'       => 'Elimina cualquier usuario del sistema',
        ]);          
        
        // roles
        Permission::create([
            'name'              => 'Navegar roles',
            'slug'              => 'roles.index',
            'description'       => 'Lista y navega todos los roles del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un rol',
            'slug'              => 'roles.show',
            'description'       => 'Ver en detalle cada rol del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de rol',
            'slug'              => 'roles.create',
            'description'       => 'Crear cualquier dato de rol del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de rol',
            'slug'              => 'roles.edit',
            'description'       => 'Editar cualquier dato de rol del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar rol',
            'slug'              => 'roles.destroy',
            'description'       => 'Elimina cualquier rol del sistema',
        ]);

        // bienes
        Permission::create([
            'name'              => 'Navegar bienes',
            'slug'              => 'bienes.index',
            'description'       => 'Lista y navega todos los bienes del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un bien',
            'slug'              => 'bienes.show',
            'description'       => 'Ver en detalle cada bien del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de bien',
            'slug'              => 'bienes.create',
            'description'       => 'Crear cualquier dato de bien del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de bien',
            'slug'              => 'bienes.edit',
            'description'       => 'Editar cualquier dato de bien del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar bien',
            'slug'              => 'bienes.destroy',
            'description'       => 'Elimina cualquier bien del sistema',
        ]);  
        
        // mantenimientos
        Permission::create([
            'name'              => 'Navegar mantenimientos',
            'slug'              => 'mantenimientos.index',
            'description'       => 'Lista y navega todos los mantenimientos del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un mantenimiento',
            'slug'              => 'mantenimientos.show',
            'description'       => 'Ver en detalle cada mantenimiento del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de mantenimiento',
            'slug'              => 'mantenimientos.create',
            'description'       => 'Crear cualquier dato de mantenimiento del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de mantenimiento',
            'slug'              => 'mantenimientos.edit',
            'description'       => 'Editar cualquier dato de mantenimiento del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar mantenimiento',
            'slug'              => 'mantenimientos.destroy',
            'description'       => 'Elimina cualquier mantenimiento del sistema',
        ]);  
        
        // bajas
        Permission::create([
            'name'              => 'Navegar bajas',
            'slug'              => 'bajas.index',
            'description'       => 'Lista y navega todos los bajas del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un baja',
            'slug'              => 'bajas.show',
            'description'       => 'Ver en detalle cada baja del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de baja',
            'slug'              => 'bajas.create',
            'description'       => 'Crear cualquier dato de baja del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de baja',
            'slug'              => 'bajas.edit',
            'description'       => 'Editar cualquier dato de baja del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar baja',
            'slug'              => 'bajas.destroy',
            'description'       => 'Elimina cualquier baja del sistema',
        ]);
        
        // empresas
        Permission::create([
            'name'              => 'Navegar empresas',
            'slug'              => 'empresas.index',
            'description'       => 'Lista y navega todos los empresas del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un empresa',
            'slug'              => 'empresas.show',
            'description'       => 'Ver en detalle cada empresa del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de empresa',
            'slug'              => 'empresas.create',
            'description'       => 'Crear cualquier dato de empresa del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de empresa',
            'slug'              => 'empresas.edit',
            'description'       => 'Editar cualquier dato de empresa del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar empresa',
            'slug'              => 'empresas.destroy',
            'description'       => 'Elimina cualquier empresa del sistema',
        ]);  
        
        // traslados
        Permission::create([
            'name'              => 'Navegar traslados',
            'slug'              => 'traslados.index',
            'description'       => 'Lista y navega todos los traslados del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un traslado',
            'slug'              => 'traslados.show',
            'description'       => 'Ver en detalle cada traslado del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de traslado',
            'slug'              => 'traslados.create',
            'description'       => 'Crear cualquier dato de traslado del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de traslado',
            'slug'              => 'traslados.edit',
            'description'       => 'Editar cualquier dato de traslado del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar traslado',
            'slug'              => 'traslados.destroy',
            'description'       => 'Elimina cualquier traslado del sistema',
        ]);  
        
        // empleados
        Permission::create([
            'name'              => 'Navegar empleados',
            'slug'              => 'empleados.index',
            'description'       => 'Lista y navega todos los empleados del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un empleado',
            'slug'              => 'empleados.show',
            'description'       => 'Ver en detalle cada empleado del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de empleado',
            'slug'              => 'empleados.create',
            'description'       => 'Crear cualquier dato de empleado del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de empleado',
            'slug'              => 'empleados.edit',
            'description'       => 'Editar cualquier dato de empleado del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar empleado',
            'slug'              => 'empleados.destroy',
            'description'       => 'Elimina cualquier empleado del sistema',
        ]); 
        
        // grupos
        Permission::create([
            'name'              => 'Navegar grupos',
            'slug'              => 'grupos.index',
            'description'       => 'Lista y navega todos los grupos del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un grupo',
            'slug'              => 'grupos.show',
            'description'       => 'Ver en detalle cada grupo del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de grupo',
            'slug'              => 'grupos.create',
            'description'       => 'Crear cualquier dato de grupo del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de grupo',
            'slug'              => 'grupos.edit',
            'description'       => 'Editar cualquier dato de traslado del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar grupo',
            'slug'              => 'grupos.destroy',
            'description'       => 'Elimina cualquier grupo del sistema',
        ]); 
        
        // clases
        Permission::create([
            'name'              => 'Navegar clases',
            'slug'              => 'clases.index',
            'description'       => 'Lista y navega todos los clases del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un clase',
            'slug'              => 'clases.show',
            'description'       => 'Ver en detalle cada clase del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de clase',
            'slug'              => 'clases.create',
            'description'       => 'Crear cualquier dato de clase del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de clase',
            'slug'              => 'clases.edit',
            'description'       => 'Editar cualquier dato de clase del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar clase',
            'slug'              => 'clases.destroy',
            'description'       => 'Elimina cualquier clase del sistema',
        ]); 
        
        // proveedores
        Permission::create([
            'name'              => 'Navegar proveedores',
            'slug'              => 'proveedores.index',
            'description'       => 'Lista y navega todos los proveedores del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un proveedor',
            'slug'              => 'proveedores.show',
            'description'       => 'Ver en detalle cada proveedor del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de proveedor',
            'slug'              => 'proveedores.create',
            'description'       => 'Crear cualquier dato de proveedor del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de proveedor',
            'slug'              => 'proveedores.edit',
            'description'       => 'Editar cualquier dato de proveedor del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar proveedor',
            'slug'              => 'proveedores.destroy',
            'description'       => 'Elimina cualquier proveedor del sistema',
        ]);   
        
        // ubicaciones
        Permission::create([
            'name'              => 'Navegar ubicaciones',
            'slug'              => 'ubicaciones.index',
            'description'       => 'Lista y navega todos las ubicaciones del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de una ubicacion',
            'slug'              => 'ubicaciones.show',
            'description'       => 'Ver en detalle cada ubicacion del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de ubicacion',
            'slug'              => 'ubicaciones.create',
            'description'       => 'Crear cualquier dato de ubicacion del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de ubicacion',
            'slug'              => 'ubicaciones.edit',
            'description'       => 'Editar cualquier dato de ubicacion del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar ubicacion',
            'slug'              => 'ubicaciones.destroy',
            'description'       => 'Elimina cualquier ubicacion del sistema',
        ]);
        
        // areas
        Permission::create([
            'name'              => 'Navegar areas',
            'slug'              => 'areas.index',
            'description'       => 'Lista y navega todos los areas del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de una area',
            'slug'              => 'areas.show',
            'description'       => 'Ver en detalle cada area del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de area',
            'slug'              => 'areas.create',
            'description'       => 'Crear cualquier dato de area del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de area',
            'slug'              => 'areas.edit',
            'description'       => 'Editar cualquier dato de area del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar area',
            'slug'              => 'areas.destroy',
            'description'       => 'Elimina cualquier area del sistema',
        ]);
        
        // tipoingresos
        Permission::create([
            'name'              => 'Navegar tipoingresos',
            'slug'              => 'tipoingresos.index',
            'description'       => 'Lista y navega todos los tipoingresos del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un tipoingresos',
            'slug'              => 'tipoingresos.show',
            'description'       => 'Ver en detalle cada tipoingresos del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de tipoingresos',
            'slug'              => 'tipoingresos.create',
            'description'       => 'Crear cualquier dato de tipoingresos del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de tipoingresos',
            'slug'              => 'tipoingresos.edit',
            'description'       => 'Editar cualquier dato de tipoingresos del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar tipoingresos',
            'slug'              => 'tipoingresos.destroy',
            'description'       => 'Elimina cualquier tipoingresos del sistema',
        ]); 
        
        // documentos
        Permission::create([
            'name'              => 'Navegar documentos',
            'slug'              => 'documentos.index',
            'description'       => 'Lista y navega todos los documentos del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un documento',
            'slug'              => 'documentos.show',
            'description'       => 'Ver en detalle cada documento del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de documento',
            'slug'              => 'documentos.create',
            'description'       => 'Crear cualquier dato de documento del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de documento',
            'slug'              => 'documentos.edit',
            'description'       => 'Editar cualquier dato de documento del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar proveedor',
            'slug'              => 'documentos.destroy',
            'description'       => 'Elimina cualquier documento del sistema',
        ]); 
        
        // cuentas
        Permission::create([
            'name'              => 'Navegar cuentas',
            'slug'              => 'cuentas.index',
            'description'       => 'Lista y navega todos los cuentas del sistema',
        ]);
        Permission::create([
            'name'              => 'Ver detalle de un cuenta',
            'slug'              => 'cuentas.show',
            'description'       => 'Ver en detalle cada proveedor del sistema',
        ]);
        Permission::create([
            'name'              => 'Creacion de cuenta',
            'slug'              => 'cuentas.create',
            'description'       => 'Crear cualquier dato de cuenta del sistema',
        ]);
        Permission::create([
            'name'              => 'Edicion de cuenta',
            'slug'              => 'cuentas.edit',
            'description'       => 'Editar cualquier dato de cuenta del sistema',
        ]);        
        Permission::create([
            'name'              => 'Eliminar cuenta',
            'slug'              => 'cuentas.destroy',
            'description'       => 'Elimina cualquier cuenta del sistema',
        ]);                  
    }
}
