import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function usePrograma() {
    const programas = ref([])
    const errors = ref('')
    const programa = ref({})
    const respuesta = ref([])
    
    const obtenerPrograma = async(id) => {
        let respuesta = await axios.get('programa/mostrar?id='+id,getConfigHeader())
        programa.value = respuesta.data
    }
    const listaProgramas = async()=>{
        let respuesta = await axios.get('programa/todos',getConfigHeader())
        programas.value = respuesta.data        
    }
    const obtenerProgramas = async(data) => {
        let respuesta = await axios.get('programa/listar' + getdataParamsPagination(data),getConfigHeader())
        programas.value =respuesta.data
    }
    const agregarPrograma = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('programa/guardar',data,getConfigHeader())
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
    const actualizarPrograma = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('programa/actualizar',data,getConfigHeader())
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
    const eliminarPrograma = async(id) => {
        const respond = await axios.post('programa/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, programas, listaProgramas, programa, obtenerPrograma, obtenerProgramas, 
        agregarPrograma, actualizarPrograma, eliminarPrograma, respuesta
    }
}