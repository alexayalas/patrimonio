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
            Ubicación Fisica
            <small>Mantenimiento de ubicaciones</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">ubicaciones</li>
        </ol>
        </section>    
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- START DEFAULT DATATABLE -->
                    <div class="panel panel-danger">
                        <div class="panel-heading bg-red-active"> 
                            <!-- <h3 class="panel-title">VillaSalud</h3>     -->                           
                            <div class="row">
                                <button type="button" class="btn bg-yellow pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">message</i> Nueva Ubicación</button>
                            </div>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de Ubicaciones"
                            :columns="columns"
                            :rows="ubicaciones"
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
                                        <button title="Eliminar Ubicacion" class="btn btn-danger btn-xs" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button>
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
        <modal name="ubicacion" :width="'50%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de empresas -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Registro de Ubicación</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('ubicacion')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionUbicacion">
                    <div class="form-body">
                        <div class="col-md-12 pt-20">
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Empresa </label>
                                <div class="col-md-7 col-sm-7 col-xs-7">
                                    <basic-select :options="combo_empresas"
                                    :selected-option="item_emp"
                                    placeholder="seleccione una opción"
                                    @select="onSelectEmp">
                                    </basic-select>
                                </div>
                                <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_emp.text"></span>
                                <div class="col-md-1 col-sm-1" v-if="item_emp.text">
                                    <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetEmp"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                                </div>
                            </div>       
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Sede </label>
                                <div class="col-md-7 col-sm-7 col-xs-7">
                                    <basic-select :options="combo_sedes"
                                    :selected-option="item_sed"
                                    placeholder="seleccione una opción"
                                    @select="onSelectSed">
                                    </basic-select>
                                </div>
                                <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_sed.text"></span>
                                <div class="col-md-1 col-sm-1" v-if="item_sed.text">
                                    <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetAre"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-4">Area </label>
                                <div class="col-md-7 col-sm-7 col-xs-7">
                                    <basic-select :options="areasBy"
                                    :selected-option="item_are"
                                    placeholder="seleccione una opción"
                                    @select="onSelectAre">
                                    </basic-select>
                                </div>
                                <span class="glyphicon glyphicon-folder-open mt-5" style="font-size:20px" aria-hidden="true" v-if="!item_are.text"></span>
                                <div class="col-md-1 col-sm-1" v-if="item_are.text">
                                    <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetAre"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                                </div>
                            </div>                                                                                
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombre <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="nombre_ubicacion" v-model="dataUbicacion.nombre_ubicacion" required>
                                </div>                         
                            </div><!-- /.form-group -->                                                              
                                                                                                                                                                                                        
                        </div>                   
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('ubicacion')"><i class="fa fa-reply-all"></i> Cancelar</button>
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
    name:'ubicaciones',
    mounted() {
        this.$store.dispatch('LOAD_UBICACIONES_LIST').then(() => {
            this.isLoading = false
        })  
        this.$store.dispatch('LOAD_COMBO_EMPRESAS_LIST') 
        this.$store.dispatch('LOAD_COMBO_AREAS_LIST')                         
    },        
    data() {
        return {
            isLoading: true,
            fullPage: true,
                        
            searchText: '', // If value is falsy, reset searchText & searchItem
            item_emp: { value: '', text: ''},  
            item_sed: { value: '', text: ''},             
            item_are: { value: '', text: ''},   
                
            codemp:'',
            codsed:'',
            codare:'',
          
            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Grabar Datos',              

            columns: [
                {
                label: 'Empresa',
                field: 'area.empresa.nombre_empresa',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'25%',
                },
                {
                label: 'Sede',
                field: 'area.sede.nombre_sede',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'25%',
                },                  
                {
                label: 'Area',
                field: 'area.nombre_area',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',
                },                               
                {
                label: 'Ubicación',
                field: 'nombre_ubicacion',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',
                },                                                           
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'10%',  
                }                               
            ],
            dataUbicacion : {
                area_id:'',
                nombre_ubicacion:''   
            },                
            errors:[]
        }
    },
    computed: {
        ...mapState(['ubicaciones','combo_empresas','combo_sedes','combo_areas']),
        ...mapGetters(['getareas']),
/*         empresasBy: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.codprov == '0').filter((ubigeo) => ubigeo.coddist == '0');
        }, */
        areasBy: function(){
            return this.getareas.filter((are) => are.empresa_id == this.codemp).filter((are) => are.sede_id == this.codsed)
        }       
    },
    components: {
      BasicSelect
    },            
    methods: {
        LoadForm: function(){   
            this.item_emp = {}
            this.item_sed = {}
            this.item_are = {}
            this.codemp = ''  
            this.codsed = ''
            this.codare = ''        
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataUbicacion = {
                area_id:'',
                nombre_ubicacion:''   
            }  
            this.$store.dispatch('LOAD_COMBO_EMPRESAS_LIST') 
            this.$store.dispatch('LOAD_COMBO_AREAS_LIST')                                   
            this.$modal.show('ubicacion')
        },
        ActionUbicacion: function(){
            if(typeof(this.dataUbicacion.id) === "undefined"){
                this.createUbicacion()
            }else{
                this.updateUbicacion()
            }
        },
        createUbicacion: function(){
            var url = '/api/ubicaciones';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataUbicacion).then(response => {
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
                this.$store.dispatch('LOAD_UBICACIONES_LIST')    
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'
                this.labelButton = 'Grabar Datos'              
                this.$modal.hide('ubicacion');
                toastr.success('Nueva Ubicación creada con exito');
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
            });
        },
        updateUbicacion: function(){
            var url = '/api/ubicaciones/'+this.dataUbicacion.id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'          
            axios.put(url, this.dataUbicacion).then(response => {
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
                this.$store.dispatch('LOAD_UBICACIONES_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('ubicacion');
                toastr.success('la Ubicación fue actualizada con exito');          
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'                 
            });
        },
        processEdit(params){
            var dataubic = []
            dataubic = _.clone(params.row)
            this.item_emp = this.combo_empresas.find(emp => emp.value == dataubic.area.empresa_id)
            this.item_sed = this.combo_sedes.find(sed => sed.value == dataubic.area.sede_id)
            this.codemp = dataubic.area.empresa_id
            this.codsed = dataubic.area.sede_id
            this.item_are = this.areasBy.find(are => are.value == dataubic.area_id)
            this.dataUbicacion = {
                id:dataubic.id,
                nombre_ubicacion:dataubic.nombre_ubicacion,
                area_id:dataubic.area_id         
            }            
            this.$modal.show('ubicacion')
        
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar esta Ubicación ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/ubicaciones/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                this.$store.dispatch('LOAD_UBICACIONES_LIST')                    
                toastr.success('Ubicación Eliminada correctamente');
                dialog.close();
                });
                })
            .catch(() => {
                console.log('Delete aborted');
            });
        },               
        onSelectAre (item_are) {
            this.item_are = item_are
            this.dataUbicacion.area_id = item_are.value
        },
        resetAre () {
            this.item_are = {}
            this.dataUbicacion.area_id = ''   
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