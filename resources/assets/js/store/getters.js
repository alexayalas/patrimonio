export default {
    getBienesByEmpresaId: (state, getters) => (id) => {
        return state.bienes.filter(bien => bien.ubicacion.area.empresa_id == id).filter(bien => bien.activo == true).filter(bien => bien.baja == false)
    }, 
    getTrasladosByEmpresaId: (state, getters) => (id) => {
        return state.movimientos.filter(mov => mov.ubicacion_actual.area.empresa_id == id).filter(mov => mov.tipomovimiento == 'Traslado')
    },
    getBajasByEmpresaId: (state, getters) => (id) => {
        return state.movimientos.filter(mov => mov.ubicacion_actual.area.empresa_id == id).filter(mov => mov.tipomovimiento == 'Baja')
    },            
    getareas: state => {
        return state.combo_areas
    },                               
}