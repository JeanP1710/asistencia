import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePersona() {
    const personas = ref([])
    const errors = ref('')
    const persona = ref({})
    const respuesta = ref([])
    
    const obtenerPersona = async(id) => {
        let respuesta = await axios.get('persona/mostrar?id='+id,getConfigHeader())
        persona.value = respuesta.data
    }
    const listaPersonas = async()=>{
        let respuesta = await axios.get('persona/todos',getConfigHeader())
        personas.value = respuesta.data        
    }
    const obtenerPersonas = async(data) => {
        let respuesta = await axios.get('persona/listar' + getdataParamsPagination(data),getConfigHeader())
        personas.value =respuesta.data
    }

    const agregarPersona = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('persona/guardar',data,getConfigHeader())
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
    const actualizarPersona = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('persona/actualizar',data,getConfigHeader())
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
    const eliminarPersona = async(id) => {
        const respond = await axios.post('persona/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, personas, listaPersonas, persona, obtenerPersona, obtenerPersonas, 
        agregarPersona, actualizarPersona, eliminarPersona, respuesta
    }
}