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
                <p>{{ user_system.name_complete}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i>{{ user_system.roles[0].name}}</a>
            </div>
            <div class="clearfix"></div>
            <div class="pl-5 pr-5 pt-10 company">
                <p class="text-muted">EMPRESA</p> 
                <select class="col-md-12 p-0" v-model="companyId" @change="changeCompany">
                    <option v-for="empresa in empresas" :value="empresa.id" :key="empresa.id">
                        {{ empresa.nombre_empresa }}
                    </option>
                </select>                             
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" v-if="listMenu">
            <li class="header">MENU PRINCIPAL</li>
            <!-- <ul class="nav side-menu" v-if="listMenu"> -->
            <router-link v-for="route in listMenu" v-if="route.options.length == 0" tag="li" :to="{ name: route.name_router}" :key="route.id" exact class="not-treeview">
                <a><i :class="[route.icono]"></i><span>{{ route.name_template }}</span></a>
            </router-link>           
            <li v-for="route in listMenu" v-if="route.options.length > 0" :key="route.id" class="treeview">
                <a href="#"><i :class="[route.icono]"></i><span>{{ route.name_template }}</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>               
                </a>
                <ul class="treeview-menu">
                    <router-link v-for="subroute in route.options" tag="li" :to="{ name: subroute.name_router}" :key="subroute.id" exact>
                        <a><i :class="[subroute.icono]"></i>{{ subroute.name_template }}</a>
                    </router-link>              
                </ul>
            </li>
        </ul>
        <div v-if="listMenu.length == 0" class="text-center pt-20">
            <i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i>
            <span>Cargando...</span>
        </div>
          

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
            ruta1 : 'user.index',
            listMenu : [],
            companyId: ''
        
      }
    },
    beforeCreate() {
        this.$store.dispatch('LOAD_EMPRESAS_LIST')             
        this.$store.dispatch('LOAD_PERMISOS_LIST')   
        this.$store.dispatch('LOAD_ROLE_USER')    
    },          
    computed: {
        ...mapState(['permisos_user','user_system','isAdmin','role_user','empresas']),
/*         rutaActual: function () {
            return this.$route.path + "#"
        } */

    }, 
    watch:{
      role_user: function(newVal){
        if(newVal != 'undefined' && newVal != null){
          this.listMenu = this.role_user
          this.companyId = this.empresas[0].id
          this.changeCompany()
          
        }
        if(newVal == null){
          this.listMenu = []
        }
      }
    },    
    methods: {
        permissions_user : function(dato) {
            if(this.isAdmin){
                return true
            }
            var obj = _.find(this.permisos_user, function (obj) { return obj == dato; });
            if(obj == -1 || obj == undefined){
                return false
            }else{
                return true
            }       
        },
        changeCompany: function(){
            console.log("id:",this.companyId)
            this.$store.dispatch('CHANGE_COMPANY', { id: this.companyId } )
        }      
    }          

        
}
</script>
<style>
    .texto-blanco {
        color:white;
    }
</style>


