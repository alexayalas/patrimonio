<template>
    <div>
        <section class="content-header">
        <h1>
            Empresas
            <small>Lista de Empresas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Bajas por Empresas</li>
        </ol>
        </section>    
        <section class="content">
            <!-- =========================================================== -->
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6" v-for="empresa in empresas" :key="empresa.id">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ getBajasByEmpresaId(empresa.id).length }}</h3>
                            <p>Traslados</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-home"></i>
                        </div>
                        <router-link class="small-box-footer" :to="{ name: 'Bajas', params : { empresa: empresa.id }}" exact>
                                {{ empresa.nombre_empresa }} <i class="fa fa-arrow-circle-right"></i> 
                        </router-link>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->   
        </section>
    </div> 
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name:'empresasbajas',
    mounted() {
        this.$store.dispatch('LOAD_EMPRESAS_LIST')     
        this.$store.dispatch('LOAD_MOVIMIENTOS_LIST')           
    },     
    data() {
        return {

        }
    },
    computed: {
        ...mapState(['empresas']),
        ...mapGetters(['getBajasByEmpresaId']),        
    },    
}
</script>

