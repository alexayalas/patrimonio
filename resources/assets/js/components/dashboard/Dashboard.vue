<template>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                <h3>150</h3>

                <p>Bienes</p>
                </div>
                <div class="icon">
                <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                <h3>3</h3>

                <p>Sedes</p>
                </div>
                <div class="icon">
                <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                <h3>8</h3>

                <p>Usuarios</p>
                </div>
                <div class="icon">
                <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                <h3>9</h3>

                <p>Proveedores</p>
                </div>
                <div class="icon">
                <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-12 connectedSortable">

                <div class="col-md-4">
                    <img src="/img/sede-ves.jpg" class="img-responsive" alt="VILLA EL SALVADOR">
                    <label for="" class="control-label">Sede Villa El Salvador</label>
                </div>
                <div class="col-md-4">
                    <img src="/img/sede-lurin.jpg" class="img-responsive" alt="LURIN">
                    <label for="" class="control-label">Sede Lurin</label>
                </div>
                <div class="col-md-4">
                    <img src="/img/sede-sjl.jpg" class="img-responsive" alt="SAN JUAN DE LURIGANCHO">
                    <label for="" class="control-label">Sede San Juan de Lurigancho</label>
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->

    </section>
    <!-- /.content -->    
</template>
<script>
export default {
    name:'dashboard',    
    data() {
        return {
            message:''
        }
    },
    beforeCreate() {
        this.$store.dispatch('LOAD_EMPRESAS_LIST') 
        document.body.className = "hold-transition skin-red sidebar-mini";
    },
    created() {

    },           
}
</script>

