<template>
    <div>
        <section class="content-header">
            <h1>
                {{ NombreEmpresa.nombre_empresa}}
                <small>Lista de Traslados</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active">Traslados</li>
            </ol>
        </section> 
        <div class="clearfix"></div>   
        <section class="content">
            <div class="col-md-12 pl-0 pr-0">
                <!-- START DEFAULT DATATABLE -->
                <div class="panel panel-danger">
                    <div class="panel-heading bg-red-active"> 
                        <div class="row">
                            <button type="button" class="btn bg-yellow pull-right mr-10" @click="$modal.show('bien')"><i class="material-icons bootstro-prev-btn mr-5">swap_horizontal_circle</i> Registrar Traslado</button>
                        </div>                                                        
                    </div>
                    <div class="panel-body">
                        <vue-good-table
                        :columns="columns"
                        :rows="TrasladosByEmpresa"
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
                                    <button type="button" class="btn btn-danger btn-xs" title="ELIMINAR TRASLADO" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button>
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
        <modal name="traslado" width="70%" height="auto" :scrollable="true" :clickToClose="false">            
        <!-- form de registro del traslado -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Registro de Traslado</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('traslado')"><i class="fa fa-close"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionTraslado">
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
                                    <label for="" class="control-label">Empresa <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_empresas"
                                                class="input-sm"
                                                :selected-option="item_emp"
                                                placeholder="seleccione una Empresa"
                                                @select="onSelectEmp">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_emp.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Sede" @click.prevent="resetEmp" aria-hidden="true" v-if="item_emp.text"></span>
                                    </div>
                                </div>  
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Sede <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_sedes"
                                                class="input-sm"
                                                :selected-option="item_sed"
                                                placeholder="seleccione una Sede"
                                                @select="onSelectSed">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_sed.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Sede" @click.prevent="resetSed" aria-hidden="true" v-if="item_sed.text"></span>
                                    </div>
                                </div>                                                               
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Area <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="areasBy"
                                                class="input-sm"
                                                :selected-option="item_are"
                                                placeholder="seleccione una Area"
                                                @select="onSelectAre">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_are.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Area" @click.prevent="resetAre" aria-hidden="true" v-if="item_are.text"></span>
                                    </div>
                                </div>  
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Ubicación <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="ubicacionesBy"
                                                class="input-sm"
                                                :selected-option="item_ubi"
                                                placeholder="seleccione una Ubicación"
                                                @select="onSelectUbi">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_ubi.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Ubicacion" @click.prevent="resetUbi" aria-hidden="true" v-if="item_ubi.text"></span>
                                    </div>
                                </div> 
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Responsable del Bien <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_responsables"
                                                class="input-sm"
                                                :selected-option="item_res"
                                                placeholder="seleccione un Empleado"
                                                @select="onSelectRes">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_res.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Responsable" @click.prevent="resetRes" aria-hidden="true" v-if="item_res.text"></span>
                                    </div>
                                </div> 
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
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Estado conservación <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_estados"
                                                class="input-sm"
                                                :selected-option="item_est"
                                                placeholder="seleccione un estado"
                                                @select="onSelectEst">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_est.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Estado" @click.prevent="resetEst" aria-hidden="true" v-if="item_est.text"></span>
                                    </div>
                                </div>
                                <div class="form-group ml-5 mb-0 pb-10">
                                    <div class="col-md-5 pl-0">
                                        <label for="" class="control-label">Condición <span class="asterisk">*</span></label>
                                        <div class="row">
                                            <div class="col-sm-12 pt-5">
                                                <p class="mb-0">
                                                    NUEVO <input type="radio" name="radestado" id="estadoS" value="Si" v-model="dataTraslado.en_uso_actual" required />
                                                    USADO <input type="radio" name="radestado" id="estadoN" value="No" v-model="dataTraslado.en_uso_actual" />
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Tipo Traslado <span class="asterisk">*</span></label>
                                        <div class="row">
                                            <div class="col-sm-12 pt-5">
                                                <p class="mb-0">
                                                    TEMPORAL <input type="radio" name="radtipo" id="tipotem" value="Temporal" v-model="dataTraslado.tipo_traslado" required />
                                                    DEFINITIVO <input type="radio" name="radtipo" id="tipodef" value="Definitivo" v-model="dataTraslado.tipo_traslado" />
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                                                                                                                                                              
                            </div>                                                                              
                        </div>                                                                                                                                                                                                                                                                                                                                                              
                    </div>                  
                    <div class="col-md-12 pt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('traslado')"><i class="fa fa-reply-all"></i> Cancelar</button>
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
    name:'traslados',
    created() {
        this.$store.dispatch('LOAD_BIENES_LIST')          
        this.$store.dispatch('LOAD_MOVIMIENTOS_LIST')               
        this.$store.dispatch('LOAD_DATA_INIT_LIST') 
    },
    data() {
        return {
            edition: false,
            searchText: '', // If value is falsy, reset searchText & searchItem

            codemp: '',
            codsed: '',
            codare: '',
            codubi: '',

            item_emp: { value: '', text: ''},   
            item_sed: { value: '', text: ''},             
            item_are: { value: '', text: ''},  
            item_ubi: { value: '', text: ''},  
            item_res: { value: '', text: ''}, 
            item_aut: { value:'' , text:''},   
            item_est: { value:'' , text:''},                                

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
                label: 'Origen',
                field: 'ubicacion_anterior.nombre_ubicacion',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',                
                },
                {
                label: 'Destino',
                field: 'ubicacion_actual.nombre_ubicacion',
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
            dataTraslado : {
                bien_id:'',
                tipomovimiento:'Traslado',
                ubicacion_id_anterior:'',
                ubicacion_id_actual:'',                
                encargado_id_anterior:'',
                encargado_id_actual:'',
                fecha_movimiento: moment().format('DD/MM/YYYY'),                
                conservacion_anterior:'',
                conservacion_actual:'',                
                en_uso_anterior: '',
                en_uso_actual: '',                
                tipo_traslado:''               
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
        ...mapState(['empresas','combo_empresas','combo_sedes','combo_areas','combo_ubicaciones','combo_responsables']),
        ...mapGetters(['getTrasladosByEmpresaId','getBienesByEmpresaId']),
        areasBy: function(){
            return this.combo_areas.filter((are) => are.empresa_id == this.codemp).filter((are) => are.sede_id == this.codsed)
        }, 
        ubicacionesBy: function(){
            return this.combo_ubicaciones.filter((ubi) => ubi.area_id == this.codare)
        },               
        TrasladosByEmpresa: function(){
            return this.getTrasladosByEmpresaId(this.$route.params.empresa)
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
            var datatra = []
            datatra = _.clone(params.row)

            this.dataShow = {
                id : datatra.id,
                codigo_barra: datatra.codigo_barra,
                descripcion : datatra.descripcion,
                marca : datatra.marca,
                modelo : datatra.modelo,
                numero_serie : datatra.numero_serie,
                area : datatra.ubicacion.area.nombre_area,
                sede : datatra.ubicacion.area.sede.nombre_sede,
                ubicacion : datatra.ubicacion.nombre_ubicacion,
                ubicacion_id:datatra.ubicacion_id,              
                encargado_id:datatra.encargado_id,              
                conservacion: datatra.conservacion,             
                en_uso: datatra.en_uso,                             
            }
            this.$modal.hide('bien')  
            this.LoadForm()            
        },        
        LoadForm: function(){   
            this.edition = false 
            this.codemp = ''
            this.codsed = '',
            this.codare = '',
            this.codubi = '',

            this.item_emp = { value: '', text: ''},   
            this.item_sed = { value: '', text: ''},             
            this.item_are = { value: '', text: ''},  
            this.item_ubi = { value: '', text: ''},  
            this.item_res = { value: '', text: ''}, 
            this.item_aut = { value:'' , text:''},                 

            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataTraslado = {
                bien_id:this.dataShow.id,
                tipomovimiento:'Traslado',
                ubicacion_id_anterior:this.dataShow.ubicacion_id,
                ubicacion_id_actual:'',                
                encargado_id_anterior:this.dataShow.encargado_id,
                encargado_id_actual:'',
                fecha_movimiento: moment().format('DD/MM/YYYY'),                
                conservacion_anterior:this.dataShow.conservacion,
                conservacion_actual:'',                
                en_uso_anterior: this.dataShow.en_uso,
                en_uso_actual: 'Si',                
                tipo_traslado:'Temporal'               
            } 
            this.$store.dispatch('LOAD_DATA_INIT_LIST')                    
            this.$modal.show('traslado')
        },
        ActionTraslado: function(){
            if(typeof(this.dataTraslado.id) === "undefined"){
                this.createTraslado()
            }else{
                this.updateTraslado()
            }
        },
        createTraslado: function(){
            var url = '/api/movimientos';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataTraslado).then(response => {
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
                this.$modal.hide('traslado');
                toastr.success('Nuevo Registro creado con exito');
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);

            });
        },
        updateTraslado: function(){
            var url = '/api/movimientos/'+this.dataTraslado.id;
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
                this.$modal.hide('traslado');
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
                tipomovimiento:'Traslado',
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
        onSelectUbi (item_ubi) {
            this.item_ubi = item_ubi
            this.dataTraslado.ubicacion_id_actual = item_ubi.value
        },
        resetUbi () {
            this.item_ubi = {}
            this.dataTraslado.ubicacion_id_actual = ''   
        }, 
        onSelectAre (item_are) {
            this.item_are = item_are
            this.codare = item_are.value
            this.resetUbi()
        },
        resetAre () {
            this.item_are = {}
            this.codare = '0'
            this.resetUbi()  
        }, 
        onSelectSed (item_sed) {
            this.item_sed = item_sed
            this.codsed = item_sed.value
            this.resetAre()
        },
        resetSed () {
            this.item_sed = {}
            this.codsed = '0'
            this.resetAre() 
        }, 
        onSelectEmp (item_emp) {
            this.item_emp = item_emp
            this.codemp = item_emp.value
            this.resetSed()
        },
        resetEmp () {
            this.item_emp = {}
            this.codemp = '0'
            this.resetSed() 
        },                     
        onSelectRes (item_res) {
            this.item_res = item_res
            this.dataTraslado.encargado_id_actual = item_res.value
        },
        resetRes () {
            this.item_res = {}
            this.dataTraslado.encargado_id_actual = ''   
        },   
        onSelectAut (item_aut) {
            this.item_aut = item_aut
            this.dataTraslado.autorizado_id = item_aut.value
        },
        resetAut () {
            this.item_aut = {}
            this.dataTraslado.autorizado_id = ''   
        },          
  
        onSelectEst (item_est) {
            this.item_est = item_est
            this.dataTraslado.conservacion_actual = item_est.text
        },
        resetEst () {
            this.item_est = {}
            this.dataTraslado.conservacion_actual = ''   
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

