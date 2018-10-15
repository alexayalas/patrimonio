<template>
    <div>
        <section class="content-header">
        <h1>
            Usuarios
            <small>Mantenimiento de Usuarios</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Usuarios</li>
        </ol>
        </section>    
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- START DEFAULT DATATABLE -->
                    <div class="panel panel-danger">
                        <div class="panel-heading bg-red-active"> 
                            <!-- <h3 class="panel-title">VillaSalud</h3>  -->                              
                            <div class="row">
                                <button type="button" class="btn bg-yellow pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">person_add</i> Nuevo Usuario</button>
                            </div>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de Usuarios"
                            :columns="columns"
                            :rows="users"
                            :paginationOptions="{
                                enabled: true,
                                dropdownAllowAll: false,
                                nextLabel: 'Sig',
                                prevLabel: 'Ant',
                                rowsPerPageLabel: 'Registros por Pagina',
                                ofLabel: 'de',
                                allLabel: 'Todos',
                            }"
                            @on-row-dblclick="processEdit"
                            :rowStyleClass="'enlace'"
                            :lineNumbers="true"
                            styleClass="vgt-table condensed bordered striped">
                                <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'btn'" class="center">
                                        <button title="Eliminar Usuario" class="btn btn-danger btn-xs" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button>
                                    </span>
                                    <span v-if="props.column.field == 'enabled'" class="center">
                                        <toggle-button :value="props.row.enabled" :color="{checked: '#337ab7', unchecked: '#FF0000'}" :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" @change="updateAtributos(props.row.id,props.row.enabled)"/>                            
                                    </span>
                                    <span v-else>
                                        {{props.formattedRow[props.column.field]}}
                                    </span>
                                </template>                                                          
                            </vue-good-table>
                        </div>
                    </div>
                    <!-- END DEFAULT DATATABLE -->                       
                    
                </div> 
            </div>
        </section> 
        <!-- PAGE CONTENT MODAL -->  
        <modal name="usuario" :width="'60%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de empresas -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Registro de Usuario</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('usuario')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionUsuario">
                    <div class="form-body">
                        <div class="col-md-12 pt-20">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombre de Usuario <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm" name="nombre_usuario" v-model="dataUsuario.name" required>
                                </div>                         
                            </div><!-- /.form-group -->    
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombres y Apellidos <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="nombre_completo" v-model="dataUsuario.name_complete" required>
                                </div>                         
                            </div><!-- /.form-group -->                                               
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Email </label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control input-sm" name="email" v-model="dataUsuario.email">
                                </div>
                            </div><!-- /.form-group -->  
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Rol <span class="asterisk">*</span></label>
                                <div class="col-md-7 col-sm-7 col-xs-7">
                                    <basic-select :options="combo_roles"
                                    :selected-option="item_rol"
                                    placeholder="seleccione una opción"
                                    @select="onSelectRol">
                                    </basic-select>
                                </div>
                                <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_rol.text"></span>
                                <div class="col-md-1 col-sm-1" v-if="item_rol.text">
                                    <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetRol"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                                </div>
                            </div>                                                                     
                                                                                                                                                                                                        
                        </div>                   
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('usuario')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active" :disabled="ShowIcon"><i :class="[IconClass]"></i> {{ labelButton }}</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
            <!-- /. form de registro de empresas -->
        </modal>               
    </div>    
