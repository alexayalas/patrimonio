<template>
    <div>
        <section class="content-header">
            <h1>
                {{ NombreEmpresa.nombre_empresa}}
                <small>Lista de Bajas</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active">Bajas</li>
            </ol>
        </section> 
        <div class="clearfix"></div>   
        <section class="content">
            <div class="col-md-12 pl-0 pr-0">
                <!-- START DEFAULT DATATABLE -->
                <div class="panel panel-danger">
                    <div class="panel-heading bg-red-active"> 
                        <div class="row">
                            <button type="button" class="btn bg-yellow pull-right mr-10" @click="$modal.show('bien')"><i class="material-icons bootstro-prev-btn mr-5">swap_horizontal_circle</i> Registrar Baja</button>
                        </div>                                                        
                    </div>
                    <div class="panel-body">
                        <vue-good-table
                        :columns="columns"
                        :rows="BajasByEmpresa"
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
                                <span v-if="props.column.field == 'btn'">
                                    <button type="button" class="btn btn-danger btn-xs" title="ELIMINAR BAJA" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button>
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
        </section>
        <!-- form para seleccionar el bien a trasladar -->
        <modal name="bien" width="80%" height="auto" :scrollable="true" :clickToClose="false">
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Lista de Bienes</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('bien')"><i class="fa fa-close"></i></div>                
                </div>
                <div class="row col-md-12 ml-10 pl-0 mr-0 mt-10 mb-10">
                    <!-- START DEFAULT DATATABLE -->
                    <vue-good-table
                    :columns="columns_biens"
                    :rows="BienesByEmpresa"
                    :paginationOptions="{
                        enabled: true,
                        dropdownAllowAll: false,
                        nextLabel: 'Sig',
                        prevLabel: 'Ant',
                        rowsPerPageLabel: 'Registros por Pagina',
                        ofLabel: 'de',
                        allLabel: 'Todos',
                    }"
                    @on-row-click="onRowClick"
                    max-height="400px"
                    styleClass="vgt-table condensed bordered striped">                           
                    </vue-good-table>
                    <!-- END DEFAULT DATATABLE -->  
                </div>
 
            </div>                      
        </modal>        
        <modal name="baja" width="70%" height="auto" :scrollable="true" :clickToClose="false">            
        <!-- form de registro del traslado -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Registro de Baja</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('baja')"><i class="fa fa-close"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionBaja">
                    <div class="col-md-6 pt-20 pr-0">
                        <div class="box box-danger">
                            <div class="box-body modal-main modal-item pt-0">
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Codigo del Bien</label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <label for="" class="control-label col-md-12 label-grupo pl-5">{{ dataShow.codigo_barra}} </label>   
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Descripcion</label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <label for="" class="control-label col-md-12 label-grupo pl-5">{{ dataShow.descripcion}} </label>   
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Marca</label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <label for="" class="control-label col-md-12 label-grupo pl-5">{{ dataShow.marca}} </label>   
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Modelo</label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <label for="" class="control-label col-md-12 label-grupo pl-5">{{ dataShow.modelo}} </label>   
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Numero de Serie</label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <label for="" class="control-label col-md-12 label-grupo pl-5">{{ dataShow.numero_serie }} </label>   
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Sede</label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <label for="" class="control-label col-md-12 label-grupo pl-5">{{ dataShow.sede }} </label>   
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Area</label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <label for="" class="control-label col-md-12 label-grupo pl-5">{{ dataShow.area }} </label>   
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Ubicacion</label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <label for="" class="control-label col-md-12 label-grupo pl-5">{{ dataShow.ubicacion }} </label>   
                                        </div>
                                    </div>
                                </div>                                                                                                                               
                            </div>                                                      
                        </div> 
                    </div>
                    <div class="col-md-6 pt-20 pr-20">
                        <div class="box box-danger">   
                            <div class="box-body modal-main modal-item pt-0">
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Fecha Baja </label>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                        <masked-input v-model="dataBaja.fecha_movimiento" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Num. Resolución <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input type="text" class="form-control input-sm mayusculas" name="medidas" v-model="dataBaja.numero_resolucion">
                                        </div>
                                    </div>
                                </div><!-- /.form-group -->  
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Motivo de Baja <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <textarea rows="3" cols="20" class="form-control input-sm mayusculas" name="caracteristicas" v-model="dataBaja.motivo_baja"></textarea>
                                        </div>
                                    </div>
                                </div><!-- /.form-group -->  
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Autorizado por <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_responsables"
                                                class="input-sm"
                                                :selected-option="item_aut"
                                                placeholder="seleccione un Empleado"
                                                @select="onSelectAut">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_aut.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Responsable" @click.prevent="resetAut" aria-hidden="true" v-if="item_aut.text"></span>
                                    </div>
                                </div>                                                                                                                                                                                              
                            </div>                                                                              
                        </div>                                                                                                                                                                                                                                                                                                                                                              
                    </div>                  
                    <div class="col-md-12 pt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('baja')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active" :disabled="ShowIcon"><i :class="[IconClass]"></i> {{ labelButton }}</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
        <!-- /. form de registro de traslados -->
        </modal>            
    </div>
 
