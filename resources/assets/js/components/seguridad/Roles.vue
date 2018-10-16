<template>
    <div>
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading>         
        <section class="content-header">
        <h1>
            Roles
            <small>Mantenimiento de Roles</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Roles</li>
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
                                <button type="button" class="btn bg-yellow pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">group_add</i> Nuevo Rol</button>
                            </div>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de Roles"
                            :columns="columns"
                            :rows="roles"
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
                                        <button title="Eliminar Rol" class="btn btn-danger btn-xs" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button>
                                        <button title="Configurar Modulos" class="btn btn-primary btn-xs" @click.prevent="cargaModulos(props.row)"><i class="material-icons md-18">assignment</i></button>
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
        <modal name="rol" :width="'50%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de empresas -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Registro de Rol</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('rol')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionRol">
                    <div class="form-body">
                        <div class="col-md-12 pt-20">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombre <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="name" v-model="dataRol.name" required>
                                </div>                         
                            </div><!-- /.form-group -->                    
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Slug <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm minusculas" name="slug" v-model="dataRol.slug" required>
                                </div>
                            </div><!-- /.form-group -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Descripcion </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm" name="descripcion" v-model="dataRol.description">
                                </div>
                            </div><!-- /.form-group --> 
                            <!-- Permisos para usar mas adelante -->
<!--                             <div class="form-group">
                                <label for="" class="col-sm-4 control-label">Permiso Especial </label>
                                <div class="col-sm-8 pt-5">
                                    <p class="mb-0">
                                        Sin Permiso Especial <input type="radio" name="radacceso" class="mr-20" v-model="dataRol.special" />
                                        Acceso Total <input type="radio" name="radacceso" value="all-access" class="mr-20" v-model="dataRol.special" />
                                        Sin Acceso <input type="radio" name="radacceso" value="no-access" v-model="dataRol.special" />
                                    </p>
                                </div>
                            </div> --><!-- /.form-group -->   
<!--                             <div class="form-group">
                                <div class="col-md-12" v-for="permiso in permisos" :key="permiso.id">
                                    <label :for="permiso.name" class="label-cbx">
                                        <input type="checkbox" :id="permiso.id" :value="permiso.id" v-model="dataRol.permissions" > {{ permiso.name}}
                                    </label>
                                </div>
                            </div>  -->                                       
                                                                                                                                                                                                        
                        </div>                   
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('rol')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active" :disabled="ShowIcon"><i :class="[IconClass]"></i> {{ labelButton }}</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
            <!-- /. form de registro de empresas -->
        </modal> 
          <!-- modal de configuracion-->
        <modal name="modulos" :width="'70%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de Modulos -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Configuración del Rol</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('modulos')"><i class="fa fa-close"></i></div>                
                </div>
                <div>
                    <div class="form-body">
                        <div class="col-md-12 mt-10 p-0">
                            <div class="row ml-5 mr-5" style="display: flex; flex-wrap: wrap;">
                                <div class="col-md-6 pl-20 pr-20 pb-10" v-for="module in modules" :key="module.id" style="display: flex;flex-direction: column;">
                                    <div class="table table-responsive table-bordered mb-10" style="width: 100%">
                                        <table class="table mb-0">
                                            <thead class="bg-primary">
                                                <tr>
                                                    <th class="text-center" style="width: 50px;">   
                                                        <div class="ckbox ckbox-default rounded">
                                                            <label :for="module.idmenu" class="label-cbx">
                                                            <input :id="module.idmenu" :value="module.idmenu" v-model="dataRolModulo.checkedRol" type="checkbox" class="invisible" @change="updateChildren($event,module)">
                                                            <div class="checkbox mt-0 mb-0">
                                                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                                <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                                                <polyline points="4 11 8 15 16 6"></polyline>
                                                                </svg>
                                                            </div>
                                                            </label>                                                          
                                                        </div>                                                         
                                                    </th>
                                                    <th><strong>{{module.name}}</strong></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="opcion in module.options" :key="opcion.options.options.id">
                                                    <td class="text-center">                                                    
                                                        <div class="ckbox ckbox-default rounded">
                                                            <label :for="opcion.options.options.id" class="label-cbx">
                                                            <input :id="opcion.options.options.id" :value="opcion.options.options.id" v-model="dataRolModulo.checkedRol" type="checkbox" class="invisible" @change="updateParent($event,opcion,module)">
                                                            <div class="checkbox mt-0 mb-0">
                                                                <svg width="20px" height="20px" viewBox="0 0 20 20">
                                                                <path d="M3,1 L17,1 L17,1 C18.1045695,1 19,1.8954305 19,3 L19,17 L19,17 C19,18.1045695 18.1045695,19 17,19 L3,19 L3,19 C1.8954305,19 1,18.1045695 1,17 L1,3 L1,3 C1,1.8954305 1.8954305,1 3,1 Z"></path>
                                                                <polyline points="4 11 8 15 16 6"></polyline>
                                                                </svg>
                                                            </div>
                                                            
                                                            </label>      
                                                        </div>                                                        
                                                    </td>
                                                    <td>{{opcion.name}}</td> 
                                                </tr> 
                                            </tbody>
                                        </table>
                                    </div><!-- /.table-responsive --> 
                                </div>
                            </div>
                        </div>
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('modulos')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="button" class="btn btn-success active" :disabled="ShowIcon" @click="updateModulos"><i :class="[IconClass]"></i> {{ labelButton }}</button>
                        </div>
                    </div><!-- /.form-footer -->                
                </div>
            </div>
            <!-- /. form de Perfiles -->
        </modal>
        <!-- /. modal -->                      
    </div>    
