export default {
    getBienesByEmpresaId: (state, getters) => (id) => {
        return state.bienes.filter(bien => bien.ubicacion.area.empresa_id == id)
    }, 
    getTrasladosByEmpresaId: (state, getters) => (id) => {
        return state.movimientos.filter(mov => mov.ubicacion_actual.area.empresa_id == id).filter(mov => mov.tipomovimiento == 'Traslado')
    },      
    getareas: state => {
        return state.combo_areas
    },                               
}