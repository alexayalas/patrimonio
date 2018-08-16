<template>
    <div>
        <!-- Content Header (Page header) -->
<!--         <section class="content-header">
        <h1>
            404 Error Page
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">404 error</li>
        </ol>
        </section> -->

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow text-center"> 404</h2>

                <div class="error-content text-center">
                    <h3><i class="fa fa-warning text-yellow"></i> Oops! Pagina no encontrada.</h3>

                    <p>
                        No pudimos encontrar la página que estabas buscando.
                        Mientras tanto, puedes <a href="/dashboard">retornar al Dashboard</a>
                    </p>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->        
    </div>
</template>
<script>
export default {
    name:"not-found",
    data() {
        return {
            name:''
        }
    }
}
</script>
<style scoped>
    h2 {
        font-weight: 700;
        font-size: 150px;
        font-family: sans-serif;
        margin-right: 30px;
    }

    .error-page {
        width: 80% !important;
    }

    .headline {
        float: none !important;
    }

    .error-content {
        margin-left: 0 !important;
    }
</style>


