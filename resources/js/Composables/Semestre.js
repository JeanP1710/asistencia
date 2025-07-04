import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useSemestre() {
    const semestres = ref([])
    const errors = ref('')
    const semestre = ref({})
    const respuesta = ref([])
    
    const obtenerSemestre = async(id) => {
        let respuesta = await axios.get('semestre/mostrar?id='+id,getConfigHeader())
        semestre.value = respuesta.data
    }
    const listaSemestres = async()=>{
        let respuesta = await axios.get('semestre/todos',getConfigHeader())
        semestres.value = respuesta.data        
    }
    const obtenerSemestres = async(data) => {
        let respuesta = await axios.get('semestre/listar' + getdataParamsPagination(data),getConfigHeader())
        semestres.value =respuesta.data
    }
    const agregarSemestre = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('semestre/guardar',data,getConfigHeader())
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
    const actualizarSemestre = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('semestre/actualizar',data,getConfigHeader())
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
    const eliminarSemestre = async(id) => {
        const respond = await axios.post('semestre/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, semestres, listaSemestres, semestre, obtenerSemestre, obtenerSemestres, 
        agregarSemestre, actualizarSemestre, eliminarSemestre, respuesta
    }
}