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
            Documentos
            <small>Mantenimiento de Documentos</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Documentos</li>
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
                                <button type="button" class="btn bg-yellow pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">description</i> Nuevo Documento</button>
                            </div>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de Documentos"
                            :columns="columns"
                            :rows="documentos"
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
                                        <button title="Eliminar Documento" class="btn btn-danger btn-xs" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button>
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
        <modal name="documento" :width="'50%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de documentos -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Registro de Documentos</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('documento')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionDocumento">
                    <div class="form-body">
                        <div class="col-md-12 pt-20">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombre <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="nombre_documento" v-model="dataDocumento.nombre_documento" required>
                                </div>                         
                            </div><!-- /.form-group -->                                                                                                                                                                                                                                                                 
                        </div>                   
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('documento')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active" :disabled="ShowIcon"><i :class="[IconClass]"></i> {{ labelButton }}</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
            <!-- /. form de registro de documentos -->
        </modal>               
    </div>
 
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name:'documentos',
    created() {
        this.$store.dispatch('LOAD_DOCUMENTOS_LIST').then(() => {
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
                label: 'Nombre de Documento',
                field: 'nombre_documento',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'90%',
                },                                                                                                           
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'10%',  
                }                               
            ],  
            dataDocumento : {
                nombre_documento:''
            },                       
            errors:[]
        }
    },
    computed: {
        ...mapState(['documentos']),
    },     
    methods: {
        LoadForm: function(){  
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataDocumento = {
                nombre_documento:''   
            }             
            this.$modal.show('documento')
        }, 
        ActionDocumento: function(){
            if(typeof(this.dataDocumento.id) === "undefined"){
                this.createDocumento()
            }else{
                this.updateDocumento()
            }
        },
        createDocumento: function(){
            var url = '/api/documentos';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataDocumento).then(response => {
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
            this.$store.dispatch('LOAD_DOCUMENTOS_LIST')    
            this.errors = [];
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'
            this.labelButton = 'Grabar Datos'              
            this.$modal.hide('documento');
            toastr.success('Nuevo Tipo de ingreso creado con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            });
        },
        updateDocumento: function(){
            var url = '/api/documentos/'+this.dataDocumento.id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'          
            axios.put(url, this.dataDocumento).then(response => {
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
                this.$store.dispatch('LOAD_DOCUMENTOS_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('documento');
                toastr.success('el Tipo de ingreso fue actualizado con exito');          
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'                 

            });
        },
        processEdit(params){
            var datatip = []
            datatip = _.clone(params.row)

            this.dataDocumento = {
                id:datatip.id,
                nombre_documento:datatip.nombre_documento           
            }            
            this.$modal.show('documento')
        
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar este Documento ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/documentos/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                this.$store.dispatch('LOAD_DOCUMENTOS_LIST')                    
                toastr.success('Documento Eliminado correctamente');
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