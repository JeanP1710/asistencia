import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useMedioDifusion() {
    const medios = ref([])
    const errors = ref('')
    const medio = ref({})
    const respuesta = ref([])
    
    const obtenerMedio = async(id) => {
        let respuesta = await axios.get('medio-difusion/mostrar?id='+id,getConfigHeader())
        medio.value = respuesta.data
    }
    const listaMedios = async()=>{
        let respuesta = await axios.get('medio-difusion/todos',getConfigHeader())
        medios.value = respuesta.data        
    }
    const obtenerMedios = async(data) => {
        let respuesta = await axios.get('medio-difusion/listar' + getdataParamsPagination(data),getConfigHeader())
        medios.value =respuesta.data
    }
    const agregarMedio = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('medio-difusion/guardar',data,getConfigHeader())
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
    const actualizarMedio = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('medio-difusion/actualizar',data,getConfigHeader())
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
    const eliminarMedio = async(id) => {
        const respond = await axios.post('medio-difusion/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, medios, listaMedios, medio, obtenerMedio, obtenerMedios, 
        agregarMedio, actualizarMedio, eliminarMedio, respuesta
    }
}