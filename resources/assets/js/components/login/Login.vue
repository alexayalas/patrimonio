<template>
    <div class="login-box">
        <div class="login-logo">
<!--             <a href="#" class="text-danger"><b>VillaSalud</b></a> -->
            <img src="/images/logotipoeslogan.png" alt="">
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Inicio de Sesión al Sistema</p>

            <form action="../../index2.html" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" v-model="dataLogin.name" placeholder="Usuario">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" v-model="dataLogin.password" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-danger btn-block btn-flat" @click.prevent="login">Ingresar</button>
                </div>
                <!-- /.col -->
            </div>
            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->    
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name:'login',
    mounted() {
        //console.log("permisos: ",this.permisos)
    },  
    beforeCreate() {
        document.body.className = "hold-transition login-page";
    },     
    data() {
        return {
            dataLogin: {
                name: '',
                password: '',
            },  
            sitekey: '6LfaYFcUAAAAAFVD3dAq4jzNTeZkwzFBtqaiAr76' ,           
            errors:[]          
        }
    },
    computed: {
        ...mapState(['permisos','user_system']),
    },           
    methods: {
        login() {
            var url = "/api/login";    
            axios.post(url, this.dataLogin).then(response => {
                if(typeof(response.data.errors) != "undefined"){
                    this.errors = response.data.errors;
                    var resultado = "";
                    for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                    }
                    toastr.error(resultado);
                    return;
                }
                console.log("loggin :",response.data)
                this.$store.dispatch('SAVE_TOKEN', { user : response.data } ).then(response => {
                    //this.$store.dispatch('LOAD_PERFIL_USER')
                }, error => {
                    console.error("Fallo no definido")
                });
                this.$router.push({ name: 'Dashboard' })
                toastr.success('Ingreso exitoso')
            }).catch(error => {
                this.errors = error.response;
                console.log("err: ",this.errors) 
                toastr.error("Hubo un error en el proceso: "+this.errors)
            }); 
        },
    }    
}
</script>
<style>

</style>


