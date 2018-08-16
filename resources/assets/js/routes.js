import Login from './components/login/Login.vue'
import TemplateMain from './components/main/TemplateMain.vue'
import Dashboard from './components/dashboard/Dashboard.vue'

import Bajas from './components/bajas/Bajas.vue'
import Bienes from './components/bienes/Bienes.vue'
import EmpresasBienes from './components/bienes/EmpresasBienes.vue'
import Clases from './components/clasificaciones/Clases.vue'
import Grupos from './components/clasificaciones/Grupos.vue'
import Empleados from './components/empleados/Empleados.vue'
import Cuentas from './components/maestros/Cuentas.vue'
import Documentos from './components/maestros/Documentos.vue'
import Garantias from './components/maestros/Garantias.vue'
import Tipoingresos from './components/maestros/Tipoingresos.vue'
import Mantenimientos from './components/mantenimientos/Mantenimientos.vue'

import Proveedores from './components/proveedores/Proveedores.vue'
import Roles from './components/seguridad/Roles.vue'
import Usuarios from './components/seguridad/Usuarios.vue'
import Traslados from './components/traslados/Traslados.vue'
import Areas from './components/ubicaciones/Areas.vue'
import Empresas from './components/ubicaciones/Empresas.vue'
import Sedes from './components/ubicaciones/Sedes.vue'
import Ubicaciones from './components/ubicaciones/Ubicaciones.vue'
import CentralReportes from './components/reportes/CentralReportes.vue'

import NotFound from './components/errors/NotFound.vue'

export default [
    {
        path: '/',
        name: 'Admin',
        component: TemplateMain,
        children: [
            {
                path: '/dashboard',
                name: 'Dashboard',
                component: Dashboard,
                meta: { requiresAuth: true }
            },
            {
                path: '/bajas',
                name: 'Bajas',
                component: Bajas,
                meta: { requiresAuth: true }
            },
            {
                path: '/empresas-bienes',
                name: 'EmpresasBienes',
                component: EmpresasBienes,
                meta: { requiresAuth: true }
            },
            {
                path: '/bienes/:empresa',
                name: 'Bienes',
                component: Bienes,
                meta: { requiresAuth: true },
                props: true
            },                
            {
                path: '/clases',
                name: 'Clases',
                component: Clases,
                meta: { requiresAuth: true }
            },   
            {
                path: '/grupos',
                name: 'Grupos',
                component: Grupos,
                meta: { requiresAuth: true }
            },  
            {
                path: '/cuentas',
                name: 'Cuentas',
                component: Cuentas,
                meta: { requiresAuth: true }
            },
            {
                path: '/documentos',
                name: 'Documentos',
                component: Documentos,
                meta: { requiresAuth: true }
            },  
            {
                path: '/garantias',
                name: 'Garantias',
                component: Garantias,
                meta: { requiresAuth: true }
            },             
            {
                path: '/tipoingresos',
                name: 'Tipoingresos',
                component: Tipoingresos,
                meta: { requiresAuth: true }
            },    
            {
                path: '/mantenimientos',
                name: 'Mantenimientos',
                component: Mantenimientos,
                meta: { requiresAuth: true }
            },   
            {
                path: '/proveedores',
                name: 'Proveedores',
                component: Proveedores,
                meta: { requiresAuth: true }
            },  
            {
                path: '/roles',
                name: 'Roles',
                component: Roles,
                meta: { requiresAuth: true }
            },     
            {
                path: '/traslados',
                name: 'Traslados',
                component: Traslados,
                meta: { requiresAuth: true }
            }, 
            {
                path: '/areas',
                name: 'Areas',
                component: Areas,
                meta: { requiresAuth: true }
            }, 
            {
                path: '/empresas',
                name: 'Empresas',
                component: Empresas,
                meta: { requiresAuth: true }
            },  
            {
                path: '/sedes',
                name: 'Sedes',
                component: Sedes,
                meta: { requiresAuth: true }
            },             
            {
                path: '/ubicaciones',
                name: 'Ubicaciones',
                component: Ubicaciones,
                meta: { requiresAuth: true }
            },                                                                                                                                          
            {
                path: '/empleados',
                name: 'Empleados',
                component: Empleados,
                meta: { requiresAuth: true }
            },                       
            {
                path: '/usuarios',
                name: 'Usuarios',
                component: Usuarios,
                meta: { requiresAuth: true }
            },   
            {
                path: '/central-reportes',
                name: 'CentralReportes',
                component: CentralReportes,
                meta: { requiresAuth: true }
            },                    
            {
                path: '/login',
                name: 'login',
                component: Login,
                meta: { redirectIfLogged: true }
            }, 
            
            
        ]
    },
    {
        path: '*',
        name: 'not-found',
        component: NotFound
    }

]
