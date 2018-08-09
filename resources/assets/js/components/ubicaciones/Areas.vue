<template>
    <div>
        <section class="content-header">
        <h1>
            Areas
            <small>Mantenimiento de Areas</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Areas</li>
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
                                <button type="button" class="btn btn-info pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">account_circle</i> Nueva Area</button>
                            </div>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de Areas"
                            :columns="columns"
                            :rows="areas"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="processEdit(props.row)">{{ props.row.empresa.nombre_empresa }}</td>
                                    <td class="enlace" @click.prevent="processEdit(props.row)">{{ props.row.sede.nombre_sede }}</td>
                                    <td class="enlace" @click.prevent="processEdit(props.row)">{{ props.row.nombre_area }}</td>
                                    <td class="center"><button title="Eliminar Area" class="btn btn-danger btn-xs" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button></td>
                                </template>                              
                            </vue-good-table>
                        </div>
                    </div>
                    <!-- END DEFAULT DATATABLE -->                                           
                </div> 
            </div>

        </section> 
        <!-- PAGE CONTENT MODAL -->  
        <modal name="area" :width="'50%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de empresas -->
            <div>
                <div class="row title-form">
                    <h3 class="pull-left h3-title">Registro de Area</h3>
                    <div class="pull-right close-form" @click="$modal.hide('area')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionArea">
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
                                    <button type="button" title="Borrar Opción" class="btn btn-danger btn-sm pull-right" @click.prevent="resetSed"><i class="glyphicon glyphicon-remove mt-5"></i> </button>
                                </div>
                            </div>                                                          
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombre <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="nombre_area" v-model="dataArea.nombre_area" required>
                                </div>                         
                            </div><!-- /.form-group -->                                                              
                                                                                                                                                                                                        
                        </div>                   
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('area')"><i class="fa fa-reply-all"></i> Cancelar</button>
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
    name:'areas',
    mounted() {
        this.$store.dispatch('LOAD_AREAS_LIST') 
        //this.$store.dispatch('LOAD_EMPRESAS_LIST') 
        //this.$store.dispatch('LOAD_SEDES_LIST')                             
    },        
    data() {
        return {
            searchText: '', // If value is falsy, reset searchText & searchItem
            item_emp: { value: '', text: ''}, 
            item_sed: { value: '', text: ''},                         

            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Grabar Datos',              

            textpage: 'Registros por pagina',
            textnext:'Sig',
            textprev:'Ant',
            textof:'de',
            columns: [
                {
                label: 'Empresa',
                field: 'empresa',
                filterable: true,
                width:'30%',
                },
                {
                label: 'Sede',
                field: 'nombre_sede',
                filterable: true,
                width:'30%',
                },                  
                {
                label: 'Nombre',
                field: 'nombre_area',
                filterable: true,
                width:'30%',
                },                                                           
                {
                label: 'Acción',
                html: true  ,
                width:'10%',  
                }                               
            ],
            dataArea : {
                empresa_id:'',
                sede_id:'',
                nombre_area:''   
            },                
            errors:[]
        }
    },
    computed: {
        ...mapState(['areas','combo_empresas','combo_sedes']),
    },
    components: {
      BasicSelect
    },            
    methods: {
        onClickFn: function(row, index){
            console.log(row)
        },
        LoadForm: function(){  
            this.item_emp = {}              
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataArea = {
                empresa_id:'',
                sede_id:'',
                nombre_area:''   
            }  
            this.$store.dispatch('LOAD_COMBO_EMPRESAS_LIST') 
            //this.$store.dispatch('LOAD_COMBO_SEDES_LIST')                                    
            this.$modal.show('area')
        },
        ActionArea: function(){
            if(typeof(this.dataArea.id) === "undefined"){
                this.createArea()
            }else{
                this.updateArea()
            }
        },
        createArea: function(){
            var url = '/api/areas';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataArea).then(response => {
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
            this.$store.dispatch('LOAD_AREAS_LIST')    
            this.errors = [];
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'
            this.labelButton = 'Grabar Datos'              
            this.$modal.hide('area');
            toastr.success('Nueva Area creada con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },
        updateArea: function(){
            var url = '/api/areas/'+this.dataArea.id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'          
            axios.put(url, this.dataArea).then(response => {
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
                this.$store.dispatch('LOAD_AREAS_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('area');
                toastr.success('el Area fue actualizada con exito');          
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'                 
                console.log(error.response.status);
            });
        },
        processEdit(are){
            var dataarea = []
            dataarea = _.clone(are)
            //dataempr.access = dataempr.access == 1 ? true : false
            this.item_emp = this.combo_empresas.find((cemp) => cemp.value == dataarea.empresa_id)
            this.item_sed = this.combo_sedes.find((csed) => csed.value == dataarea.sede_id)            

            this.dataArea = {
                id:dataarea.id,
                nombre_area:dataarea.nombre_area,
                empresa_id:dataarea.empresa_id,
                sede_id:dataarea.sede_id         
            }            
            this.$modal.show('area')
        
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar esta Area ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/areas/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                //this.getEmployee(this.pagination.current_page,this.employeeSearch); 
                this.$store.dispatch('LOAD_AREAS_LIST')                    
                toastr.success('Area Eliminada correctamente');
                dialog.close();
                });
                })
            .catch(() => {
                console.log('Delete aborted');
            });
        },               
        onSelectEmp (item_emp) {
            this.item_emp = item_emp
            this.dataArea.empresa_id = item_emp.value
        },
        resetEmp () {
            this.item_emp = {}
            this.dataArea.empresa_id = ''   
        },   
        onSelectSed (item_sed) {
            this.item_sed = item_sed
            this.dataArea.sede_id = item_sed.value
        },
        resetSed () {
            this.item_sed = {}
            this.dataArea.sede_id = ''   
        },                                       
    },
       
  
}
</script>
<style scoped>
    .title-form {
        background-color: #347c7c;
        color: white;
        margin:0;
        padding:0
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
        border-top: 1px solid #CCC7B8;
    }

    input.mayusculas{
        text-transform:uppercase;
    } 

    input.minusculas{
        text-transform:lowercase;
    }    

    .center {
        text-align: center;
    }   
      
</style>