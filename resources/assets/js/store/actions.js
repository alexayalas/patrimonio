export default {
    LOGOUT({ commit }) {
        return new Promise((resolve, reject) => {
            axios.post('/api/logout')
                .then(function (response) {
                    commit('LOGOUT')
                    resolve()
                })
                .catch(function (error) {
                    console.log(error)
                    reject(error)
                });
        }, error => console.log(error))
    },
    SAVE_TOKEN({ commit }, payload) {
        commit('SAVE_TOKEN', { datos: payload })
    },
    CLOSE_SESSION({ commit }) {
        commit('LOGOUT')
    }, 
    LOAD_BIENES_LIST: function ({ commit }) {
        var urlBienes = '/api/bienes';
        return axios.get(urlBienes).then((response) => {
            commit('SET_BIENES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_AREAS_LIST: function ({ commit }) {
        var urlAreas = '/api/areas';
        return axios.get(urlAreas).then((response) => {
            commit('SET_AREAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_EMPRESAS_LIST: function ({ commit }) {
        var urlEmpresas = '/api/empresas';
        return axios.get(urlEmpresas).then((response) => {
            commit('SET_EMPRESAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_SEDES_LIST: function ({ commit }) {
        var urlSedes = '/api/sedes';
        return axios.get(urlSedes).then((response) => {
            commit('SET_SEDES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },     
    LOAD_COMBO_EMPRESAS_LIST: function ({ commit }) {
        var urlType = '/api/areas/create';
        return axios.get(urlType).then((response) => {
            commit('SET_COMBO_EMPRESAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_COMBO_AREAS_LIST: function ({ commit }) {
        var urlType = '/api/ubicaciones/create';
        return axios.get(urlType).then((response) => {
            commit('SET_COMBO_AREAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_UBICACIONES_LIST: function ({ commit }) {
        var urlUbicaciones = '/api/ubicaciones';
        return axios.get(urlUbicaciones).then((response) => {
            commit('SET_UBICACIONES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_GRUPOS_LIST: function ({ commit }) {
        var urlGrupos = '/api/grupos';
        return axios.get(urlGrupos).then((response) => {
            commit('SET_GRUPOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },   
    LOAD_CLASES_LIST: function ({ commit }) {
        var urlClases = '/api/clases';
        return axios.get(urlClases).then((response) => {
            commit('SET_CLASES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_COMBO_GRUPOS_LIST: function ({ commit }) {
        var urlType = '/api/clases/create';
        return axios.get(urlType).then((response) => {
            commit('SET_COMBO_GRUPOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_COMBO_ROLES_LIST: function ({ commit }) {
        var urlType = '/api/roles/show';
        return axios.get(urlType).then((response) => {
            commit('SET_COMBO_ROLES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },    
    LOAD_EMPLEADOS_LIST: function ({ commit }) {
        var urlEmpleados = '/api/empleados';
        return axios.get(urlEmpleados).then((response) => {
            commit('SET_EMPLEADOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_PROVEEDORES_LIST: function ({ commit }) {
        var url = '/api/proveedores';
        return axios.get(url).then((response) => {
            commit('SET_PROVEEDORES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },    
    LOAD_TIPOINGRESOS_LIST: function ({ commit }) {
        var url = '/api/tipoingresos';
        return axios.get(url).then((response) => {
            commit('SET_TIPOINGRESOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_CUENTAS_LIST: function ({ commit }) {
        var url = '/api/cuentas';
        return axios.get(url).then((response) => {
            commit('SET_CUENTAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_DOCUMENTOS_LIST: function ({ commit }) {
        var url = '/api/documentos';
        return axios.get(url).then((response) => {
            commit('SET_DOCUMENTOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_GARANTIAS_LIST: function ({ commit }) {
        var urlGarantias = '/api/garantias';
        return axios.get(urlGarantias).then((response) => {
            commit('SET_GARANTIAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_ROLES_LIST: function ({ commit }) {
        var url = '/api/roles';
        return axios.get(url).then((response) => {
            commit('SET_ROLES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },   
    LOAD_PERMISOS_LIST: function ({ commit }) {
        var url = '/api/roles/create';
        return axios.get(url).then((response) => {
            commit('SET_PERMISOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_USERS_LIST: function ({ commit }) {
        var url = '/api/users';
        return axios.get(url).then((response) => {
            commit('SET_USERS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },              
    LOAD_DATA_INIT_LIST: function ({ commit }) {
        var urlType = '/api/bienes/create';
        return axios.get(urlType).then((response) => {
            commit('SET_DATA_INIT_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },                                                                                                         
}