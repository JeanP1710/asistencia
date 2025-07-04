import axios from 'axios';
import { ref,provide } from 'vue';
import useHelper from '@/Helpers';


export const useAutenticacion = () => {
    const errors = ref('');
    const {Swal } = useHelper();
    const loginUsuario = async (data) => {
        errors.value = ''
        try {
            const respuesta = await axios.post('login',data)
            if(respuesta.data)
            {
                localStorage.setItem('userSession',respuesta.data);
                if(data.tipo==='Administrativo'){
                    window.location.href = '/principal';
                }else{
                    window.location.href = '/evasis';
                    
                }
            }
        } catch (error) {
            if(error.response.status === 422){
                errors.value = error.response.data.errors
            }
        }
    }
    const loginAlumno = async (data) => {
        errors.value = ''
        try {
            const respuesta = await axios.post('login-alumno',data)
            if(respuesta.data)
            {
                localStorage.setItem('alumnoSession',respuesta.data);
                if(data.tipo==='Administrativo'){
                    window.location.href = '/principal';
                }else{
                    window.location.href = '/ficha-socio';
                    
                }
                
            }
        } catch (error) {
            if(error.response.status === 422){
                errors.value = error.response.data.errors
            }
        }
    }
    const logoutUsuario = async() => {
        const respuesta = await axios.post('logout')
        if(respuesta.data.ok==1)
        {
            localStorage.removeItem('userSession')
            window.location.href="/login"
        }
    }

    const logoutAlumno = async() => {
        const respuesta = await axios.post('logout-alumno')
        if(respuesta.data.ok==1)
        {
            localStorage.removeItem('alumnoSession')
            window.location.href="/alumno-login"
        }
    }
    return {
        errors, loginUsuario, logoutUsuario, logoutAlumno, loginAlumno
    }

}