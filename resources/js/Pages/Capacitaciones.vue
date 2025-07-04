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
<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8 justify-content-between align-items-center">
                        <h3 class="card-title">BUSQUEDA PARTICIPANTE CAPACITACIONES</h3>
                    </div>
                </div>
            </div>
            <div class="card-body" style="min-height: 500px;">
                <div class="row">
                    <div class="col mb-2">
                        <div class="input-group mb-1"><span class="input-group-text" id="basic-addon1">Participante</span><input class="form-control" placeholder="Ingrese nombre or DNI" type="text"
                            v-model="dato.buscar" @change="buscar"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="4" class="text-center">Personas</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>Nombre Completo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="personas.total == 0">
                                        <td class="text-danger text-center" colspan="4">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(persona,index) in personas.data" :key="persona.id">
                                        <td>{{ index + personas.from }}</td>
                                        <td>{{ persona.dni }}</td>
                                        <td>{{ persona.ape_paterno + ' ' + persona.ape_materno + ' ' + persona.nombres }}</td>
                                        <td>
                                            <button class="btn btn-info btn-sm" title="Ver Registros" @click.prevent="mostrarRegistros(persona.id)">
                                                <i class="fas fa-eye"></i>
                                            </button>&nbsp;    
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>         
    </div>
    <RegistrosForm :registros="certificados"></RegistrosForm>
</template>