</template>
<script>
import { BasicSelect } from 'vue-search-select'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'usuarios',
    mounted() {
        this.$store.dispatch('LOAD_USERS_LIST')
        this.$store.dispatch('LOAD_COMBO_ROLES_LIST')                            
    },        
    data() {
        return {
            searchText: '', // If value is falsy, reset searchText & searchItem
            item_rol: { value: '', text: ''},                         

            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Grabar Datos',              

            columns: [
                {
                label: 'UserName',
                field: 'name',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'30%',
                },
                {
                label: 'Nombres y Apellidos',
                field: 'name_complete',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'30%',
                },                
                {
                label: 'Email',
                field: 'email',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',
                }, 
                {
                label: 'Habilitado',
                field: 'enabled',
                html: true,
                tdClass: 'center',
                width:'10%',                
                },                                                                                            
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'10%',  
                }                               
            ],
            dataUsuario : {
                name:'',
                name_complete:'',
                email:'',
                password:'',
                enabled:true,
                roles:[]   
            }, 
            dataAtributos: {
                enabled:null
            },                           
            errors:[]
        }
    },
    computed: {
        ...mapState(['users','combo_roles']),
    },
    components: {
      BasicSelect
    },            
    methods: {
        LoadForm: function(){  
            this.item_rol = {}              
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataUsuario = {
                name:'',
                name_complete:'',
                email:'',
                password:'',
                enabled:true,
                roles:[]   
            }, 
            this.$store.dispatch('LOAD_COMBO_ROLES_LIST')                                    
            this.$modal.show('usuario')
        },
        ActionUsuario: function(){
            if(typeof(this.dataUsuario.id) === "undefined"){
                this.createUsuario()
            }else{
                this.updateUsuario()
            }
        },
        createUsuario: function(){
            var url = '/api/users';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataUsuario).then(response => {
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
                    this.labelButton = 'Grabar Datos'                  
                    return;
                }
                //this.getEmployee(this.pagination.current_page,this.employeeSearch); 
                this.$store.dispatch('LOAD_USERS_LIST')    
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'
                this.labelButton = 'Grabar Datos'              
                this.$modal.hide('usuario');
                toastr.success('Nuevo Usuario creada con exito');
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'
                this.labelButton = 'Grabar Datos'   
                console.log(error.response.status);
            });
        },
        updateUsuario: function(){
            var url = '/api/users/'+this.dataUsuario.id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'          
            axios.put(url, this.dataUsuario).then(response => {
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
                //this.getEmployee(this.pagination.current_page,this.employeeSearch); 
                this.$store.dispatch('LOAD_USERS_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('usuario');
                toastr.success('el Usuario fue actualizado con exito');          
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'                 
                console.log(error.response.status);
            });
        },
        processEdit(params){
            this.$store.dispatch('LOAD_COMBO_ROLES_LIST') 
            this.item_rol = {}    
            var datausu = []
            datausu = _.clone(params.row)       
            //this.item_rol = this.combo_roles.find(ro => ro.value == datausu.roles[0].id)
            this.dataUsuario = {
                id:datausu.id,
                name:datausu.name,
                name_complete:datausu.name_complete,
                email:datausu.email, 
                enabled:datausu.enabled,
                roles:[]                        
            }  
            if(typeof(datausu.roles[0]) != "undefined"){
                this.item_rol = this.combo_roles.find(ro => ro.value == datausu.roles[0].id)
                this.dataUsuario.roles.push(datausu.roles[0].id) 
            }   
     
            this.$modal.show('usuario')        
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar este Usuario ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/users/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                this.$store.dispatch('LOAD_USERS_LIST')                    
                toastr.success('Usuario Eliminado correctamente');
                dialog.close();
                });
                })
            .catch(() => {
                console.log('Delete aborted');
            });
        },
        updateAtributos: function(id,acce){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Actualizar este atributo ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/users/updateattribute/'+id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;

                if(acce != null){
                    if(acce == true){
                        this.dataAtributos.enabled = false
                    }else{
                        this.dataAtributos.enabled = true
                    }
                }            
                axios.put(url, this.dataAtributos).then(response => {
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

                this.errors = [];
                toastr.success('se actualizaron los datos correctamente');
                dialog.close();
                this.$store.dispatch('LOAD_USERS_LIST')             
                }).catch(error => {
                    this.errors = error.response.data.status;
                    toastr.error("Hubo un error en el proceso: "+this.errors);
                    dialog.close();
                });
                })
            .catch(() => {
                this.$store.dispatch('LOAD_USERS_LIST')         
            });
        }, 

        onSelectRol (item_rol) {
            this.item_rol = item_rol
            this.dataUsuario.roles = []
            this.dataUsuario.roles.push(item_rol.value)
        },
        resetRol () {
            this.item_rol = {}
            this.dataUsuario.roles = []   
        }                                       
    } 
}

</script>
<style scoped>
      
    .v--modal-overlay {
        z-index:9000;
    }    
    .label-grupo {
        text-align: left;
        border: 1px solid gray;
    }   

</style>


