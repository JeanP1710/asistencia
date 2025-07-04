import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useCertificado() {
    const certificados = ref([])
    const errors = ref('')
    const certificado = ref({})
    const respuesta = ref([])
    
    const obtenerCertificado = async(id) => {
        let respuesta = await axios.get('certificado/mostrar?id='+id,getConfigHeader())
        certificado.value = respuesta.data
    }
    const listaCertificados = async(id)=>{
        let respuesta = await axios.get('certificado/registros-por-persona?persona_id='+id,getConfigHeader())
        certificados.value = respuesta.data        
    }
    const obtenerCertificados = async(data) => {
        let respuesta = await axios.get('certificado/listar' + getdataParamsPagination(data),getConfigHeader())
        certificados.value =respuesta.data
    }

    const agregarCertificado = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('certificado/guardar',data,getConfigHeader())
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
    const actualizarCertificado = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('certificado/actualizar',data,getConfigHeader())
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
    const eliminarCertificado = async(id) => {
        const respond = await axios.post('certificado/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, certificados, listaCertificados, certificado, obtenerCertificado, obtenerCertificados, 
        agregarCertificado, actualizarCertificado, eliminarCertificado, respuesta
    }
}