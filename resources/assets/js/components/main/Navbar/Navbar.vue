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
                    <i class="fa fa-dashboard"></i> <span>DASHBOARD</span>
                    <span class="pull-right-container">
                    </span>
                </a>
            </router-link>
            <router-link class="treeview" v-if="permissions_user('ubicacions.index') || permissions_user('areas.index') || permissions_user('empresas.index') || permissions_user('sedes.index') || permissions_user('empleados.index') || permissions_user('proveedores.index')" tag="li" :to="rutaActual" exact>
                <a href="#">
                    <i class="fa fa-sitemap"></i>
                    <span>ADMINISTRACIÓN</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <router-link v-if="permissions_user('empresas.index')" to="/empresas" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Empresas
                        </a>
                    </router-link> 
                    <router-link v-if="permissions_user('sedes.index')" to="/sedes" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Sedes
                        </a>
                    </router-link> 
                    <router-link v-if="permissions_user('areas.index')" to="/areas" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Areas
                        </a>
                    </router-link>                                                             
                    <router-link v-if="permissions_user('ubicacions.index')" to="/ubicaciones" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Ubicaciones
                        </a>
                    </router-link> 
                    <router-link v-if="permissions_user('empleados.index')" to="/empleados" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i>Empleados
                        </a>
                    </router-link>
                    <router-link v-if="permissions_user('proveedors.index')" to="/proveedores" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i>Proveedores
                        </a>
                    </router-link>                                       
                </ul>
            </router-link>
            <router-link class="treeview" v-if="permissions_user('biens.index') || permissions_user('grupos.index') || permissions_user('clases.index') || permissions_user('traslados.index') || permissions_user('bajas.index') || permissions_user('mantenimientos.index')" tag="li" :to="rutaActual" exact>
                <a href="#">
                    <i class="fa fa-folder-open"></i> <span>GESTIÓN DE BIENES</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <router-link v-if="permissions_user('biens.index')" to="/empresas-bienes" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i>Bienes
                        </a>
                    </router-link>                     
                    <router-link v-if="permissions_user('grupos.index')" to="/grupos" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Grupos
                        </a>
                    </router-link>
                    <router-link v-if="permissions_user('clases.index')" to="/clases" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Clases
                        </a>
                    </router-link>
                    <router-link v-if="permissions_user('traslados.index')" to="/traslados" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Traslados</span>
                        </a>
                    </router-link>
                    <router-link v-if="permissions_user('bajas.index')" to="/bajas" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Bajas</span>
                        </a>
                    </router-link>
                    <router-link v-if="permissions_user('mantenimientos.index')" to="/mantenimientos" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> <span>Mantenimientos</span>
                        </a>
                    </router-link>                    
                </ul>
            </router-link>                                  
            <router-link class="treeview" v-if="permissions_user('tipoingresos.index') || permissions_user('documentos.index') || permissions_user('cuentas.index') || permissions_user('garantias.index')" tag="li" :to="rutaActual" exact>
                <a href="#">
                    <i class="fa fa-file-text"></i> <span>MAESTROS</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <router-link v-if="permissions_user('tipoingresos.index')" to="/tipoingresos" tag="li" exact> 
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Tipos de Ingresos
                        </a>
                    </router-link>
                    <router-link v-if="permissions_user('documentos.index')" to="/documentos" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Documentos
                        </a>
                    </router-link>
                    <router-link v-if="permissions_user('garantias.index')" to="/garantias" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Garantias
                        </a>
                    </router-link>                    
                    <router-link v-if="permissions_user('cuentas.index')" to="/cuentas" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Cuentas
                        </a>
                    </router-link>
                </ul>

            </router-link>                
            <router-link class="treeview" v-if="permissions_user('roles.index') || permissions_user('users.index')" tag="li" :to="rutaActual" exact>
                <a href="#">
                    <i class="fa fa-unlock-alt"></i> <span>SEGURIDAD</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <router-link v-if="permissions_user('roles.index')" to="/roles" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Roles
                        </a>
                    </router-link>
                    <router-link  v-if="permissions_user('users.index')" to="/usuarios" tag="li" exact>
                        <a href="#">
                            <i class="fa fa-circle-o"></i> Usuarios
                        </a>
                    </router-link>
                </ul>
            </router-link>                
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
    beforeCreate() {
        this.$store.dispatch('LOAD_PERMISOS_LIST')     
    },          
    computed: {
        ...mapState(['permisos_user','user_system','isAdmin']),
        rutaActual: function () {
            return this.$route.path + "#"
        }

    }, 
    methods: {
        permissions_user : function(dato) {
            if(this.isAdmin){
                return true
            }
            var obj = _.find(this.permisos_user, function (obj) { return obj.slug === dato; });
            if(obj == -1 || obj == undefined){
                return false
            }else{
                return true
            }       
        }       
    }          
   
        
}
</script>

