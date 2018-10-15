<template>
    <div>
        <section class="content-header">
        <h1>
            Proveedores
            <small>Mantenimiento de Proveedores</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Proveedores</li>
        </ol>
        </section>    
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- START DEFAULT DATATABLE -->
                    <div class="panel panel-danger">
                        <div class="panel-heading bg-red-active"> 
                            <!-- <h3 class="panel-title">VillaSalud</h3> -->                               
                            <div class="row">
                                <button type="button" class="btn bg-yellow pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">local_shipping</i> Nuevo Proveedor</button>
                            </div>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de Proveedores"
                            :columns="columns"
                            :rows="proveedores"
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
                                        <button title="Eliminar Proveedor" class="btn btn-danger btn-xs" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button>
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
        <modal name="proveedor" :width="'50%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de proveedores -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Registro de Proveedores</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('proveedor')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionProveedor">
                    <div class="form-body">
                        <div class="col-md-12 pt-20">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombre <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="nombre" v-model="dataProveedor.nombre_proveedor" required>
                                </div>                         
                            </div><!-- /.form-group -->    
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Direccion <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="direccion" v-model="dataProveedor.direccion" required>
                                </div>                         
                            </div><!-- /.form-group -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">RUC <span class="asterisk">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control input-sm" name="ruc" v-model="dataProveedor.ruc" maxlength="11" required>
                                </div>                         
                            </div><!-- /.form-group -->   
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Telefono </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm" name="telefono" v-model="dataProveedor.telefono" >
                                </div>                         
                            </div><!-- /.form-group -->
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Celular </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm " name="celular" v-model="dataProveedor.celular" >
                                </div>                         
                            </div><!-- /.form-group -->   
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Email </label>
                                <div class="col-sm-8">
                                    <input type="email" class="form-control input-sm " name="email" v-model="dataProveedor.email" >
                                </div>                         
                            </div><!-- /.form-group -->                                                                                                                                                                                                                                                                                                                                                                                                            
                        </div>                   
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('proveedor')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active" :disabled="ShowIcon"><i :class="[IconClass]"></i> {{ labelButton }}</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
            <!-- /. form de registro de proveedores -->
        </modal>               
    </div>
 
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name:'proveedores',
    mounted() {
        this.$store.dispatch('LOAD_PROVEEDORES_LIST')            
    },        
    data() {
        return {
            searchText: '', // If value is falsy, reset searchText & searchItem

            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Grabar Datos',             

            columns: [
                {
                label: 'Proveedor',
                field: 'nombre_proveedor',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'25%',
                },                 
                {
                label: 'Direccion',
                field: 'direccion',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'25%',
                },  
                {
                label: 'RUC',
                field: 'ruc',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'10%',
                }, 
                {
                label: 'Telefono',
                field: 'telefono',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'10%',
                },
                {
                label: 'Celular',
                field: 'celular',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'10%',
                },  
                {
                label: 'Email',
                field: 'email',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
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
            dataProveedor : {
                nombre_proveedor:'',
                direccion:'',
                ruc:'',
                telefono:'',
                celular:'',
                email:''

            },                       
            errors:[]
        }
    },
    computed: {
        ...mapState(['proveedores']),
    },     
    methods: {
        LoadForm: function(){  
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataProveedor = {
                nombre_proveedor:'',
                direccion:'',
                ruc:'',
                telefono:'',
                celular:'',
                email:''
            }           
            this.$modal.show('proveedor')
        }, 
        ActionProveedor: function(){
            if(typeof(this.dataProveedor.id) === "undefined"){
                this.createProveedor()
            }else{
                this.updateProveedor()
            }
        },
        createProveedor: function(){
            var url = '/api/proveedores';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataProveedor).then(response => {
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
            this.$store.dispatch('LOAD_PROVEEDORES_LIST')    
            this.errors = [];
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'
            this.labelButton = 'Grabar Datos'              
            this.$modal.hide('proveedor');
            toastr.success('Nuevo Proveedor creado con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            });
        },
        updateProveedor: function(){
            var url = '/api/proveedores/'+this.dataProveedor.id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'          
            axios.put(url, this.dataProveedor).then(response => {
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
                this.$store.dispatch('LOAD_PROVEEDORES_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('proveedor');
                toastr.success('el Proveedor fue actualizado con exito');          
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'                 
            });
        },
        processEdit(params){
            var datapro = []
            datapro = _.clone(params.row)

            this.dataProveedor = {
                id:datapro.id,
                nombre_proveedor:datapro.nombre_proveedor, 
                direccion:datapro.direccion,
                ruc:datapro.ruc,
                telefono:datapro.telefono,
                celular:datapro.celular,  
                email:datapro.email                                           
            }            
            this.$modal.show('proveedor')
        
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar este Proveedor ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/proveedores/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                this.$store.dispatch('LOAD_PROVEEDORES_LIST')                    
                toastr.success('Proveedor Eliminado correctamente');
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
    .v--modal-overlay {
        z-index:9000;
    }    

    .label-grupo {
        text-align: left;
        border: 1px solid gray;
    }      
   
</style>