import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useAlumno() {
    const personals = ref([])
    const errors = ref('')
    const personal = ref({})
    const respuesta = ref([])
    const obtenerPersonal = async(id) => {
        let respuesta = await axios.get('personal/mostrar?id='+id,getConfigHeader())
        personal.value = respuesta.data
    }
    const obtenerPersonalPorCodigo = async(id) => {
        let respuesta = await axios.get('personal/mostrar-codigo?codigo='+id,getConfigHeader())
        personal.value = respuesta.data
    }    
    const listaPersonals = async()=>{
        let respuesta = await axios.get('personal/todos',getConfigHeader())
       personals.value = respuesta.data        
    }
    const obtenerPersonals = async(data, form) => {
        let respuesta = await axios.post('personal/listar' + getdataParamsPagination(data), form, getConfigHeader())
        personals.value =respuesta.data
    }
    const personalsPorFiltros = async(data)=>{
        let respuesta = await axios.post('personal/reporte', data, getConfigHeader())
        personals.value =respuesta.data
    }
    const agregarPersonal = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('personal/guardar',data,getConfigHeader())
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
            let respond = await axios.get('personal/cambiar-estado?id='+id,getConfigHeader())
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
    const cambiarEstadoDeuda = async(data)=>{
        errors.value = ''
        try {
            let respond = await axios.post('personal/cambiar-deuda',data,getConfigHeader())
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
    const actualizarPersonal = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('personal/actualizar',data,getConfigHeader())
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
    const eliminarPersonal = async(id) => {
        const respond = await axios.post('personal/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, personals, listaPersonals, personal, obtenerPersonal, obtenerPersonals, 
        agregarPersonal, actualizarPersonal, eliminarPersonal, respuesta, obtenerPersonalPorCodigo,
        cambiarEstado, cambiarEstadoDeuda, personalsPorFiltros
    }
}