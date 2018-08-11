<template>
    <div>
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
                    <div class="panel panel-primary">
                        <div class="panel-heading"> 
                            <h3 class="panel-title">VillaSalud</h3>                               
                            <div class="row">
                                <button type="button" class="btn btn-info pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">store_mall_directory</i> Nuevo Rol</button>
                            </div>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de Roles"
                            :columns="columns"
                            :rows="roles"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="processEdit(props.row)">{{ props.row.name }}</td>
                                    <td class="enlace" @click.prevent="processEdit(props.row)">{{ props.row.slug }}</td>
                                    <td class="enlace" @click.prevent="processEdit(props.row)">{{ props.row.description }}</td>
                                    <td class="enlace" @click.prevent="processEdit(props.row)">{{ props.row.special }}</td>
                                    <td class="center"><button title="Eliminar Rol" class="btn btn-danger btn-xs" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button></td>
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
                            <div class="form-group">
                                <label for="" class="col-sm-4 control-label">Permiso Especial </label>
                                <div class="col-sm-8 pt-5">
                                    <p class="mb-0">
                                        Sin Permiso Especial <input type="radio" name="radacceso" class="mr-20" v-model="dataRol.special" />
                                        Acceso Total <input type="radio" name="radacceso" value="all-access" class="mr-20" v-model="dataRol.special" />
                                        Sin Acceso <input type="radio" name="radacceso" value="no-access" v-model="dataRol.special" />
                                    </p>
                                </div>
                            </div><!-- /.form-group -->   
                            <div class="form-group">
                                <div class="col-md-12" v-for="permiso in permisos" :key="permiso.id">
                                    <label :for="permiso.name" class="label-cbx">
                                        <input type="checkbox" :id="permiso.id" :value="permiso.id" v-model="dataRol.permissions" > {{ permiso.name}}
                                    </label>
                                </div>
                            </div>                                        
                                                                                                                                                                                                        
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
    </div>    
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name:'roles',
    mounted() {
        this.$store.dispatch('LOAD_ROLES_LIST')
        this.$store.dispatch('LOAD_PERMISOS_LIST')            
    },        
    data() {
        return {
            searchText: '', // If value is falsy, reset searchText & searchItem

            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Grabar Datos',             

            textpage: 'Registros por pagina',
            textnext:'Sig',
            textprev:'Ant',
            textof:'de',
            columns: [
                {
                label: 'Nombre',
                field: 'name',
                filterable: true,
                width:'35%',
                },  
                {
                label: 'Slug',
                field: 'slug',
                filterable: true,
                width:'20%',
                }, 
                {
                label: 'Descripcion',
                field: 'description',
                filterable: true,
                width:'15%',
                },                 
                {
                label: 'Special',
                field: 'special',
                filterable: true,
                width:'20%',
                },                                                                                                          
                {
                label: 'Acción',
                html: true  ,
                width:'10%',  
                }                               
            ],  
            dataRol : {
                name:'',
                slug:'',
                description:'',
                special:null ,
                permissions:[]   
            },                       
            errors:[]
        }
    },
    computed: {
        ...mapState(['roles','permisos']),
    },     
    methods: {
        onClickFn: function(row, index){
            console.log(row)
        },
        LoadForm: function(){  
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataRol = {
                name:'',
                slug:'',
                description:'',
                special:null ,
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
        processEdit(ro){
            var dataro = []
            dataro = _.clone(ro)
            this.dataRol = {
                id:dataro.id,
                name:dataro.name,
                slug:dataro.slug,
                description:dataro.description,
                special:dataro.special             
            } 
            //console.log('permisos :',dataro.permissions) 
            var list=[];
            dataro.permissions.map(function(value, key) {
                list.push(value.id)
            })    
            this.dataRol.permissions = list                        
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
        }                                                     
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


