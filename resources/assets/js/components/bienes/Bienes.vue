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
                {{ NombreEmpresa.nombre_empresa}}
                <small>Lista de bienes</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
                <li class="active">Bienes</li>
            </ol>
        </section> 
        <div class="clearfix"></div>   
        <section class="content">
            <div class="col-md-12 pl-0 pr-0">
                <!-- START DEFAULT DATATABLE -->
                <div class="panel panel-danger">
                    <div class="panel-heading bg-red-active"> 
                        <div class="row">
                            <button type="button" class="btn bg-yellow pull-right mr-10" @click.prevent="LoadForm"><i class="material-icons bootstro-prev-btn mr-5">create_new_folder</i> Registrar Bien</button>
                        </div>                                                        
                    </div>
                    <div class="panel-body">
                        <vue-good-table
                        :columns="columns"
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
                        @on-row-dblclick="processEdit"
                        :rowStyleClass="'enlace'"
                        :lineNumbers="true"
                        styleClass="vgt-table condensed bordered striped">
                            <template slot="table-row" slot-scope="props">
                                <span v-if="props.column.field == 'btn'" class="center">
                                    <button type="button" class="btn btn-danger btn-xs" title="ELIMINAR BIEN" @click.prevent="processDelete(props.row.id)"><i class="material-icons md-18">delete_forever</i></button>
                                    <button type="button" class="btn btn-success btn-xs" title="IMPRIMIR CODIGO DE BARRAS" @click.prevent="processImprimir(props.row)"><i class="material-icons md-18">print</i></button>
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
        <modal name="bien" width="90%" height="auto" :scrollable="true" :clickToClose="false">            
        <!-- form de registro de bienes -->
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Registro de Bienes <span class="label label-success reg-mas" v-if="dataConfig.Ingreso">Registro Masivo Activado</span></h3>
                    <div class="pull-right close-form pr-20" title="Cerrar Ventana" @click="$modal.hide('bien')"><i class="fa fa-close"></i></div>                
                    <div class="pull-right close-form pr-20" v-if="edition == false" title="Configuracion Avanzada" @click="$modal.show('configuracion')"><i class="fa fa-cog"></i></div>               
                </div>
                <form data-sample-validation-1 class="form-horizontal form-bordered" role="form" method="POST" v-on:submit.prevent="ActionBien">
                    <div class="col-md-4 pt-20 pr-0">
                        <div class="box box-danger">
                            <div class="box-body modal-main modal-item pt-0">
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
                                    <label for="" class="control-label">Responsable del Area <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_responsables"
                                                class="input-sm"
                                                :selected-option="item_res_are"
                                                placeholder="seleccione un Responsable"
                                                @select="onSelectResAre">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_res_are.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Responsable" @click.prevent="resetResAre" aria-hidden="true" v-if="item_res_are.text"></span>
                                    </div>
                                </div>                                
                            </div>                                                      
                        </div> 
                        <div class="box box-danger">    
                            <div class="box-body modal-main modal-item pt-0">
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Clase <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_clases"
                                                class="input-sm"
                                                :selected-option="item_cla"
                                                placeholder="seleccione una Clase"
                                                @select="onSelectCla">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_cla.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Clase" @click.prevent="resetCla" aria-hidden="true" v-if="item_cla.text"></span>
                                    </div>
                                </div>                                                                     
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Grupo</label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <!-- <input type="text" class="form-control input-sm mayusculas" name="grupo" v-model="dataBien.grupo"/> -->
                                            <label for="" class="control-label col-md-12 label-grupo pl-5">{{ NombreGrupo}} </label>   
                                        </div>
                                    </div>
                                </div><!-- /.form-group -->
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Responsable del Bien <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_responsables"
                                                class="input-sm"
                                                :selected-option="item_res_bie"
                                                placeholder="seleccione un Responsable"
                                                @select="onSelectResBie">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_res_bie.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Responsable" @click.prevent="resetResBie" aria-hidden="true" v-if="item_res_bie.text"></span>
                                    </div>
                                </div>                                 
                            </div>                                                   
                        </div>
                    </div>
                    <div class="col-md-4 pt-20 pr-0">
                        <div class="box box-danger">   
                            <div class="box-body modal-main modal-item pt-0">
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Descripcion <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <textarea rows="3" cols="20" class="form-control input-sm mayusculas" name="descripcion" v-model="dataBien.descripcion" required></textarea>
                                        </div>                                    
                                    </div>
                                </div><!-- /.form-group -->
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Marca <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input type="text" class="form-control input-sm mayusculas" name="marca" v-model="dataBien.marca" required>
                                        </div>
                                    </div>
                                </div><!-- /.form-group -->     
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Modelo <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input type="text" class="form-control input-sm mayusculas" name="modelo" v-model="dataBien.modelo" required>
                                        </div>
                                    </div>
                                </div><!-- /.form-group -->
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Numero de Serie <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input type="text" class="form-control input-sm mayusculas" name="numero_serie" v-model="dataBien.numero_serie" required>
                                        </div>
                                    </div>
                                </div><!-- /.form-group -->  
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Medidas </label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <input type="text" class="form-control input-sm mayusculas" name="medidas" v-model="dataBien.medidas">
                                        </div>
                                    </div>
                                </div><!-- /.form-group -->  
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Caracteristicas </label>
                                    <div class="row">
                                        <div class="col-sm-11">
                                            <textarea rows="3" cols="20" class="form-control input-sm mayusculas" name="caracteristicas" v-model="dataBien.caracteristicas"></textarea>
                                        </div>
                                    </div>
                                </div><!-- /.form-group -->  
                                <div class="form-group ml-20 pl-20 mb-0 pb-0" v-if="dataBien.foto == null || !edition">
                                    <label class="col-sm-12">Foto </label>
                                    <div class="form-group mb-0">
                                        <file-upload @cargaImagen="getImagen" @removeImage="getClear"></file-upload>
                                    </div><!-- /.form-group -->
                                </div>  
                                <div class="form-group ml-20 pl-20 mb-0 pb-0" v-if="dataBien.foto != null && edition">
                                    <label class="col-sm-12">Foto </label>
                                    <img :src="'/images/'+ dataBien.foto" height="128" width="128" alt="">
                                    <div class="row ml-20 mt-10">
                                        <button type="button" class="btn btn-danger" @click="eliminaFoto">Borrar Foto</button>
                                    </div>
                                </div>                                                                                           
                            </div>                                                                              
                        </div>                                                                                                                                                                                                                                                                                                                                                              
                    </div>                  
                    <div class="col-md-4 pt-20">
                        <div class="box box-danger"> 
                            <div class="box-body modal-main modal-item pt-0 pb-30">
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Tipo Ingreso <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_tipoingresos"
                                                class="input-sm"
                                                :selected-option="item_tip_ing"
                                                placeholder="seleccione un Tipo"
                                                @select="onSelectTipIng">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_tip_ing.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Tipo de Ingreso" @click.prevent="resetTipIng" aria-hidden="true" v-if="item_tip_ing.text"></span>
                                    </div>
                                </div>  
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Documento de Compra</label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_documentos"
                                                class="input-sm"
                                                :selected-option="item_tip_doc"
                                                placeholder="seleccione un Tipo"
                                                @select="onSelectTipDoc">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_tip_doc.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Tipo de Documento" @click.prevent="resetTipDoc" aria-hidden="true" v-if="item_tip_doc.text"></span>
                                    </div>
                                </div>                                                                                                                                              
                                <div class="form-group ml-5 mb-0">
                                    <div class="col-md-5 pl-0">
                                        <label for="" class="control-label">Serie Doc. </label>
                                        <div class="row">
                                            <div class="col-sm-11 pr-0">
                                                <input type="text" class="form-control input-sm" name="serie_documento" v-model="dataBien.serie_documento"/>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-7 pl-0">
                                        <label for="" class="control-label">Numero Doc. </label>
                                        <div class="row">
                                            <div class="col-sm-11 pr-0">
                                                <input type="text" class="form-control input-sm" name="numero_documento" v-model="dataBien.numero_documento"/>
                                            </div> 
                                        </div>
                                    </div>                                    
                           
                                </div><!-- /.form-group -->    
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Proveedor </label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_proveedores"
                                                class="input-sm"
                                                :selected-option="item_pro"
                                                placeholder="seleccione un Proveedor"
                                                @select="onSelectPro">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_pro.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Proveedor" @click.prevent="resetPro" aria-hidden="true" v-if="item_pro.text"></span>
                                    </div>
                                </div> 
                                <div class="form-group ml-5 mb-0">
                                    <div class="col-md-8 pl-0">
                                        <label for="" class="control-label">Garantia </label>
                                        <div class="row">
                                            <div class="col-md-10 col-sm-10 col-xs-10">
                                                <basic-select :options="combo_garantias"
                                                    class="input-sm"
                                                    :selected-option="item_gar"
                                                    placeholder="seleccione"
                                                    @select="onSelectGar">
                                                </basic-select>
                                            </div>
                                            <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_gar.text"></span>
                                            <span class="fa fa-trash mt-10 hand-up" title="Borrar Garantia" @click.prevent="resetGar" aria-hidden="true" v-if="item_gar.text"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="" class="control-label">Dias </label>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control input-sm" name="dias_garantia" v-model="dataBien.dias_garantia"/>
                                            </div> 
                                        </div>
                                    </div>                                    

                                </div>                                
                                <div class="form-group ml-5 mb-0">
                                    <div class="col-md-8 pl-0">
                                        <label for="" class="control-label">Fec.Compra </label>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                            <masked-input v-model="dataBien.fecha_compra" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="" class="control-label">Dias Mantto. <span class="asterisk">*</span></label>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control input-sm mayusculas" name="caracteristicas" v-model="dataBien.dias_mantenimiento" required>
                                            </div>
                                        </div>
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
                                <div class="form-group ml-5 mb-0">
                                    <label for="" class="control-label">Cuenta <span class="asterisk">*</span></label>
                                    <div class="row">
                                        <div class="col-md-10 col-sm-10 col-xs-10">
                                            <basic-select :options="combo_cuentas"
                                                class="input-sm"
                                                :selected-option="item_cue"
                                                placeholder="seleccione una Cuenta"
                                                @select="onSelectCue">
                                            </basic-select>
                                        </div>
                                        <span class="fa fa-search mt-10" aria-hidden="true" v-if="!item_cue.text"></span>
                                        <span class="fa fa-trash mt-10 hand-up" title="Borrar Cuenta" @click.prevent="resetCue" aria-hidden="true" v-if="item_cue.text"></span>
                                    </div>
                                </div>                                                                                                                                              
                                <div class="form-group ml-5 mb-0">
                                    <div class="col-md-6 pl-0">
                                        <label for="" class="control-label">Costo </label>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control input-sm" name="costo" v-model="dataBien.costo"/>
                                            </div>  
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <div class="checkbox mt-20">
                                                <label>
                                                    <input type="checkbox" v-model="dataBien.depresiable" > Depresiable
                                                </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                            
                                </div><!-- /.form-group -->  
                                <div class="form-group ml-5 mb-0 pb-10">
                                    <div class="col-md-5 pl-0">
                                        <label for="" class="control-label">Condición <span class="asterisk">*</span></label>
                                        <div class="row">
                                            <div class="col-sm-12 pt-5">
                                                <p class="mb-0">
                                                    NUEVO <input type="radio" name="radestado" id="estadoS" value="Si" v-model="dataBien.en_uso" required />
                                                    USADO <input type="radio" name="radestado" id="estadoN" value="No" v-model="dataBien.en_uso" />
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Fec.Registro </label>
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <masked-input v-model="dataBien.fecha_registro" mask="11/11/1111" placeholder="DD/MM/YYYY" disabled/>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                                                                  
                            </div>                                                                                                                                                                     
                        </div>                                        
                    </div>
                    <div class="col-md-12 pt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-danger active" @click="$modal.hide('bien')"><i class="fa fa-reply-all"></i> Cancelar</button>
                            <button type="submit" class="btn btn-success active" :disabled="ShowIcon"><i :class="[IconClass]"></i> {{ labelButton }}</button>
                        </div>
                    </div><!-- /.form-footer -->
                </form>
            </div>
        <!-- /. form de registro de pacientes -->
        </modal> 
        <modal name="imprimir" width="30%" height="auto" :scrollable="false" :clickToClose="false">
            <div id="printMe" class="form-group ml-10 mt-10">
                <h2 class="titulo">{{ showBien.nombre_empresa }}</h2>
                <h2 class="titulo">{{ showBien.nombre_sede }}</h2>

                <barcode :value="showBien.codigo_barra" width="1" height="28" fontSize="7" marginTop="5" marginBottom="2">
                    Show this if the rendering fails.
                </barcode> 
                <div class="todo">
                    <div class="mitad1">
                        <table class="descripcion">
                            <tr>
                                <th>{{ showBien.nombre_bien }}</th>
                            </tr>
                            <tr>
                                <td>{{ showBien.nombre_ubicacion}}</td>      
                            </tr>
                        </table>                       
                    </div>
                    <div class="mitad2">
                        <table class="conborde descripcion2 pull-right">
                            <tr class="conborde">
                                <th class="conborde">INV</th>
                            </tr>
                            <tr class="conborde">
                                <td class="conborde">2018</td>
                            </tr>
                        </table>
                    </div>
                </div>                                                                   
            </div> 
            <div class="col-md-12 pt-20 mb-10 mt-0 pr-20 separator">
                <div class="pull-right pr-10">
                    <button type="button" class="btn btn-danger active" @click="$modal.hide('imprimir')"><i class="fa fa-reply-all"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary active"  @click="Imprimir"><i class="fa fa-print"></i> Imprimir</button>
                </div>
            </div><!-- /.form-footer -->                          
        </modal> 
        <modal name="configuracion" width="60%" height="auto" :scrollable="false" :clickToClose="false">
            <div class="col-md-12 modal-main pl-0 pr-0">
                <div class="row title-form">
                    <h3 class="pull-left h3-title pl-10">Configuracion Avanzada</h3>
                    <div class="pull-right close-form pr-20" @click="$modal.hide('configuracion')"><i class="fa fa-close"></i></div> 
                </div>
                <div class="col-md-12 pl-0 pr-0">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" v-model="dataConfig.Ingreso"> Activar Ingreso Masivo
                            </label>
                        </div>                          
                    </div>
                    <div class="col-md-12">
                        <h5 class="mt-0">Seleccione los campos que se mantendran fijos durante la apertura del formulario de registro de bienes</h5>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.sede" :disabled="!dataConfig.Ingreso"> Sede
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.area" :disabled="!dataConfig.Ingreso"> Area
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.ubicacion" :disabled="!dataConfig.Ingreso"> Ubicación
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.responsable_area" :disabled="!dataConfig.Ingreso"> Responsable de Area
                                </label>
                            </div>                          
                        </div><!-- /.form-group --> 
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.clase" :disabled="!dataConfig.Ingreso"> Clase
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.responsable_bien" :disabled="!dataConfig.Ingreso"> Responsable del Bien
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->                                                                                                                       
                    </div>
                    <div class="col-md-3">
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataBien.descripcion" :disabled="!dataConfig.Ingreso"> Descripción
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataBien.marca" :disabled="!dataConfig.Ingreso"> Marca
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataBien.modelo" :disabled="!dataConfig.Ingreso"> Modelo
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataBien.numero_serie" :disabled="!dataConfig.Ingreso"> Número de serie
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataBien.medidas" :disabled="!dataConfig.Ingreso"> Medidas
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataBien.caracteristicas" :disabled="!dataConfig.Ingreso"> Caracteristicas
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->                                                                                                                                                  

                    </div>
                    <div class="col-md-3">
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.tipo_ingreso" :disabled="!dataConfig.Ingreso"> Tipo Ingreso
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.documento_compra" :disabled="!dataConfig.Ingreso"> Documento de Compra
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.serie_documento" :disabled="!dataConfig.Ingreso"> Serie Documento
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.numero_documento" :disabled="!dataConfig.Ingreso"> Número de Documento
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.proveedor" :disabled="!dataConfig.Ingreso"> Proveedor
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.garantia" :disabled="!dataConfig.Ingreso"> Garantia
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.dias_garantia" :disabled="!dataConfig.Ingreso"> Dias Garantia
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->                                                                                                                                                                                                                                                                                                                         
                    </div>
                    <div class="col-md-3"> 
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.fecha_compra" :disabled="!dataConfig.Ingreso"> Fecha Compra
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.dias_mantenimiento" :disabled="!dataConfig.Ingreso"> Dias Mantto.
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.conservacion" :disabled="!dataConfig.Ingreso"> Estado de Conservación
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.cuenta" :disabled="!dataConfig.Ingreso"> Cuenta
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.costo" :disabled="!dataConfig.Ingreso"> Costo
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.depresiable" :disabled="!dataConfig.Ingreso"> Depresiable
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->  
                        <div class="form-group ml-5 mb-0">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" v-model="dataConfig.condicion" :disabled="!dataConfig.Ingreso"> Condición
                                </label>
                            </div>                          
                        </div><!-- /.form-group -->                                                                                                                                                                                                                                                                                                                          
                    </div>                    
                    <div class="col-md-12 pt-20 mb-10 mt-0 pr-20 separator">
                        <div class="pull-right pr-10">
                            <button type="button" class="btn btn-warning active" @click="$modal.hide('configuracion')"><i class="fa fa-reply-all"></i> Cerrar</button>
                        </div>
                    </div><!-- /.form-footer -->                      
                </div>
            </div>  
        </modal>                            
    </div> 