</template>
<script>
import { BasicSelect } from 'vue-search-select'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'bajas',
    created() {
        this.$store.dispatch('LOAD_BIENES_LIST')          
        this.$store.dispatch('LOAD_MOVIMIENTOS_LIST')               
        this.$store.dispatch('LOAD_DATA_INIT_LIST') 
    },
    data() {
        return {
            edition: false,
            searchText: '', // If value is falsy, reset searchText & searchItem

            item_aut: { value:'' , text:''},   
                               
            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Grabar Datos',   

            columns: [
                {
                label: 'Codigo',
                field: 'bien.codigo_barra',
                width:'10%',
                },
                {
                label: 'Bien',
                field: 'bien.descripcion',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',
                },  
                {
                label: 'fecha',
                field: 'fecha_movimiento',
                type: 'date',
                dateInputFormat : 'YYYY-MM-DD',
                dateOutputFormat: 'DD/MM/YYYY',                
                width:'10%',                
                },                                  
                {
                label: 'Num. Resolución',
                field: 'numero_resolucion',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',                
                },
                {
                label: 'Motivo Baja',
                field: 'motivo_baja',
                filterOptions: {
                    enabled: true,
                    placeholder: 'Buscar', 
                },                
                width:'20%',                
                },
                {
                label: 'Autorizado',
                field: 'autorizado.nombre_completo',
                width:'15%',                
                },                                        
                {
                label: 'Acción',
                field: 'btn',
                html: true  ,
                width:'5%',  
                }                               
            ], 
            columns_biens: [
                {                    
                label: 'Codigo',
                field: 'codigo_barra',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'10%',
                },
                {
                label: 'Descripcion',
                field: 'descripcion',
                filterOptions: {
                    enabled: true,
                    placeholder: 'Buscar',
                },
                width:'20%',
                },                    
                {
                label: 'Marca',
                field: 'marca',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar',
                },
                width:'10%',                
                },
                {
                label: 'Modelo',
                field: 'modelo',
                width:'10%',                
                },
                {
                label: 'Serie',
                field: 'numero_serie',
                width:'10%',                
                },
                {
                label: 'fecha_registro',
                field: 'fecha_registro',
                type: 'date',
                dateInputFormat : 'YYYY-MM-DD',
                dateOutputFormat: 'DD/MM/YYYY',                
                width:'10%',                
                },
                {
                label: 'Ubicacion',
                field: 'ubicacion.nombre_ubicacion',
                width:'20%',                
                }                             
            ],  
            dataBaja : {
                bien_id:'',
                tipomovimiento:'Baja',
                fecha_movimiento: moment().format('DD/MM/YYYY'),                
                motivo_baja: '',
                numero_resolucion: '',
                autorizado_id:'',
                ubicacion_id_actual:''            
            },
            dataShow : {
                descripcion:'',
                marca:'',
                modelo:'',
                numero_serie:'',
                ubicacion:'',
                area:'',
                sede:'',
                encargado:''
            },
            combo_estados :[
                {value: 1 , text: 'Bueno'},
                {value: 2 , text: 'Malo'},
                {value: 3 , text: 'Regular'}     
            ],             
            errors:[]

        }
    },
    computed: {
        ...mapState(['empresas','combo_responsables']),
        ...mapGetters(['getBajasByEmpresaId','getBienesByEmpresaId']),             
        BajasByEmpresa: function(){
            return this.getBajasByEmpresaId(this.$route.params.empresa)
        },
        BienesByEmpresa: function(){
            return this.getBienesByEmpresaId(this.$route.params.empresa)
        },        
        NombreEmpresa: function(){
            return this.empresas.find(emp => emp.id == this.$route.params.empresa)
        }              
    },  
    components: {
      MaskedInput ,
      BasicSelect 
    }, 
    methods: {
        onRowClick(params) {
            var databaj = []
            databaj = _.clone(params.row)

            this.dataShow = {
                id : databaj.id,
                codigo_barra: databaj.codigo_barra,
                descripcion : databaj.descripcion,
                marca : databaj.marca,
                modelo : databaj.modelo,
                numero_serie : databaj.numero_serie,
                area : databaj.ubicacion.area.nombre_area,
                sede : databaj.ubicacion.area.sede.nombre_sede,
                ubicacion : databaj.ubicacion.nombre_ubicacion,
                ubicacion_id:databaj.ubicacion_id,              
                encargado_id:databaj.encargado_id                           
            }
            this.$modal.hide('bien')  
            this.LoadForm()            
        },        
        LoadForm: function(){   
            this.edition = false 
            this.item_aut = { value:'' , text:''},                 

            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataBaja = {
                bien_id:this.dataShow.id,
                tipomovimiento:'Baja',
                autorizado_id:'',           
                numero_resolucion: '',
                motivo_baja:'',
                fecha_movimiento: moment().format('DD/MM/YYYY'),
                ubicacion_id_actual:this.dataShow.ubicacion_id
            } 
            this.$store.dispatch('LOAD_DATA_INIT_LIST')                    
            this.$modal.show('baja')
        },
        ActionBaja: function(){
            if(typeof(this.dataBaja.id) === "undefined"){
                this.createBaja()
            }else{
                this.updateBaja()
            }
        },
        createBaja: function(){
            var url = '/api/movimientos';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataBaja).then(response => {
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
                this.$store.dispatch('LOAD_BIENES_LIST')
                this.$store.dispatch('LOAD_MOVIMIENTOS_LIST')    
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'
                this.labelButton = 'Grabar Datos'              
                this.$modal.hide('baja');
                toastr.success('Nuevo Registro creado con exito');
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);

            });
        },
        updateBaja: function(){
            var url = '/api/movimientos/'+this.dataBaja.id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'          
            axios.put(url, this.dataTraslado).then(response => {
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

                this.$store.dispatch('LOAD_MOVIMIENTOS_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('baja');
                toastr.success('El registro fue actualizado con exito');          
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'                 
            });
        },
        processEdit(params){
            this.edition = true

            var datatra = []
            datatra = _.clone(params.row)

            this.item_emp = this.combo_empresas.find(emp => emp.value == datatra.ubicacion_actual.area.empresa_id)
            this.item_sed = this.combo_sedes.find(sed => sed.value == datatra.ubicacion_actual.area.sede_id) 
            this.codemp = datatra.ubicacion_actual.area.empresa_id
            this.codsed = datatra.ubicacion_actual.area.sede_id
            this.codare = datatra.ubicacion_actual.area_id 
            this.item_are = this.areasBy.find(are => are.value == this.codare)  
            this.item_ubi = this.ubicacionesBy.find(ubi => ubi.value == datatra.ubicacion_id_actual) 

            this.item_res = this.combo_responsables.find(res => res.value == datatra.encargado_id_actual)
            this.item_aut = this.combo_responsables.find(aut => aut.value == datatra.autorizado_id)
            this.item_est = this.combo_estados.find(est => est.text == datatra.conservacion_actual)
   
            this.dataTraslado = {
                id:datatra.id,
                bien_id:datatra.bien_id,
                tipomovimiento:'Baja',
                ubicacion_id_anterior:datatra.ubicacion_id_anterior,
                ubicacion_id_actual:datatra.ubicacion_id_actual,                
                encargado_id_anterior:datatra.encargado_id_anterior,
                encargado_id_actual:datatra.encargado_id_actual,
                fecha_movimiento: datatra.fecha_movimiento,                
                conservacion_anterior: datatra.conservacion_anterior,
                conservacion_actual:datatra.conservacion_actual,                
                en_uso_anterior: datatra.en_uso_anterior,
                en_uso_actual: datatra.en_uso_actual,                
                tipo_traslado:datatra.tipo_traslado
            }

            this.dataShow = {
                id : datatra.bien_id,
                codigo_barra: datatra.bien.codigo_barra,
                descripcion : datatra.bien.descripcion,
                marca : datatra.bien.marca,
                modelo : datatra.bien.modelo,
                numero_serie : datatra.bien.numero_serie,
                area : datatra.ubicacion_anterior.area.nombre_area,
                sede : datatra.ubicacion_anterior.area.sede.nombre_sede,
                ubicacion : datatra.ubicacion_anterior.nombre_ubicacion,
                ubicacion_id:datatra.ubicacion_anterior.ubicacion_id,              
                encargado_id:datatra.encargado_anterior.encargado_id,              
                conservacion: datatra.conservacion_anterior,             
                en_uso: datatra.en_uso_anterior,                             
            }             
            this.$modal.show('traslado')        
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar este Traslado ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/movimientos/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                this.$store.dispatch('LOAD_BIENES_LIST')                    
                this.$store.dispatch('LOAD_MOVIMIENTOS_LIST')                    
                toastr.success('Registro Eliminado correctamente');
                dialog.close();
                });
                })
            .catch(() => {
                console.log('Delete aborted');
            });
        },                                

        onSelectAut (item_aut) {
            this.item_aut = item_aut
            this.dataBaja.autorizado_id = item_aut.value
        },
        resetAut () {
            this.item_aut = {}
            this.dataBaja.autorizado_id = ''   
        },          
  
        formatFecha : function(fec) {
            if(fec == null) {return null}
            var f = fec.split('-')
            var newf = f[2]+'-'+f[1]+'-'+f[0]
            return newf
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

