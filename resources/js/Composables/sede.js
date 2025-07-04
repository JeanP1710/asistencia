import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useSede() {
    const sedes = ref([])
    const errors = ref('')
    const sede = ref({})
    const respuesta = ref([])
    
    const obtenerSede = async(id) => {
        let respuesta = await axios.get('sede/mostrar?id='+id,getConfigHeader())
        sede.value = respuesta.data
    }
    const listaSedes = async()=>{
        let respuesta = await axios.get('sede/todos',getConfigHeader())
        sedes.value = respuesta.data        
    }
    const obtenerSedes = async(data) => {
        let respuesta = await axios.get('sede/listar' + getdataParamsPagination(data),getConfigHeader())
        sedes.value =respuesta.data
    }

    const agregarSede = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('sede/guardar',data,getConfigHeader())
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
    const actualizarSede = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('sede/actualizar',data,getConfigHeader())
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
    const eliminarSede = async(id) => {
        const respond = await axios.post('sede/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, sedes, listaSedes, sede, obtenerSede, obtenerSedes, 
        agregarSede, actualizarSede, eliminarSede, respuesta
    }
}