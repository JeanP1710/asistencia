import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useDeuda() {
    const errors = ref('')
    const deudas = ref([])
    const respuesta = ref([])
    
    const agregarDeuda = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('deuda/guardar',data,getConfigHeader())
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
    const eliminarDeuda = async(id) => {
        const respond = await axios.post('deuda/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    const obtenerDeudas = async(alumno_id)=>{
        let respuesta = await axios.get('deuda/todos?alumno_id='+alumno_id,getConfigHeader())
        deudas.value = respuesta.data        
    }    
    return {
        errors, obtenerDeudas, 
        agregarDeuda, deudas, eliminarDeuda, respuesta
    }
}