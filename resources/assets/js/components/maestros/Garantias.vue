<template>
    <div>
        <section class="content-header">
        <h1>
            Garantias
            <small>Mantenimiento de Garantias</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Garantia</li>
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
                                <button type="button" class="btn btn-info pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">store_mall_directory</i> Nueva Garantia</button>
                            </div>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de Garantias"
                            :columns="columns"
                            :rows="garantias"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="processEdit(props.row)">{{ props.row.nombre_garantia }}</td>
                                    <td class="center"><button title="Eliminar garantia" class="btn btn-danger btn-xs" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button></td>
                                </template>                              
                            </vue-good-table>
                        </div>
                    </div>
                    <!-- END DEFAULT DATATABLE -->                       
                    
                </div> 
            </div>
        </section> 
        <!-- PAGE CONTENT MODAL -->  
        <modal name="garantia" :width="'50%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de garantias -->
            <div>
                <div class="row title-form">
                    <h3 class="pull-left h3-title">Registro de Garantias</h3>
                    <div class="pull-right close-form" @click="$modal.hide('garantia')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionGarantia">
                    <div class="form-body">
                        <div class="col-md-12 pt-20">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombre <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="nombre_garantia" v-model="dataGarantia.nombre_garantia" required>
                                </div>                         
                            </div><!-- /.form-group -->                                                                                                                                                                                                                                                                 
                        </div>                   
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('garantia')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active" :disabled="ShowIcon"><i :class="[IconClass]"></i> {{ labelButton }}</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
            <!-- /. form de registro de garantias -->
        </modal>               
    </div>
 
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name:'garantias',
    mounted() {
        this.$store.dispatch('LOAD_GARANTIAS_LIST')            
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
                label: 'Nombre de Garantia',
                field: 'nombre_garantia',
                filterable: true,
                width:'90%',
                },                                                                                                           
                {
                label: 'Acción',
                html: true  ,
                width:'10%',  
                }                               
            ],  
            dataGarantia : {
                nombre_garantia:''
            },                       
            errors:[]
        }
    },
    computed: {
        ...mapState(['garantias']),
    },     
    methods: {
        onClickFn: function(row, index){
            console.log(row)
        },
        LoadForm: function(){  
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataGarantia = {
                nombre_garantia:''   
            }             
            this.$modal.show('garantia')
        }, 
        ActionGarantia: function(){
            if(typeof(this.dataGarantia.id) === "undefined"){
                this.createGarantia()
            }else{
                this.updateGarantia()
            }
        },
        createGarantia: function(){
            var url = '/api/garantias';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataGarantia).then(response => {
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
            this.$store.dispatch('LOAD_GARANTIAS_LIST')    
            this.errors = [];
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'
            this.labelButton = 'Grabar Datos'              
            this.$modal.hide('garantia');
            toastr.success('Nueva Garantia creada con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },
        updateGarantia: function(){
            var url = '/api/garantias/'+this.dataGarantia.id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'          
            axios.put(url, this.dataGarantia).then(response => {
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
                this.$store.dispatch('LOAD_GARANTIAS_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('garantia');
                toastr.success('la Garantia fue actualizada con exito');          
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'                 
                console.log(error.response.status);
            });
        },
        processEdit(gar){
            var datagar = []
            datagar = _.clone(gar)
            //dataempr.access = dataempr.access == 1 ? true : false
            this.dataGarantia = {
                id:datagar.id,
                nombre_garantia:datagar.nombre_garantia           
            }            
            this.$modal.show('garantia')
        
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar esta Garantia ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/garantias/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                //this.getEmployee(this.pagination.current_page,this.employeeSearch); 
                this.$store.dispatch('LOAD_GARANTIAS_LIST')                    
                toastr.success('Garantia Eliminada correctamente');
                dialog.close();
                });
                })
            .catch(() => {
                console.log('Delete aborted');
            });
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