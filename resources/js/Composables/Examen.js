import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useExamen() {
    const examenes = ref([])
    const examenesRendidos = ref([])
    const errors = ref('')
    const examen = ref({})
    const respuesta = ref([])
    const pregunta = ref([])
    const examen_alumno=ref([])
    const registros = ref([])
    const preguntasPorExamen = ref([])
    const index=ref('')
    const obtenerExamen = async(id) => {
        let respuesta = await axios.get('examen/mostrar?id='+id,getConfigHeader())
        examen.value = respuesta.data
    }
    const obtenerAlternativaMarcada = async(id) => {
        let respuesta = await axios.get('examen/ver-alternativa-marcada?id='+id,getConfigHeader())
        examen.value = respuesta.data
    }    
    const validarExamenRendido = async(id) => {
        let response = await axios.get('examen/dio-examen?id='+id,getConfigHeader())
        respuesta.value = response.data
    }    
    
    const listaExamenes = async(id)=>{
        let respuesta = await axios.get('examen/registros-por-persona?persona_id='+id,getConfigHeader())
        examenes.value = respuesta.data        
    }
    const todosActivos = async()=>{
        let respuesta = await axios.get('examen/todos-activos',getConfigHeader())
        examenes.value = respuesta.data        
    }

    const todosExamenes = async()=>{
        let respuesta = await axios.get('examen/todos',getConfigHeader())
        examenes.value = respuesta.data        
    }
    
    const listosExamenes = async(alumno_id)=>{
        let respuesta = await axios.get('examen/listos?alumno_id='+alumno_id,getConfigHeader())
        examenes.value = respuesta.data        
    }    
    const cargarAlumnosExamen = async(examen_id)=>{
        let respuesta = await axios.get('examen/alumnos-por-examen?examen_id='+examen_id,getConfigHeader())
        registros.value = respuesta.data        
    }
    const examenesRendidosPorAlumno = async(alumno_id)=>{
        let respuesta = await axios.get('examen/examenes-rendidos?alumno_id='+alumno_id,getConfigHeader())
        examenesRendidos.value = respuesta.data        
    }
    const obtenerDetalleExamen = async(id) => {
        let respuesta = await axios.get('examen/detalle-examen?id=' + id,getConfigHeader())
        preguntasPorExamen.value =respuesta.data
    }
    const obtenerExamenes = async(data) => {
        let respuesta = await axios.get('examen/listar' + getdataParamsPagination(data),getConfigHeader())
        examenes.value =respuesta.data
    }
    const obtenerPregunta = async(id) =>{
        let respuesta = await axios.get('examen/pregunta?id='+id,getConfigHeader())
        pregunta.value = respuesta.data.pregunta
        examen_alumno.value = respuesta.data.examen_alumno
        index.value = respuesta.data.indice
    }
    const validarRespuesta = async(data)=>{
        let respond = await axios.post('examen/validar',data,getConfigHeader())
        if(respond.data.ok==1){
            respuesta.value=respond.data
        }
    }
    const registrarDistraccion = async(data)=>{
        let respond = await axios.post('examen/registrar-distraccion',data,getConfigHeader())
        if(respond.data.ok==1){
            respuesta.value=respond.data
        }
    }
    const agregarExamen = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('examen/guardar',data,getConfigHeader())
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
    const actualizarExamen = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('examen/actualizar',data,getConfigHeader())
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
    const eliminarexamen = async(id) => {
        const respond = await axios.post('examen/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    const eliminarExamenAlumno = async(id) => {
        const respond = await axios.post('examen/eliminar-alumno-examen', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, examenes, listaExamenes, examen, obtenerExamen, obtenerExamenes, 
        agregarExamen, actualizarExamen, eliminarexamen, respuesta, todosExamenes,
        obtenerPregunta, pregunta, validarRespuesta, examen_alumno, index, validarExamenRendido, cargarAlumnosExamen,
        registros, eliminarExamenAlumno, preguntasPorExamen, obtenerDetalleExamen, registrarDistraccion,
        examenesRendidosPorAlumno, examenesRendidos, listosExamenes, todosActivos
    }
}