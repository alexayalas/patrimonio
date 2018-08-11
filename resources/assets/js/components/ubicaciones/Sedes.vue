<template>
    <div>
        <section class="content-header">
        <h1>
            Sedes
            <small>Mantenimiento de Sedes</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Sedes</li>
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
                                <button type="button" class="btn bg-yellow pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">business</i> Nueva Sede</button>
                            </div>                                                        
                        </div>
                        <div class="panel-body">
                            <vue-good-table
                            title="Listado de Sedes"
                            :columns="columns"
                            :rows="sedes"
                            :paginate="true"
                            :lineNumbers="true"
                            :rowsPerPageText="textpage"
                            :nextText="textnext"
                            :prevText="textprev"
                            :ofText="textof"
                            styleClass="table condensed table-bordered table-striped">
                                <template slot="table-row" slot-scope="props">
                                    <td class="enlace" @click.prevent="processEdit(props.row)">{{ props.row.nombre_sede }}</td>
                                    <td class="enlace" @click.prevent="processEdit(props.row)">{{ props.row.direccion }}</td>
                                    <td class="center"><button title="Eliminar Sede" class="btn btn-danger btn-xs" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button></td>
                                </template>                              
                            </vue-good-table>
                        </div>
                    </div>
                    <!-- END DEFAULT DATATABLE -->                       
                    
                </div> 
            </div>
        </section> 
        <!-- PAGE CONTENT MODAL -->  
        <modal name="sede" :width="'50%'" :height="'auto'" :scrollable="true" :clickToClose="false">
            <!-- form de registro de sedes -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Registro de Sede</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('sede')"><i class="glyphicon glyphicon-remove"></i></div>                
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionSede">
                    <div class="form-body">
                        <div class="col-md-12 pt-20">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nombre <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="nombre_sede" v-model="dataSede.nombre_sede" required>
                                </div>                         
                            </div><!-- /.form-group -->  
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Dirección <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control input-sm mayusculas" name="direccion" v-model="dataSede.direccion" required>
                                </div>                         
                            </div><!-- /.form-group -->                                                                                                                                                                                                                                                                                                
                        </div>                   
                    </div><!-- /.form-body -->
                    <div class="col-md-12 pt-20 mt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('sede')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active" :disabled="ShowIcon"><i :class="[IconClass]"></i> {{ labelButton }}</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
            <!-- /. form de registro de sedes -->
        </modal>               
    </div>
 
</template>
<script>
import { mapState, mapGetters } from 'vuex'
export default {
    name:'sedes',
    mounted() {
        this.$store.dispatch('LOAD_SEDES_LIST')            
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
                label: 'Nombre de Sede',
                field: 'nombre_sede',
                filterable: true,
                width:'50%',
                },
                { 
                label: 'Direccion',
                field: 'direccion',
                filterable: true,
                width:'40%',
                },                                                                                                                            
                {
                label: 'Acción',
                html: true  ,
                width:'10%',  
                }                               
            ],  
            dataSede : {
                nombre_sede:'',
                direccion:''  
            },                       
            errors:[]
        }
    },
    computed: {
        ...mapState(['sedes']),
    },     
    methods: {
        onClickFn: function(row, index){
            console.log(row)
        },
        LoadForm: function(){  
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataSede = {
                nombre_sede:'',
                direccion:''       
            }           
            this.$modal.show('sede')
        }, 
        ActionSede: function(){
            if(typeof(this.dataSede.id) === "undefined"){
                this.createSede()
            }else{
                this.updateSede()
            }
        },
        createSede: function(){
            var url = '/api/sedes';
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'
            this.labelButton = 'Procesando'        
            axios.post(url, this.dataSede).then(response => {
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
            this.$store.dispatch('LOAD_SEDES_LIST')    
            this.errors = [];
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'
            this.labelButton = 'Grabar Datos'              
            this.$modal.hide('sede');
            toastr.success('Nueva Sede creada con exito');
            }).catch(error => {
            this.errors = error.response.data.status;
            toastr.error("Hubo un error en el proceso: "+this.errors);
            console.log(error.response.status);
            });
        },
        updateSede: function(){
            var url = '/api/sedes/'+this.dataSede.id;
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'          
            axios.put(url, this.dataSede).then(response => {
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
                this.$store.dispatch('LOAD_SEDES_LIST')                  
                this.errors = [];
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'             
                this.$modal.hide('sede');
                toastr.success('la Sede fue actualizada con exito');          
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ShowIcon = false
                this.IconClass = 'fa fa-cloud-upload'          
                this.labelButton = 'Grabar Datos'                 
                console.log(error.response.status);
            });
        },
        processEdit(sed){
            var datased = []
            datased = _.clone(sed)
            this.dataSede = {
                id:datased.id,
                nombre_sede:datased.nombre_sede,
                direccion:datased.direccion          
            }            
            this.$modal.show('sede')
        
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar esta Sede ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/sedes/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                this.$store.dispatch('LOAD_SEDES_LIST')                    
                toastr.success('Sede Eliminada correctamente');
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