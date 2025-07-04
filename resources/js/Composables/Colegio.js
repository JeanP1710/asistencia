import axios from 'axios'
import { ref } from 'vue'
import { getConfigHeader, getdataParamsPagination } from '@/Helpers'
export default function useColegio() {
    const colegios = ref([])
    const errors = ref('')
    const colegio = ref({})
    const respuesta = ref([])
    
    const obtenerColegio = async(id) => {
        let respuesta = await axios.get('colegio/mostrar?id='+id,getConfigHeader())
        colegio.value = respuesta.data
    }
    const listaColegios = async(tipo)=>{
        let respuesta = await axios.get('colegio/todos?tipo='+tipo,getConfigHeader())
        colegios.value = respuesta.data        
    }
    const obtenerColegios = async(data) => {
        let respuesta = await axios.get('colegio/listar' + getdataParamsPagination(data),getConfigHeader())
        colegios.value =respuesta.data
    }

    const agregarColegio = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('colegio/guardar',data,getConfigHeader())
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
    const actualizarColegio = async(data) => {
        errors.value = ''
        try {
            let respond = await axios.post('colegio/actualizar',data,getConfigHeader())
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
    const eliminarColegio = async(id) => {
        const respond = await axios.post('colegio/eliminar', {id:id},getConfigHeader())
        if(respond.data.ok==1)
        {
            respuesta.value = respond.data
        }
    }
    return {
        errors, colegios, listaColegios, colegio, obtenerColegio, obtenerColegios, 
        agregarColegio, actualizarColegio, eliminarColegio, respuesta
    }
}