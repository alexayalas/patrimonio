<template>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
            <img src="/img/no-image.png" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
            <p>Administrador</p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
<!--         <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form> -->
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MENU PRINCIPAL</li>
            <router-link class="treeview" to="/dashboard" tag="li" exact>
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </router-link>
            <router-link class="treeview" v-if="permisos_user('biens.index')" to="/empresas-bienes" tag="li" exact>
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Bienes</span>
                </a>
            </router-link>       
<!--             <li class="treeview" v-if="permisos_user('ubicacions.index') || permisos_user('areas.index') || permisos_user('empresas.index')"> -->
            <router-link class="treeview" v-if="permisos_user('ubicacions.index') || permisos_user('areas.index') || permisos_user('empresas.index') || permisos_user('sedes.index')" tag="li" :to="rutaActual" exact>
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Ubicaciones</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <router-link v-if="permisos_user('empresas.index')" to="/empresas" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Empresas
                        </a>
                    </router-link> 
                    <router-link v-if="permisos_user('sedes.index')" to="/sedes" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Sedes
                        </a>
                    </router-link> 
                    <router-link v-if="permisos_user('areas.index')" to="/areas" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Areas
                        </a>
                    </router-link>                                                             
                    <router-link v-if="permisos_user('ubicacions.index')" to="/ubicaciones" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Ubicaciones
                        </a>
                    </router-link>                    
                </ul>
            </router-link>                
<!--             </li> -->
<!--             <li class="treeview" v-if="permisos_user('grupos.index') || permisos_user('clases.index')"> -->
            <router-link class="treeview" v-if="permisos_user('grupos.index') || permisos_user('clases.index')" tag="li" :to="rutaActual" exact>
                <a href="#">
                    <i class="fa fa-th"></i> <span>Clasificaciones</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <router-link v-if="permisos_user('grupos.index')" to="/grupos" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Grupo
                        </a>
                    </router-link>
                    <router-link v-if="permisos_user('clases.index')" to="/clases" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Clase
                        </a>
                    </router-link>
                </ul>
            </router-link>            
<!--             </li> -->
            <router-link  class="treeview" v-if="permisos_user('empleados.index')" to="/empleados" tag="li" exact>
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Empleados</span>
                </a>
            </router-link>
            <router-link  class="treeview" v-if="permisos_user('proveedors.index')" to="/proveedores" tag="li" exact>
                <a href="#">
                    <i class="fa fa-laptop"></i>
                    <span>Proveedores</span>
                </a>
            </router-link>
<!--             <li class="treeview" v-if="permisos_user('tipoingresos.index') || permisos_user('documentos.index') || permisos_user('cuentas.index')"> -->
            <router-link class="treeview" v-if="permisos_user('tipoingresos.index') || permisos_user('documentos.index') || permisos_user('cuentas.index') || permisos_user('garantias.index')" tag="li" :to="rutaActual" exact>
                <a href="#">
                    <i class="fa fa-edit"></i> <span>Maestros</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <router-link v-if="permisos_user('tipoingresos.index')" to="/tipoingresos" tag="li" exact> 
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Tipo Ingreso
                        </a>
                    </router-link>
                    <router-link v-if="permisos_user('documentos.index')" to="/documentos" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Documento
                        </a>
                    </router-link>
                    <router-link v-if="permisos_user('garantias.index')" to="/garantias" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Garantia
                        </a>
                    </router-link>                    
                    <router-link v-if="permisos_user('cuentas.index')" to="/cuentas" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Cuenta
                        </a>
                    </router-link>
                </ul>

            </router-link>                
<!--             </li> -->
            <router-link class="treeview" v-if="permisos_user('traslados.index')" to="/traslados" tag="li" exact>
                <a href="#">
                    <i class="fa fa-table"></i> <span>Traslados</span>
                </a>
            </router-link>
            <router-link class="treeview" v-if="permisos_user('bajas.index')" to="/bajas" tag="li" exact>
                <a href="#">
                    <i class="fa fa-calendar"></i> <span>Bajas</span>
                </a>
            </router-link>
            <router-link class="treeview" v-if="permisos_user('mantenimientos.index')" to="/mantenimientos" tag="li" exact>
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Mantenimientos</span>
                </a>
            </router-link>
            <!-- <li class="treeview" v-if="permisos_user('roles.index') || permisos_user('users.index')"> -->
            <router-link class="treeview" v-if="permisos_user('roles.index') || permisos_user('users.index')" tag="li" :to="rutaActual" exact>
                <a href="#">
                    <i class="fa fa-folder"></i> <span>Seguridad</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <router-link v-if="permisos_user('roles.index')" to="/roles" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Roles
                        </a>
                    </router-link>
                    <router-link  v-if="permisos_user('users.index')" to="/usuarios" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Usuarios
                        </a>
                    </router-link>
                </ul>

            </router-link>                
<!--             </li> -->
        </ul>
        </section>
        <!-- /.sidebar -->
    </aside>    
</template>
<script>
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'navbar',
    data () {
      return {
          ruta1 : 'user.index'
        
      }
    },
    updated(){
      //this.getMenuClick()
    },      
    computed: {
        ...mapState(['permisos','user_system','isAdmin']),
        rutaActual: function () {
            return this.$route.path + "#"
        }

    }, 
    methods: {
        permisos_user : function(dato) {
            if(this.isAdmin){
                return true
            }
            var obj = _.find(this.permisos, function (obj) { return obj.slug === dato; });
            if(obj == -1 || obj == undefined){
                return false
            }else{
                return true
            }       
        }       
    }          
   
        
}
</script>