</template>
<script>
import { BasicSelect } from 'vue-search-select'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
import VueBarcode from 'vue-barcode'
import { Printd } from 'printd'
export default {
    name:'bienes',
    created() {
        this.$store.dispatch('LOAD_EMPRESAS_LIST') 
        this.$store.dispatch('LOAD_AREAS_LIST')           
        this.$store.dispatch('LOAD_BIENES_LIST').then(() => {
            this.isLoading = false
        })               
        this.$store.dispatch('LOAD_DATA_INIT_LIST') 
    },
    mounted() {     
                        
    },        
    data() {
        return {
            isLoading: true,
            fullPage: true,
                        
            edition: false,
            searchText: '', // If value is falsy, reset searchText & searchItem

            codsed: '',
            codare: '',
            codubi: '',
            codgru: '',

            item_sed: { value: '', text: ''},             
            item_are: { value: '', text: ''},  
            item_ubi: { value: '', text: ''},  
            item_res_are: { value: '', text: ''}, 
            item_cla: { value: '', text: ''}, 
            item_res_bie: { value:'' , text:''},  
            item_tip_ing: { value:'', text:''},  
            item_tip_doc: { value:'', text:''},             
            item_pro: { value:'', text:''}, 
            item_cue: { value:'', text:''},  
            item_est: { value:'', text:''}, 
            item_gar: { value:'', text:''},                         

            IconClass : 'fa fa-cloud-upload',
            ShowIcon : false,
            labelButton: 'Grabar Datos',   

            columns: [
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
                },                                        
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'10%',  
                }                               
            ],  
            dataBien : {
                codigo_barra:'',
                codBar39:'',
                clase_id:'',
                descripcion:'',
                ubicacion_id:'',
                empleado_id:'',
                encargado_id:'',
                modelo:'',
                marca:'',
                numero_serie:'',
                medidas:'',
                caracteristicas:'',
                conservacion:'',
                en_uso: 'Si',
                fecha_compra:'',
                tipoingreso_id:'',
                documento_id:'',
                numero_documento:'',
                costo:'',
                proveedor_id:'',
                depresiable:false,
                cuenta_id:'',
                dias_mantenimiento:'',
                fecha_registro: moment().format('DD/MM/YYYY'),
                serie_documento:'',
                garantia_id:'',
                dias_garantia:'',
                foto:'no-image.png',
                image:''                 
            },
            combo_estados :[
                {value: 1 , text: 'Bueno'},
                {value: 2 , text: 'Malo'},
                {value: 3 , text: 'Regular'}     
            ],             
            errors:[],
            showBien: {
                nombre_empresa:'',
                nombre_sede:'',
                nombre_bien:'',
                nombre_ubicacion:'',
                codigo_barra:'',
                codBar39:''
            },
            dataConfig: {
                Ingreso: false,
                sede:false,
                area:false,
                ubicacion:false,
                responsable_area: false,
                clase: false,
                responsable_bien: false,
                descripcion:false,
                modelo:false,
                marca:false,
                numero_serie:false,
                medidas:false,
                caracteristicas:false,
                tipo_ingreso: false,
                tipo_documento: false,
                serie_documento:false,
                numero_documento:false,
                proveedor: false,
                garantia: false,
                dias_garantia: false,
                fecha_compra: false,
                dias_mantenimiento: false,
                depresiable: false,
                cuenta: false,
                costo: false,
                condicion: false                
            }
        }
    },
    computed: {
        ...mapState(['empresas','bienes','grupos','combo_areas','combo_ubicaciones','combo_clases','combo_responsables','combo_tipoingresos','combo_proveedores','combo_cuentas','combo_documentos','combo_sedes','combo_garantias']),
        ...mapGetters(['getBienesByEmpresaId']),
        areasBy: function(){
            return this.combo_areas.filter((are) => are.empresa_id == this.$route.params.empresa).filter((are) => are.sede_id == this.codsed)
        }, 
        ubicacionesBy: function(){
            return this.combo_ubicaciones.filter((ubi) => ubi.area_id == this.codare)
        },               
        BienesByEmpresa: function(){
            return this.getBienesByEmpresaId(this.$route.params.empresa)
        },
        NombreEmpresa: function(){
            return this.empresas.find(emp => emp.id == this.$route.params.empresa)
        },
        NombreGrupo: function(){
            var nombregrupo =  ''
            nombregrupo = this.grupos.find(gru => gru.id == this.codgru)
            if(nombregrupo === undefined){
                return 'GRUPO NO ASIGNADO'
            }else{
                return nombregrupo.nombre_grupo
            }
        }                
    },  
    components: {
      MaskedInput ,
      BasicSelect ,
      'barcode': VueBarcode
    },          
    methods: {
        Imprimir: function(){
            const cssText = `
            .titulo {
                font-family: sans-serif !important;
                font-size: 7px;
                margin:0;
                padding:0;
            }

            table {
                font-family: sans-serif;
                border-spacing: 0;
                border-collapse: collapse;
            }

            table.descripcion tr th {
                padding-bottom:5px;
            }

            .todo {
                width: 98%;
                margin:0;
                padding:0;
            }

            .mitad1 {
                width: 60%;
                display: inline-block;
            }

            .mitad2 {
                width: 30%;
                display: inline-block;
            }

            .conborde {
                border: 1px solid black;
            }

            .descripcion {
                font-family: sans-serif !important;
                font-size:6px !important;
            } 

            .descripcion2 {
                font-family: sans-serif !important;
                font-size:8px !important;                
            }
            .pull-right {
                float:right;
            }
         
            `
            const d = new Printd()
            // opens the "print dialog" of your browser to print the element
            d.print( document.getElementById('printMe'), cssText )        
        },
        LoadForm: function(){  
            this.dataConfig.Ingreso = false
            this.edition = false 
            this.codsed = '' 
            this.codare = ''
            this.codubi = ''
            this.codgru = ''

            this.item_sed = {},  
            this.item_are = {}  
            this.item_ubi = {} 
            this.item_res_are = {}
            this.item_cla = {} 
            this.item_res_bie = {}  
            this.item_tip_ing = {} 
            this.item_tip_doc ={}            
            this.item_pro = {}
            this.item_cue = {}  
            this.item_est = {} 
            this.item_gar = {}             

            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'          
            this.labelButton = 'Grabar Datos'             

            this.dataBien = {
                codigo_barra:'',
                codBar39:'',
                clase_id:'',
                descripcion:'',
                ubicacion_id:'',
                empleado_id:'',
                encargado_id:'',
                modelo:'',
                marca:'',
                numero_serie:'',
                medidas:'',
                caracteristicas:'',
                conservacion:'',
                en_uso:'Si',
                fecha_compra:'',
                tipoingreso_id:'',
                documento_id:'',
                numero_documento:'',
                costo:'',
                proveedor_id:'',
                depresiable:false,
                cuenta_id:'',
                dias_mantenimiento:'',
                fecha_registro: moment().format('DD/MM/YYYY'),
                serie_documento:'',
                garantia_id:'',
                dias_garantia:'',
                foto:'no-image.png',
                image:'' 
            }, 
            this.$emit('getClear') 
            this.$store.dispatch('LOAD_DATA_INIT_LIST')                    
            this.$modal.show('bien')
        },
        ActionBien: function(){
            if(typeof(this.dataBien.id) === "undefined"){
                this.createBien()
            }else{
                this.updateBien()
            }
        },
        createBien: function(){
            var url = '/api/bienes';
            this.LoadButton()  
            axios.post(url, this.dataBien).then(response => {
                if(typeof(response.data.errors) != "undefined"){
                    this.errors = response.data.errors;
                    var resultado = "";
                    for (var i in this.errors) {
                        if (this.errors.hasOwnProperty(i)) {
                            resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                        }
                    }
                    toastr.error(resultado);
                    this.ResetButton()                
                    return;
                }
                this.$store.dispatch('LOAD_BIENES_LIST')    
                this.errors = [];
                this.ResetButton()  
                if(this.dataConfig.Ingreso){
                    this.processCreateMasive()
                }else{
                    this.$modal.hide('bien');
                }           

                this.processImprimir(response.data[0])
                toastr.success('Nuevo Registro creado con exito');
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ResetButton()  
            });
        },
        updateBien: function(){
            var url = '/api/bienes/'+this.dataBien.id;
            this.LoadButton()     
            axios.put(url, this.dataBien).then(response => {
                if(typeof(response.data.errors) != "undefined"){
                    this.errors = response.data.errors;
                    var resultado = "";
                    for (var i in this.errors) {
                        if (this.errors.hasOwnProperty(i)) {
                            resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                        }
                    }
                    toastr.error(resultado);
                    this.ResetButton()    
                    return;
                }
                this.$store.dispatch('LOAD_BIENES_LIST')                  
                this.errors = [];
                this.ResetButton()
                this.$modal.hide('bien');
                toastr.success('El registro fue actualizado con exito');          
            }).catch(error => {
                this.errors = error.response.data.status;
                toastr.error("Hubo un error en el proceso: "+this.errors);
                this.ResetButton()               
            });
        },
        processEdit(params){
            this.edition = true
            this.$emit('getClear') 

            var databie = []
            databie = _.clone(params.row)
           
            this.item_sed = this.combo_sedes.find(sed => sed.value == databie.ubicacion.area.sede_id) 
            this.codsed = databie.ubicacion.area.sede_id
            this.codare = databie.ubicacion.area_id 
            this.codgru = databie.clase.grupo_id
            this.item_are = this.areasBy.find(are => are.value == this.codare)  
            this.item_ubi = this.ubicacionesBy.find(ubi => ubi.value == databie.ubicacion_id) 

            this.item_res_are = this.combo_responsables.find(res => res.value == databie.empleado_id)
            this.item_cla = this.combo_clases.find(cla => cla.value == databie.clase_id) 
            this.item_res_bie = this.combo_responsables.find(res => res.value == databie.encargado_id)  
            this.item_tip_ing = this.combo_tipoingresos.find(tip => tip.value == databie.tipoingreso_id) 
            this.item_cue = this.combo_cuentas.find(cue => cue.value == databie.cuenta_id)  
            this.item_est = this.combo_estados.find(est => est.text == databie.conservacion)
            if(databie.documento_id != null){
                this.item_tip_doc = this.combo_documentos.find(doc => doc.value == databie.documento_id)  
            }
            if(databie.proveedor_id != null){
                this.item_pro = this.combo_proveedores.find(pro => pro.value == databie.proveedor_id)
            }            
            if(databie.garantia_id != null){
                this.item_gar = this.combo_garantias.find(gar => gar.value == databie.garantia_id)
            }
   
            this.dataBien = {
                id:databie.id,
                codigo_barra:databie.codigo_barra,
                codBar39:databie.codBar39,
                clase_id:databie.clase_id,
                descripcion:databie.descripcion,
                ubicacion_id:databie.ubicacion_id,
                empleado_id:databie.empleado_id,
                encargado_id:databie.encargado_id,
                modelo:databie.modelo,
                marca:databie.marca,
                numero_serie:databie.numero_serie,
                medidas:databie.medidas,
                caracteristicas:databie.caracteristicas,
                conservacion:databie.conservacion,
                en_uso:databie.en_uso,
                fecha_compra: this.formatFecha(databie.fecha_compra),
                tipoingreso_id:databie.tipoingreso_id,
                documento_id:databie.documento_id,
                numero_documento:databie.numero_documento,
                costo:databie.costo,
                proveedor_id:databie.proveedor_id,
                depresiable:databie.depresiable,
                cuenta_id:databie.cuenta_id,
                dias_mantenimiento:databie.dias_mantenimiento,
                fecha_registro: this.formatFecha(databie.fecha_registro),
                serie_documento:databie.serie_documento,
                garantia_id:databie.garantia_id,
                dias_garantia:databie.dias_garantia,
                foto:databie.foto
            }, 
            this.$modal.show('bien')        
        },
        processCreateMasive(){
                this.dataBien.codigo_barra = ''
                this.dataBien.codBar39 = ''
                if(!this.dataConfig.clase) this.resetCla()
                if(!this.dataConfig.descripcion) this.dataBien.descripcion = ''
                if(!this.dataConfig.ubicacion) this.resetUbi()
                if(!this.dataConfig.responsable_area) this.resetResAre()
                if(!this.dataConfig.responsable_bien) this.resetResBie()
                if(!this.dataConfig.modelo) this.dataBien.modelo =''
                if(!this.dataConfig.marca) this.dataBien.marca = ''
                if(!this.dataConfig.numero_serie) this.dataBien.numero_serie = ''
                if(!this.dataConfig.medidas) this.dataBien.medidas = ''
                if(!this.dataConfig.caracteristicas) this.dataBien.caracteristicas = ''
                if(!this.dataConfig.conservacion) this.resetEst()
                if(!this.dataConfig.condicion) this.dataBien.en_uso = 'SI'
                if(!this.dataConfig.fecha_compra) this.dataBien.fecha_compra = ''
                if(!this.dataConfig.tipo_ingreso) this.resetTipIng()
                if(!this.dataConfig.tipo_documento) this.resetTipDoc()
                if(!this.dataConfig.numero_documento) this.dataBien.numero_documento = ''
                if(!this.dataConfig.costo) this.dataBien.costo = ''
                if(!this.dataConfig.proveedor) this.resetPro()
                if(!this.dataConfig.depresiable) this.dataBien.depresiable = false
                if(!this.dataConfig.cuenta) this.resetCue()
                if(!this.dataConfig.dias_mantenimiento) this.dataBien.dias_mantenimiento = ''
                this.dataBien.fecha_registro = moment().format('DD/MM/YYYY')
                if(!this.dataConfig.serie_documento) this.dataBien.serie_documento = ''
                if(!this.dataConfig.garantia) this.resetGar()
                if(!this.dataConfig.dias_garantia) this.dataBien.dias_garantia = ''
                this.dataBien.foto = 'no-image.png'
                if(!this.dataConfig.area) this.resetAre()
                if(!this.dataConfig.sede) this.resetSed()            
        },
        processDelete(id){
            this.$dialog.confirm("<span style='color:red'><strong>¿ Desea Eliminar este Registro ?</strong></span>", {
                html: true, // set to true if your message contains HTML tags. eg: "Delete <b>Foo</b> ?"
                loader: true, // set to true if you want the dailog to show a loader after click on "proceed"
                reverse: false, // switch the button positions (left to right, and vise versa)
                okText: 'Aceptar',
                cancelText: 'Cancelar',
                animation: 'fade', // Available: "zoom", "bounce", "fade"
                type: 'basic',
            })
                .then((dialog) => {
                var url = '/api/bienes/' + id;
                toastr.options.closeButton = true;
                toastr.options.progressBar = true;
                axios.delete(url).then(response=> {
                this.$store.dispatch('LOAD_BIENES_LIST')                    
                toastr.success('Registro Eliminado correctamente');
                dialog.close();
                });
                })
            .catch(() => {
                console.log('Delete aborted');
            });
        },   
        processImprimir(row){
            var databie = []
            databie = _.clone(row)
            
            this.showBien = {
                nombre_empresa:databie.ubicacion.area.empresa.nombre_empresa,
                nombre_sede:databie.ubicacion.area.sede.nombre_sede,
                nombre_bien:databie.descripcion,
                nombre_ubicacion:databie.ubicacion.nombre_ubicacion,
                codigo_barra:databie.codigo_barra,
                codBar39:databie.codBar39
            } 
            this.$modal.show('imprimir')                          

        }, 
        ResetButton: function() {
            this.ShowIcon = false
            this.IconClass = 'fa fa-cloud-upload'
            this.labelButton = 'Grabar Datos'  
        },
        LoadButton: function() {
            toastr.options.closeButton = true;
            toastr.options.progressBar = true;
            this.ShowIcon = true
            this.IconClass = 'fa fa-circle-o-notch fa-spin'        
            this.labelButton = 'Procesando'  
        },
        IngresoMasivo: function() {
            if(!this.dataConfig.ubicacion){ this.resetUbi }
            if(!this.dataConfig.area) { this.resetAre }
            if(!this.dataConfig.sede) { this.resetSed } 
            if(!this.dataConfig.responsable_area) { this.resetResAre }
            if(!this.dataConfig.clase) { this.resetCla }
            if(!this.dataConfig.responsable_bien) {this.resetResBie }
            if(!this.dataConfig.descripcion ) { this.dataBien.descripcion = ''}
            if(!this.dataConfig.marca ) { this.dataBien.marca = ''}    
            if(!this.dataConfig.modelo ) { this.dataBien.modelo = ''}    
            if(!this.dataConfig.medidas ) { this.dataBien.medidas = ''}  
            if(!this.dataConfig.caracteristicas ) { this.dataBien.caracteristicas = ''}  
            if(!this.dataConfig.tipo_ingreso){ this.resetTipIng }
            if(!this.dataConfig.tipo_documento){ this.resetTipDoc }    
            if(!this.dataConfig.serie_documento ) { this.dataBien.serie_documento = ''}    
            if(!this.dataConfig.numero_documento ) { this.dataBien.numero_documento = ''}                  
            if(!this.dataConfig.proveedor){ this.resetPro}
            if(!this.dataConfig.garantia){ this.resetGar }  
            if(!this.dataConfig.dias_garantia ) { this.dataBien.dias_garantia = ''}              
            if(!this.dataConfig.fecha_compra ) { this.dataBien.fecha_compra = ''}
            if(!this.dataConfig.dias_mantenimiento ) { this.dataBien.dias_mantenimiento = ''}            
            if(!this.dataConfig.conservacion){ this.resetEst }  
            if(!this.dataConfig.cuenta){ this.resetCue }  
            if(!this.dataConfig.costo ) { this.dataBien.costo = ''}          
            if(!this.dataConfig.depresiable ) { this.dataBien.depresiable = false}  
            if(!this.dataConfig.condicion ) { this.dataBien.en_uso = 'SI'}                                
        },
        getImagen: function(imagen){
            this.dataBien.image = imagen;
        },
        getClear: function(){
            console.log("evento clear");
        },                            
        onSelectUbi (item_ubi) {
            this.item_ubi = item_ubi
            this.dataBien.ubicacion_id = item_ubi.value
        },
        resetUbi () {
            this.item_ubi = {}
            this.dataBien.ubicacion_id = ''   
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
        onSelectResAre (item_res_are) {
            this.item_res_are = item_res_are
            this.dataBien.empleado_id = item_res_are.value
        },
        resetResAre () {
            this.item_res_are = {}
            this.dataBien.empleado_id = ''   
        },   
        onSelectCla (item_cla) {
            this.item_cla = item_cla
            this.codgru = item_cla.grupo_id
            this.dataBien.clase_id = item_cla.value

        },
        resetCla () {
            this.item_cla = {}
            this.codgru = '0'
            this.dataBien.clase_id = ''   
        }, 
        onSelectResBie (item_res_bie) {
            this.item_res_bie = item_res_bie
            this.dataBien.encargado_id = item_res_bie.value
        },
        resetResBie () {
            this.item_res_bie = {}
            this.dataBien.encargado_id = ''   
        },   
        onSelectEst (item_est) {
            this.item_est = item_est
            this.dataBien.conservacion = item_est.text
        },
        resetEst () {
            this.item_est = {}
            this.dataBien.conservacion = ''   
        }, 
        onSelectTipIng (item_tip_ing) {
            this.item_tip_ing = item_tip_ing
            this.dataBien.tipoingreso_id = item_tip_ing.value
        },
        resetTipIng () {
            this.item_tip_ing = {}
            this.dataBien.tipoingreso_id = ''   
        },   
        onSelectTipDoc (item_tip_doc) {
            this.item_tip_doc = item_tip_doc
            this.dataBien.documento_id = item_tip_doc.value
        },
        resetTipDoc () {
            this.item_tip_doc = {}
            this.dataBien.documento_id = ''   
        },   
        onSelectPro (item_pro) {
            this.item_pro = item_pro
            this.dataBien.proveedor_id = item_pro.value
        },
        resetPro () {
            this.item_pro = {}
            this.dataBien.proveedor_id = ''   
        },   
        onSelectCue (item_cue) {
            this.item_cue = item_cue
            this.dataBien.cuenta_id = item_cue.value
        },
        resetCue () {
            this.item_cue = {}
            this.dataBien.cuenta_id = ''   
        }, 
        onSelectGar (item_gar) {
            this.item_gar = item_gar
            this.dataBien.garantia_id = item_gar.value
        },
        resetGar () {
            this.item_gar = {}
            this.dataBien.garantia_id = ''   
        },    
        formatFecha : function(fec) {
            if(fec == null) {return null}
            var f = fec.split('-')
            var newf = f[2]+'-'+f[1]+'-'+f[0]
            return newf
        },
        eliminaFoto() {
            this.dataBien.foto = null
        }                                                                                             
    },
    filters:{
        reversefecha: function(value){
            if(!value) return ''
            value = value.toString()
            return value.split('-').reverse().join('-')
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
    /** estilos de la impresion **/
    .titulo {
        font-family: sans-serif !important;
        font-size: 12px;
        margin:0;
        padding:0;
    }

    table {
        font-family: sans-serif;
        border-spacing: 0;
        border-collapse: collapse;
    }

    table.descripcion tr th {
        padding-bottom:5px;
    }

    .todo {
        width: 98%;
        margin:0;
        padding:0;
    }

    .mitad1 {
        width: 60%;
        display: inline-block;
    }

    .mitad2 {
        width: 30%;
        display: inline-block;
    }

    .conborde {
        border: 1px solid black;
    }

    .descripcion {
        font-family: sans-serif !important;
        font-size:10px !important;
    } 

    .descripcion2 {
        font-family: sans-serif !important;
        font-size:12px !important;                
    }
    /** fin estilos de la impresion**/

    .reg-mas {
        font-size: 60% !important;
        font-weight: 300 !important;
    }


</style>