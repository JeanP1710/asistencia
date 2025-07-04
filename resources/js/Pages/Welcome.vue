<script setup>
    import { ref, onMounted } from 'vue';
    import usePersona from '@/Composables/Persona.js';
    import useHelper from '@/Helpers';  
    import RegistrosForm from './Registros.vue'
    import useCertificado from '@/Composables/Certificado.js';
    const { openModal} = useHelper();
    const {
        personas, persona,
        obtenerPersonas, obtenerPersona
    } = usePersona();
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const {
        listaCertificados, certificados
    } = useCertificado();
    const listarPersonas = async(page=1) => {
        dato.value.page= page
        await obtenerPersonas(dato.value)
    }
    const buscar = () => {
        listarPersonas()
    }
    const mostrarRegistros = async(id)=>{
        await listaCertificados(id)
        document.getElementById("modalregistrosLabel").innerHTML = 'Lista de Certificados';
        openModal('#modalregistros')
    }
</script>
<style>
    .img-circle {
        border-radius: 50%;
    }
</style>
<template>
    <div class="content">
        <div class="container mt-6">
            <div class="text-center mb-6">
                <a href="https://institutosales.edu.pe/" class="btn btn-default p-2">
                    <img src="eslogan.png" class="img-fluid" width="600" alt="">
                </a>
            </div>
            <div class="card mb-3">
                <div class="card-body px-xxl-0 pt-4">
                    <div class="row g-0">
                        <!-- Botón Asistencia -->
                        <div class="col-md-6 px-3 text-center border-end-xxl border-bottom border-bottom-xxl-0 pb-3 pt-4 pt-md-0 pe-md-0 p-xxl-0">
                            <a href="/asistencia" class="text-decoration-none">
                                <div class="icon-circle icon-circle-info">
                                    <span class="fs-2 fas fa-chalkboard-teacher text-info"></span>
                                </div>
                                <h4 class="mb-1 font-sans-serif">
                                    <span class="fw-normal text-600">Asistencia</span>
                                </h4>
                            </a>
                        </div>

                        <!-- Botón SocioEconomico -->
                        <div class="col-md-6 px-3 text-center border-end-xxl border-bottom border-bottom-xxl-0 pb-3 pt-4 pt-md-0 pe-md-0 p-xxl-0">
                            <a href="/ficha-socio" class="text-decoration-none">
                                <div class="icon-circle icon-circle-warning">
                                    <span class="fs-2 fas fa-book-open text-warning"></span>
                                </div>
                                <h4 class="mb-1 font-sans-serif">
                                    <span class="fw-normal text-600">Socio Economico</span>
                                </h4>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
                
        </div>
    </div>
    
</template>

