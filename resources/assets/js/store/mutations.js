export default {
    LOGOUT(state) {
        state.authenticated = false
        state.role_user = null
        localStorage.removeItem('autentificado')
    },
    SAVE_TOKEN(state, { datos }) {
        state.authenticated = true
        state.user_system = datos.user.user[0]  // aca estan los datos del usuario loggeado  
        state.permisos_user = datos.user.permisos_user          
        state.isAdmin = datos.user.isAdmin   
        localStorage.setItem('autentificado', true)
        localStorage.setItem('user', JSON.stringify(datos.user.user[0]))
        console.log("datos de loggin:",datos)
    },
    SET_BIENES_LIST: (state, { list }) => {      // BIENES
        state.bienes = list
    },  
    SET_AREAS_LIST: (state, { list }) => {      // AREAS
        state.areas = list
    },  
    SET_EMPRESAS_LIST: (state, { list }) => {      // EMPRESAS
        state.empresas = list
    },  
    SET_SEDES_LIST: (state, { list }) => {      // SEDES
        state.sedes = list
    },     
    SET_COMBO_EMPRESAS_LIST: (state, { list }) => {
        state.combo_empresas = list.combo_empresas
        state.combo_sedes = list.combo_sedes
    }, 
    SET_COMBO_AREAS_LIST: (state, { list }) => {
        state.combo_areas = list
    },  
    SET_UBICACIONES_LIST: (state, { list }) => {      // UBICACIONES
        state.ubicaciones = list
    },  
    SET_GRUPOS_LIST: (state, { list }) => {      // GRUPOS
        state.grupos = list
    },  
    SET_CLASES_LIST: (state, { list }) => {      // CLASES
        state.clases = list
    },
    SET_COMBO_GRUPOS_LIST: (state, { list }) => {
        state.combo_grupos = list
    },
    SET_COMBO_ROLES_LIST: (state, { list }) => {
        state.combo_roles = list
    },    
    SET_EMPLEADOS_LIST: (state, { list }) => {      // EMPLEADOS
        state.empleados = list
    },     
    SET_PROVEEDORES_LIST: (state, { list }) => {      // PROVEEDORES
        state.proveedores = list
    },    
    SET_TIPOINGRESOS_LIST: (state, { list }) => {      // TIPO DE INGRESOS
        state.tipoingresos = list
    },   
    SET_CUENTAS_LIST: (state, { list }) => {      // CUENTAS
        state.cuentas = list
    },  
    SET_DOCUMENTOS_LIST: (state, { list }) => {      // DOCUMENTOS
        state.documentos = list
    },  
    SET_GARANTIAS_LIST: (state, { list }) => {      // GARANTIAS
        state.garantias = list
    },      
    SET_ROLES_LIST: (state, { list }) => {      // ROLES
        state.roles = list
    }, 
    SET_MODULES_LIST: (state, { list }) => {      // MODULOS
        state.modules = list
    },     
    SET_USERS_LIST: (state, { list }) => {      // USUARIOS
        state.users = list
    },     
    SET_PERMISOS_LIST: (state, { list }) => {      // PERMISOS
        state.permisos = list
    },          
    SET_DATA_INIT_LIST: (state, { list }) => {
        state.combo_responsables    = list.combo_responsables
        state.combo_clases          = list.combo_clases
        state.combo_areas           = list.combo_areas
        state.combo_ubicaciones     = list.combo_ubicaciones
        state.combo_empresas        = list.combo_empresas
        state.combo_sedes           = list.combo_sedes   
        state.grupos                = list.grupos       
        state.combo_tipoingresos    = list.combo_tipoingresos
        state.combo_proveedores     = list.combo_proveedores
        state.combo_cuentas         = list.combo_cuentas
        state.combo_documentos      = list.combo_documentos 
        state.combo_garantias       = list.combo_garantias      
    },
    SET_ROLE_USER: (state, { list }) => {      // PERFIL DE USUARIO
        state.role_user = list
    },  
    SET_MOVIMIENTOS_LIST: (state, { list }) => {      // MOVIMIENTOS
        state.movimientos = list
    },  
    CHANGE_COMPANY: (state, { id }) => {
        state.company_id = id
    },                                                                                                      
}