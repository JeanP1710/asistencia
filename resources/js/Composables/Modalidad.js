import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useModalidadDifusion() {
    const modalidades = ref([])
    const errors = ref('')
    const modalidad = ref({})
    const respuesta = ref([])
    
    const obtenerModalidad = async(id) => {
        let respuesta = await axios.get('modalidad/mostrar?id='+id,getConfigHeader())
        modalidad.value = respuesta.data
    }
    const listaModalidades = async()=>{
        let respuesta = await axios.get('modalidad/todos',getConfigHeader())
        modalidades.value = respuesta.data        
    }
    const obtenerModalidades = async(data) => {
        let respuesta = await axios.get('modalidad/listar' + getdataParamsPagination(data),getConfigHeader())
        modalidades.value =respuesta.data
    }
    const agregarModalidad = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('modalidad/guardar',data,getConfigHeader())
            errors.value =''
            if(respond.data.ok==1){
                respuesta.value=respond.data
            }
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const actualizarModalidad = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('modalidad/actualizar',data,getConfigHeader())
            errors.value =''
            if(respond.data.ok==1){
                respuesta.value=respond.data
            }

        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const eliminarModalidad = async(id) => {
        const respond = await axios.post('modalidad/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, modalidades, listaModalidades, modalidad, obtenerModalidad, obtenerModalidades, 
        agregarModalidad, actualizarModalidad, eliminarModalidad, respuesta
    }
}