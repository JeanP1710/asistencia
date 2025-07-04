import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useMarcacion() {
    const marcaciones = ref([])
    const marcacionesHorarios = ref([])
    const errors = ref('')
    const marcacion = ref({})
    const respuesta = ref([])
    const faltas = ref([])
    const faltasdetalle = ref([])
    const registrosHorariosExtras =  ref([])
    const registros = ref([])
    const respuesta2 = ref({})
    const obtenerMarcacion = async(id) => {
        let respuesta = await axios.get('marcacion/mostrar?id='+id,getConfigHeader())
        marcacion.value = respuesta.data
    }
    const marcoHoy = async(data) => {
        let respuesta = await axios.post('marcacion/marco-hoy',data,getConfigHeader())
        respuesta2.value = respuesta.data
    }    
    const obtenerMarcaciones = async(data) => {
        let respuesta = await axios.get('marcacion/listar' + getdataParamsPagination(data),getConfigHeader())
        marcaciones.value =respuesta.data
    }
    const obtenerMarcacionesFiltros = async(data, form) => {
        let respuesta = await axios.post('marcacion/listar-por-filtro' + getdataParamsPagination(data), form,getConfigHeader())
        marcaciones.value =respuesta.data
    }
    const obtenerMarcacionesReporte = async(data) => {
        let respuesta = await axios.post('marcacion/marcaciones-por-personal',data,getConfigHeader())
        marcaciones.value =respuesta.data
    }
    const obtenerMarcacionesMensual = async(data) => {
        errors.value = ''
        try {
            let respuesta = await axios.post('marcacion/marcaciones-mensual',data,getConfigHeader())
            errors.value =''
            registros.value =respuesta.data
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }    
    const obtenerMarcacionesMensualDocente = async(data) => {
        errors.value = ''
        try {
            let respuesta = await axios.post('marcacion/marcaciones-mensual-docente',data,getConfigHeader())
            errors.value =''
            registros.value =respuesta.data
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }    
    
    const agregarMarcacion = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('marcacion/guardar',data,getConfigHeader())
            errors.value =''
            //if(respond.data.ok==1){
                respuesta.value=respond.data
            //}
        } catch (error) {
            errors.value=""
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const importarMarcaciones = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('marcacion/importacion',data,getConfigHeader())
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
    const actualizarMarcacion = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('marcacion/actualizar',data,getConfigHeader())
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
    const eliminarMarcacion = async(id) => {
        const respond = await axios.post('marcacion/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    const cargarMarcacionHorario = async(data) => {
        try {
            let respond = await axios.post('marcacion/marcaciones-horario', data,getConfigHeader())
            marcacionesHorarios.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }

    const cargarReporteMarcaciones = async(data) => {
        try {
            let respond = await axios.post('marcacion/reporte-marcaciones', data,getConfigHeader())
            registros.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    
    const cargarTardanzas = async(data) =>{
        try {
            let respond = await axios.post('marcacion/reporte-tardanzas', data,getConfigHeader())
            marcacionesHorarios.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const cargarFaltasEstablecimiento = async(data) =>{
        try {
            let respond = await axios.post('marcacion/reporte-faltas', data,getConfigHeader())
            faltas.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }    
    const cargarFaltas = async(data) =>{
        try {
            let respond = await axios.post('marcacion/faltas', data,getConfigHeader())
            faltasdetalle.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const cargarFaltasxFecha = async(data) =>{
        try {
            let respond = await axios.post('marcacion/reporte-faltas-fecha', data,getConfigHeader())
            faltas.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }
    }
    const  cargarReporteHorasExtras = async(data)=>{
        try {
            let respond = await axios.post('marcacion/reporte-horas-extras', data,getConfigHeader())
            registrosHorariosExtras.value =respond.data
        } catch (error) {
            if(error.response.status === 422) {
                errors.value = error.response.data.errors
            }
        }        
    }

    return {
        errors, marcaciones, marcacion, obtenerMarcacion, obtenerMarcaciones, 
        agregarMarcacion, actualizarMarcacion, eliminarMarcacion, respuesta, obtenerMarcacionesReporte,
        cargarMarcacionHorario, marcacionesHorarios, cargarTardanzas, cargarFaltas, faltas, cargarFaltasEstablecimiento,
        faltasdetalle, cargarFaltasxFecha, importarMarcaciones, cargarReporteHorasExtras, registrosHorariosExtras,
        cargarReporteMarcaciones, registros, obtenerMarcacionesFiltros, obtenerMarcacionesMensual, obtenerMarcacionesMensualDocente,
        marcoHoy, respuesta2
    }
}