import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useDocente() {
    const docentes = ref([])
    const errors = ref('')
    const docente = ref({})
    const respuesta = ref([])
    const obtenerDocente = async(id) => {
        let respuesta = await axios.get('docente/mostrar?id='+id,getConfigHeader())
        docente.value = respuesta.data
    }
    const obtenerDocentePorCodigo = async(id) => {
        let respuesta = await axios.get('docente/mostrar-codigo?codigo='+id,getConfigHeader())
        docente.value = respuesta.data
    }    
    const listaDocentes = async()=>{
        let respuesta = await axios.get('docente/todos',getConfigHeader())
        docentes.value = respuesta.data        
    }
    const obtenerDocentes = async(data, form) => {
        let respuesta = await axios.post('docente/listar' + getdataParamsPagination(data), form, getConfigHeader())
        docentes.value =respuesta.data
    }
    const docentesPorFiltros = async(data)=>{
        let respuesta = await axios.post('docente/reporte', data, getConfigHeader())
        docentes.value =respuesta.data
    }
    const agregarDocente = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('docente/guardar',data,getConfigHeader())
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
    const actualizarDocente = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('docente/actualizar',data,getConfigHeader())
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
    const cambiarEstado = async(id)=>{
        errors.value = ''
        try {
            let respond = await axios.get('docente/cambiar-estado?id='+id,getConfigHeader())
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
    const eliminarDocente = async(id) => {
        const respond = await axios.post('docente/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, docentes, listaDocentes, docente, obtenerDocente, obtenerDocentes, 
        agregarDocente, actualizarDocente, eliminarDocente, respuesta, obtenerDocentePorCodigo,
        docentesPorFiltros, cambiarEstado
    }
}