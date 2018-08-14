<template>
    <div class="login-box">
        <div class="login-logo">
<!--             <a href="#" class="text-danger"><b>VillaSalud</b></a> -->
            <img src="/images/logotipoeslogan.png" alt="">
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Inicio de Sesión al Sistema</p>

            <form role="form" method="POST" v-on:submit.prevent="login">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" v-model="dataLogin.name" placeholder="Usuario">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" v-model="dataLogin.password" placeholder="Password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-5">
<!--                     <button type="submit" class="btn btn-danger btn-block btn-flat" @click.prevent="login">Ingresar</button>
 -->                    <button type="submit" class="btn btn-danger btn-block btn-flat" :disabled="ShowIcon"><i :class="[IconClass]"></i> {{ labelButton }}</button>
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
    beforeCreate() {
        document.body.className = "hold-transition login-page";
    },     
    data() {
        return {
            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Ingresar', 
                        
            dataLogin: {
                name: '',
                password: '',
            },  
            sitekey: '6LfaYFcUAAAAAFVD3dAq4jzNTeZkwzFBtqaiAr76' ,           
            errors:[]          
        }
    },         
    methods: {
        login() {
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Accediendo'              
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
                    this.ShowIcon = false
                    this.IconClass = 'fa fa-cloud-upload'
                    this.labelButton = 'Ingresar'                       
                    return;
                }

                this.$store.dispatch('SAVE_TOKEN', { user : response.data } ).then(response => {
                    this.$store.dispatch('LOAD_ROLE_USER') 
                    //this.$store.dispatch('LOAD_PERFIL_USER')
                }, error => {
                    console.error("Fallo no definido")
                });
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'
                this.labelButton = 'Ingresar'                   
                this.$router.push({ name: 'Dashboard' })
                toastr.success('Ingreso exitoso')
            }).catch(error => {
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'
                this.labelButton = 'Ingresar'  
                this.errors = error.response;
                console.log("err: ",this.errors.data.error) 
                toastr.error("Hubo un error en el proceso: "+this.errors.data.error)
            }); 
        },
    }    
}
</script>
<style>

</style>


