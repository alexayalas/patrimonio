<template>
    <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>VS</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>VillaSalud</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="/img/no-image.png" class="user-image" alt="User Image">
                        <span class="hidden-xs">Administrador</span>
                    </a>
                    <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                        <img src="/img/no-image.png" class="img-circle" alt="User Image">

                        <p>
                        Administrador - Web Developer
                        <small>Member since Nov. 2012</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                        <a href="#" class="btn btn-default btn-flat" @click.prevent="loadForm">Cambiar Clave</a>
                        </div>
                        <div class="pull-right">
                        <a href="#" class="btn btn-default btn-flat" @click.prevent="logout">Cerrar Sesión</a>
                        </div>
                    </li>
                    </ul>
                </li>
                </ul>
            </div>
        </nav>
        <modal name="Formpassword" :width="'25%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <div class="col-md-12 modal-main pl-0 pr-0">
              <div class="row title-form">
                  <h3 class="pull-left h3-title pl-10">Cambio de contraseña</h3>
                  <div class="pull-right close-form pr-20" @click="$modal.hide('Formpassword')"><i class="fa fa-close"></i></div>                
              </div>
              <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="changePassword">
                  <div class="form-body">
                    <div class="col-md-12 pt-20">
                        <div class="form-group ml-5">
                            <label class="control-label">Escriba su contraseña actual <span class="asterisk">*</span></label>
                            <div class="row">
                                <div class="col-sm-11">
                                    <input type="password" class="form-control input-sm" v-model="dataPassword.antPass" required>
                                </div>
                            </div>
                        </div><!-- /.form-group -->
                        <div class="form-group ml-5">
                            <label class="control-label">Escriba su nueva contraseña <span class="asterisk">*</span></label>
                            <div class="row">
                                <div class="col-sm-11">
                                    <input type="password" class="form-control input-sm" v-model="dataPassword.newPass" required>
                                </div>
                            </div>
                        </div><!-- /.form-group -->
                        <div class="form-group ml-5">
                            <label class="control-label">Repita su nueva contraseña </label>
                            <div class="row">
                                <div class="col-sm-11">
                                    <input type="password" class="form-control input-sm" v-model="dataPassword.repPass" required>
                                </div>
                            </div>                            
                        </div><!-- /.form-group -->                                                                                                                                                
                    </div>
                  </div><!-- /.form-body -->
                  <div class="col-md-12 pt-20 mb-10 mt-0 pr-20 separator">
                      <div class="pull-right pr-10">
                          <button type="button" class="btn btn-danger active" @click="$modal.hide('Formpassword')"><i class="fa fa-reply-all"></i> Cancelar</button>
                          <button type="submit" class="btn btn-primary active"><i class="fa fa-cloud-upload"></i> Grabar</button>
                      </div>
                  </div><!-- /.form-footer -->
              </form>
            </div>
        <!-- /. modal -->        
      </modal>        
    </header>  
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'topbar',
    data() {
        return {
            message:'' ,
            dataPassword:{
                antPass:'',
                newPass:'',
                repPass:''
            }                       
        }
    },
    computed: {
        ...mapState(['user_system']),
    },       
    methods: {
        logout() {
            this.$store.dispatch('LOGOUT').then(() => {          
                this.$router.push({ name: 'login' })
            })
        },
        loadForm: function(){
            this.dataPassword = {
                antPass:'',
                newPass:'',
                repPass:''
            }      
            this.$modal.show('Formpassword')
        },
        changePassword: function()
        {
            var url = '/api/users/changepassword'
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            axios.post(url, this.dataPassword).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                //toastr.error(resultado);
                toastr.error("Hubo un error en el proceso: verifique los datos ingresados ");
                return;
            }
            this.$modal.hide('Formpassword');
            this.errors = [];
            toastr.success('se realizo el cambio de clave correctamente');
            }).catch(error => {
            this.errors = error.response.data.status;
            this.$modal.hide('Formpassword');
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });

        },               
    }        
}
</script>
<style scoped>
    .title-form {
        background-color: #CF120B;
        color: white;
    }

    .h3-title {
        margin:10px 0 10px 20px;
        color: white;
    }

    .close-form {
        margin:15px;
        border-radius: 50%;
        cursor: pointer;
    }
    .enlace:hover {
        cursor:pointer; cursor: hand	      
    } 

    .bootstro-prev-btn {
        float: left;
    } 

    .separator {
        border-top: 1px solid #CF120B;
    }

    input.mayusculas, textarea.mayusculas{
        text-transform:uppercase;
    }     

    input.minusculas{
        text-transform:lowercase;
    }    

    .center {
        text-align: center;
    }   
      
    .v--modal-overlay {
        z-index:100000000;
    }    

    .modal-main {
        background-color: #F6E0A6 !important;
        color:rgb(41, 2, 1);
    } 

    .modal-item {
        border-bottom: 1px solid rgb(255, 81, 81);
        border-left: 1px solid rgb(255, 81, 81);
        border-right: 1px solid rgb(255, 81, 81);
    }
    .label-grupo {
        text-align: left;
        border: 1px solid gray;
    }   

</style>


