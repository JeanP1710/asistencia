<script setup>
    import { ref, onMounted } from 'vue';
    import useHelper from '@/Helpers'; 
    import usePersonal from '@/Composables/Personal.js';

    import useSede from '@/Composables/sede.js';
    import { jwtDecode } from 'jwt-decode'

    const {
        obtenerPersonalPorCodigo, personal
    } = usePersonal();


    const { openModal, Toast, Swal, formatoFecha } = useHelper();

    const form = ref({
        numero_dni : '',
        errors:[]
    });

    const validar=async()=>{
        await obtenerPersonalPorCodigo(form.value.numero_dni)
        if(personal.value){
            form.value.errors = []
            Swal.fire({
                title: "Personal",
                html: 'DNI :' + personal.value.numero_dni + ' <br> APELLIDOS Y NOMBRES : ' +
                personal.value.apellido_paterno + ' ' + personal.value.apellido_materno + ' '+ personal.value.nombres + 
                '<br>PROGRAMA DE ESTUDIOS : '+ personal.value.programa.nombre +'<br><img src="storage/personals/'+ personal.value.numero_dni +'.jpg" class="mt-2 img-thumbnail">',
                icon: "success",
                allowOutsideClick: false
            });            
        }else{
            Swal.fire({
                title: "VERIFICACION DE DATOS!",
                text: 'NO EXISTE REGISTRO DE ALUMNO CON ESE NUMERO DE DNI',
                icon: "error"
            });   
        }


    }
    onMounted(() => {

    });
</script>
<style>
    .btn-custom {
        background-color: #28a745;
        color: #fff;
        border: 2px solid #28a745;
        font-size: 2rem;
        padding: 20px 40px;
        border-radius: 10px;
    }
    .btn-custom:hover {
        background-color: #218838;
        border-color: #218838;
    }
    .clockdate-wrapper {
        background-color: #333;
        padding:18px;
        max-width:510px;
        width:100%;
        text-align:center;
        border-radius:5px;
        margin:0 auto;
    }
    #clock, #date {
        font-family: 'Courier New', monospace;
        color: #fff;
    }
    #clock {
        font-size: 3.5rem;
        text-shadow: 0px 0px 2px #fff;
    }
    #date {
        font-size: 1.2rem;
        letter-spacing: 2px;
    }
</style>
<template>
    <div class="container mt-5">
        <div class="text-center mb-4"> 
            <a href="/"><img src="/juanbosco_logo.png" class="img-fluid img-thumbnail rounded-circle" alt=""></a>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1>VERIFICACION DE DATOS</h1>

                <form @submit.prevent="validar">
                    <div class="form-group mb-4">
                        <h2 class="h2" for="codigoPersonal">DNI del Personal:</h2>
                        <input type="text" v-model="form.numero_dni" class="form-control form-control-lg text-center"
                        style="font-size: 2.5rem; border: 3px solid #007bff;
                        border-radius: 10px;" id="codigoPersonal"
                        placeholder="Ingrese el numero de DNI">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-custom" title="Registrar"><i class="fas fa-check-circle"></i>VALIDAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>