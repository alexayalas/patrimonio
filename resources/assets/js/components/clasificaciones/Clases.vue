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
            Clases
            <small>Mantenimiento de Clases</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Clases</li>
        </ol>
        </section>    
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- START DEFAULT DATATABLE -->
                    <div class="panel panel-danger">
                        <div class="panel-heading bg-red-active"> 
                            <!-- <h3 class="panel-title">VillaSalud</h3>    -->                            
                            <div class="row">
                                <button type="button" class="btn bg-yellow pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">queue_play_next</i> Nueva Clase</button>
                            </div>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de clases"
                            :columns="columns"
                            :rows="clases"
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
                                        <button title="Eliminar clase" class="btn btn-danger btn-xs" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button>                                    </span>
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
        <modal name="clase" :width="'50%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de clases -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Registro de clase</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('clase')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionClase">
                    <div class="form-body">
                        <div class="col-md-12 pt-20">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Grupo </label>
                                <div class="col-md-7 col-sm-7 col-xs-7">
                                    <basic-select :options="combo_grupos"
                                    :selected-option="item_gru"
                                    placeholder="seleccione una opción"
                                    @select="onSelectGru">
                                    </basic-select>
                                </div>
                                <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_gru.text"></span>
                                <div class="col-md-1 col-sm-1" v-if="item_gru.text">
                                    <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetGru"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                                </div>
                            </div>                              
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombre <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="nombre_clase" v-model="dataClase.nombre_clase" required>
                                </div>                         
                            </div><!-- /.form-group -->                                                              
                                                                                                                                                                                                        
                        </div>                   
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('clase')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active" :disabled="ShowIcon"><i :class="[IconClass]"></i> {{ labelButton }}</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
            <!-- /. form de registro de clases -->
        </modal>              
    </div>
 
</template>
<script>
import { BasicSelect } from 'vue-search-select'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'clases',
    created() {
        this.$store.dispatch('LOAD_CLASES_LIST').then(() => {
            this.isLoading = false
        }) 
        this.$store.dispatch('LOAD_GRUPOS_LIST') 
        this.$store.dispatch('LOAD_COMBO_GRUPOS_LIST')                    
    },        
    data() {
        return {
            isLoading: true,
            fullPage: true,
                        
            searchText: '', // If value is falsy, reset searchText & searchItem
            item_gru: { value: '', text: ''},              

            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Grabar Datos',              

            columns: [
                {
                label: 'Grupo',
                field: 'grupo.nombre_grupo',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'40%',
                },
                {
                label: 'Clase',
                field: 'nombre_clase',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'50%',
                },                                                           
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'10%',  
                }                               
            ],
            dataClase : {
                grupo_id:'',
                nombre_clase:''   
            },                
            errors:[]
        }
    },
    computed: {
        ...mapState(['clases','combo_grupos']),
    },
    components: {
      BasicSelect
    },            
    methods: {
        onClickFn: function(row, index){
            console.log(row)
        },
        LoadForm: function(){  
            this.item_gru = {}              
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataClase = {
                grupo_id:'',
                nombre_clase:''   
            }  
            this.$store.dispatch('LOAD_COMBO_GRUPOS_LIST')                      
            this.$modal.show('clase')
        },
        ActionClase: function(){
            if(typeof(this.dataClase.id) === "undefined"){
                this.createClase()
            }else{
                this.updateClase()
            }
        },
        createClase: function(){
            var url = '/api/clases';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataClase).then(response => {
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
            this.$store.dispatch('LOAD_CLASES_LIST')    
            this.errors = [];
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'
            this.labelButton = 'Grabar Datos'              
            this.$modal.hide('clase');
            toastr.success('Nueva clase creada con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },
        updateClase: function(){
            var url = '/api/clases/'+this.dataClase.id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'          
            axios.put(url, this.dataClase).then(response => {
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
                this.$store.dispatch('LOAD_CLASES_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('clase');
                toastr.success('la clase fue actualizada con exito');          
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
            var datacla = []
            datacla = _.clone(params.row)
            this.item_gru= this.combo_grupos.find((gru) => gru.value == datacla.grupo_id)

            this.dataClase = {
                id:datacla.id,
                nombre_clase:datacla.nombre_clase,
                grupo_id:datacla.grupo_id         
            }            
            this.$modal.show('clase')
        
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar esta Clase ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/clases/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                this.$store.dispatch('LOAD_CLASES_LIST')                    
                toastr.success('clase Eliminada correctamente');
                dialog.close();
                });
                })
            .catch(() => {
                console.log('Delete aborted');
            });
        },               
        onSelectGru (item_gru) {
            this.item_gru = item_gru
            this.dataClase.grupo_id = item_gru.value
        },
        resetGru () {
            this.item_gru = {}
            this.dataClase.grupo_id = ''   
        },                               
    },
       
  
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