</template>
<script>
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'roles',
    mounted() {
        this.$store.dispatch('LOAD_ROLES_LIST')
        //this.$store.dispatch('LOAD_PERMISOS_LIST') 
        this.$store.dispatch('LOAD_MODULES_LIST').then(() => {
            this.isLoading = false
        })           
    },        
    data() {
        return {
            isLoading: true,
            fullPage: true,
                        
            searchText: '', // If value is falsy, reset searchText & searchItem

            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Grabar Datos',             

            columns: [
                {
                label: 'Nombre',
                field: 'name',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'35%',
                },  
                {
                label: 'Slug',
                field: 'slug',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'30%',
                }, 
                {
                label: 'Descripcion',
                field: 'description',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'25%',
                },                                                                                                                          
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'10%',  
                }                               
            ],  
            dataRol : {
                name:'',
                slug:'',
                description:'',
                special: 'all-access' ,
                permissions:[]   
            }, 
            dataRolModulo : {
                idRol : '',
                checkedRol :[]
            },                                  
            errors:[]
        }
    },
    computed: {
        ...mapState(['roles','modules']),
    },     
    methods: {
        LoadForm: function(){  
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataRol = {
                name:'',
                slug:'',
                description:'',
                special: 'all-access' ,
                permissions:[]        
            }           
            this.$modal.show('rol')
        }, 
        ActionRol: function(){
            if(typeof(this.dataRol.id) === "undefined"){
                this.createRol()
            }else{
                this.updateRol()
            }
        },
        createRol: function(){
            var url = '/api/roles';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataRol).then(response => {
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
                this.$store.dispatch('LOAD_ROLES_LIST')    
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'
                this.labelButton = 'Grabar Datos'              
                this.$modal.hide('rol');
                toastr.success('Nuevo Rol creado con exito');
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
            });
        },
        updateRol: function(){
            var url = '/api/roles/'+this.dataRol.id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'          
            axios.put(url, this.dataRol).then(response => {
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
                this.$store.dispatch('LOAD_ROLES_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('rol');
                toastr.success('el Rol fue actualizada con exito');          
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'                 

            });
        },
        processEdit(params){
            var dataro = []
            dataro = _.clone(params.row)
            this.dataRol = {
                id:dataro.id,
                name:dataro.name,
                slug:dataro.slug,
                description:dataro.description,
                special:dataro.special             
            } 
            //console.log('permisos :',dataro.permissions) 
/*             var list=[];
            dataro.permissions.map(function(value, key) {
                list.push(value.id)
            })    
            this.dataRol.permissions = list    */                     
            this.$modal.show('rol')
        
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar este Rol ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/roles/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                    this.$store.dispatch('LOAD_ROLES_LIST')                    
                    toastr.success('Rol Eliminado correctamente');
                    dialog.close();
                });
                })
            .catch(() => {
                console.log('Delete aborted');
            });
        },
        cargaModulos(row){
            var list=[];
            row.modules.map(function(value, key) {
                list.push(value.id)
            })    
            this.dataRolModulo.idRol = row.id
            this.dataRolModulo.checkedRol = list  

            this.$modal.show('modulos')    
        },
        updateModulos: function(){
            var url = '/api/roles/updateModules/'+this.dataRolModulo.idRol;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            axios.put(url, this.dataRolModulo).then(response => {
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
                this.$store.dispatch('LOAD_ROLES_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('modulos');
                toastr.success('el Rol fue actualizada con exito');    
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'  
            });
        },         
        updateChildren: function(e,valor){
            var list=[]
            valor.options.map(function(value, key) {
                list.push(value.options.options.id)
            })    
            if(e.target.checked){     // seleccionamos todos
                this.dataRolModulo.checkedRol = _.union(this.dataRolModulo.checkedRol,list)
            }else{        // deseleccionamos todos
                this.dataRolModulo.checkedRol = _.difference(this.dataRolModulo.checkedRol,list)
            }
        } ,
        updateParent: function(e,valor,mod){
            var list=[]
            var search = false
            mod.options.map(function(value, key) {
                list.push(value.options.options.id)
            })      
            if(e.target.checked){
                if(_.indexOf(this.dataRolModulo.checkedRol,valor.options.idmenu)  == -1){
                    this.dataRolModulo.checkedRol.push(valor.options.idmenu)
                }
            }
            else{
                var self = this
                _.map(list, function(value) {
                if(_.indexOf(self.dataRolModulo.checkedRol,value)  > -1){
                    search = true
                    }
                }); 
                if(!search){
                    var i = _.indexOf(self.dataRolModulo.checkedRol,valor.idmenu)
                    self.dataRolModulo.checkedRol.splice(i,1)
                }
            }
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

    /*-- Estilos del input check ---*/
    .label-cbx {
        user-select: none;
        cursor: pointer;
        margin-bottom: 0;
    }
    .label-cbx input:checked + .checkbox {
        border-color: #20C2E0;
    }
    .label-cbx input:checked + .checkbox svg path {
        fill: #20C2E0;
    }
    .label-cbx input:checked + .checkbox svg polyline {
        stroke-dashoffset: 0;
    }
    .label-cbx:hover .checkbox svg path {
        stroke-dashoffset: 0;
    }
    .label-cbx .checkbox {
        position: relative;
        top: 2px;
        float: left;
        margin-right: 8px;
        width: 20px;
        height: 20px;
        border: 2px solid #C8CCD4;
        border-radius: 3px;
    }
    .label-cbx .checkbox svg {
        position: absolute;
        top: -2px;
        left: -2px;
    }
    .label-cbx .checkbox svg path {
        fill: none;
        stroke: #20C2E0;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-dasharray: 71px;
        stroke-dashoffset: 71px;
        transition: all 0.6s ease;
    }
    .label-cbx .checkbox svg polyline {
        fill: none;
        stroke: #FFF;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
        stroke-dasharray: 18px;
        stroke-dashoffset: 18px;
        transition: all 0.3s ease;
    }
    .label-cbx > span {
        pointer-events: none;
        vertical-align: middle;
    }

    .cntr {
        position: absolute;
        top: 45%;
        left: 0;
        width: 100%;
        text-align: center;
    }

    .invisible {
        position: absolute;
        z-index: -1;
        width: 0;
        height: 0;
        opacity: 0;
    }

</style>


