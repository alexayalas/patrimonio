export default {
    getBienesByEmpresaId: (state, getters) => (id) => {
        return state.bienes.filter(bien => bien.ubicacion.area.empresa_id == id)
    },   
    getareas: state => {
        return state.combo_areas
    },                               
}