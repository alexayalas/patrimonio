<template>
    <div v-bind:class="{ 'wrapper' : authenticated }">
        <!-- TOPBAR -->
        <topbar v-show="authenticated"></topbar>

        <!-- NAVBAR -->
        <navbar v-show="authenticated"></navbar>

        <!-- Content Wrapper. Contains page content -->
        <div v-bind:class="{ 'content-wrapper' : authenticated }">
            <!-- Content Header (Page header) -->
<!--             <breadcrumb v-show="authenticated"></breadcrumb> -->

            <router-view></router-view>

        </div>
        <!-- /.content-wrapper -->

        <!-- FOOTER -->
        <footervue v-show="authenticated"></footervue>

    </div>
    <!-- ./wrapper -->

</template>
<script>
import { mapState, mapGetters } from 'vuex'

export default {
    name: 'templatemain',
    data () {
        return {
            message:''        
        }
    },    
    mounted(){
        console.log("autentificado: ",this.authenticated)
    },
    beforeCreate() {
        this.$store.dispatch('LOAD_EMPRESAS_LIST')     
        document.body.className = "hold-transition skin-red sidebar-mini";
    },    
    computed: {
        ...mapState(['authenticated'])
    }

}
</script>
<style scoped>
/*     .notmargin {
        margin-left: 0 !important;
    } */

</style>