<script setup>
    import { ref, onMounted } from 'vue';
    import { defineTitle } from '@/Helpers';
    import useHelper from '@/Helpers';  
    import usePersonal from '@/Composables/Personal.js';
    import JsonExcel from 'vue-json-excel3';
    import useTipoTrabajador from '@/Composables/TipoTrabajador.js';    
    const {
        personals, personalsPorFiltros, errors
    } = usePersonal();
    const {
        listaTipoTrabajadores,
        tipoTrabajadores
    } = useTipoTrabajador();
    const jsonFields = ref({
        "DNI" : "numero_dni",
        "Apellido Paterno": "apellido_paterno",
        "Apellido Materno": "apellido_materno",
        "Nombres": "nombres",
        "Programa de Estudios": "programa.nombre",
        "Ciclo": "ciclo_academico",
        "Turno": "turno",
        "Seccion": "seccion"
    })
    const dato = ref({
        programa_id: '',
        ciclo: '',
        turno:'',
        seccion:'',
        debe: '',
        errors:[]
    });
    const LoadState=ref(false);
    const cargar=async()=>{
        dato.value.errors = []
        await personalsPorFiltros(dato.value)
        LoadState.value=true
        if(errors.value)
        {
            dato.value.errors = errors.value
        }
    }
    onMounted(() => {
        listaTipoTrabajadores()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Reporte de Personals
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="programa_id" class="form-label">Programa de Estudios</label>
                        <select class="form-select" v-model="dato.programa_id" aria-label="" :class="{ 'is-invalid': dato.errors.programa_id }">
                            <option selected="" value="" disabled>Todos</option>
                            <option v-for="programa in tipoTrabajadores" :key="programa.id" :value="programa.id"
                                :title="programa.nombre">
                                {{ programa.nombre }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in dato.errors.programa_id" :key="error">{{ error }}</small>
                    </div>
                    <div class="col-md-2">
                        <label for="ciclo" class="form-label">CICLO </label>
                        <select class="form-select mb-3" v-model="dato.ciclo" aria-label="">
                            <option selected="" value="" disabled>Todos</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                            <option value="VI">VI</option>
                        </select>
                        <small class="text-danger" v-for="error in dato.errors.ciclo" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="turno" class="form-label">TURNO </label>
                        <select class="form-select mb-3" v-model="dato.turno" aria-label="">
                            <option selected="" value="" disabled>Todos</option>
                            <option value="Mañana">Mañana</option>
                            <option value="Tarde">Tarde</option>
                        </select>
                        <small class="text-danger" v-for="error in dato.errors.ciclo" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="seccion" class="form-label">SECCION </label>
                        <select class="form-select mb-3" v-model="dato.seccion" aria-label="">
                            <option selected="" value="" disabled>Todos</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                        <small class="text-danger" v-for="error in dato.errors.ciclo" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="name" class="form-label">Debe</label>
                        <select v-model="dato.debe" class="form-control"
                            :class="{ 'is-invalid': dato.errors.debe }">
                            <option value="" disabled>Todos</option>
                            <option value="1" title="Debe">Debe</option>
                            <option value="0" title="No Debe">No Debe</option>
                        </select>
                    </div>                   
                    <div class="col-md-3 mb-1"><br>
                        <button class="btn btn-primary" @click="cargar()">
                            Cargar
                        </button>&nbsp;
                        <JsonExcel v-if="LoadState" class="btn btn-success" :fields="jsonFields" :data="alumnos">
                            <i class="fa-solid fa-file-excel"></i> Descargar
                        </JsonExcel>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12 mb-1 small">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="11" class="text-center">alumnos</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        <th>Nombre</th>
                                        <th>Programa de Estudios</th>
                                        <th>Ciclo</th>
                                        <th>Debe</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="alumnos.length == 0">
                                        <td class="text-danger text-center" colspan="11">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(alumno,index) in alumnos" :key="alumno.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ alumno.numero_dni }}</td>
                                        <td>{{ alumno.apellido_paterno }}</td>
                                        <td>{{ alumno.apellido_materno }}</td>
                                        <td>{{ alumno.nombres }}</td>
                                        <td>{{ alumno.programa.nombre }}</td>
                                        <td>{{ alumno.ciclo_academico }}</td>
                                        <td>{{ alumno.deudas_count == 0 ? 'NO' : 'SI' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>