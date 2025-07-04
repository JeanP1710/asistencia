<script setup>
    import { ref, onMounted } from 'vue';
    import useHelper from '@/Helpers';  
    import useMarcacion from '@/Composables/marcacion.js';
    import useSede from '@/Composables/sede.js';
    import JsonExcel from 'vue-json-excel3';
    import usePrograma from '@/Composables/programa.js';    
    const {
        registros, errors, grupo, respuesta,
        obtenerMarcaciones, obtenerMarcacion, obtenerMarcacionesMensual, eliminarGrupo
    } = useMarcacion();
    const {
        listaProgramas,
        programas
    } = usePrograma();    
    const { diaMaxMes, formatoFecha, meses } = useHelper();
    const {
        listaSedes,
        sedes
    } = useSede();
    const anios = ref([]);
    const jsonFields = ref({
        "DNI" : "numero_dni",
        "Apellidos y Nombres": "nombre_completo",
        "Programa de Estudios": "programa",
        "Ciclo": "ciclo_academico",
        "Turno" : "turno",
        "Seccion" : "seccion",
        "DIA 1": "dia_1",
        "DIA 2": "dia_2",
        "DIA 3": "dia_3",
        "DIA 4": "dia_4",
        "DIA 5": "dia_5",
        "DIA 6": "dia_6",
        "DIA 7": "dia_7",
        "DIA 8": "dia_8",
        "DIA 9": "dia_9",
        "DIA 10": "dia_10",
        "DIA 11": "dia_11",
        "DIA 12": "dia_12",
        "DIA 13": "dia_13",
        "DIA 14": "dia_14",
        "DIA 15": "dia_15",
        "DIA 16": "dia_16",
        "DIA 17": "dia_17",
        "DIA 18": "dia_18",
        "DIA 19": "dia_19",
        "DIA 20": "dia_20",
        "DIA 21": "dia_21",
        "DIA 22": "dia_22",
        "DIA 23": "dia_23",
        "DIA 24": "dia_24",
        "DIA 25": "dia_25",
        "DIA 26": "dia_26",
        "DIA 27": "dia_27",
        "DIA 28": "dia_28",
        "DIA 29": "dia_29",
        "DIA 30": "dia_30",
        "DIA 31": "dia_31",
    })
    let anho = parseInt(formatoFecha(null,'YYYY'));
    let mes = parseInt(formatoFecha(null,'MM'));
    const listarAnios=()=>{
        const anioActual=anho
        for (let index = anioActual; index >= anioActual - 4; index--) {
            anios.value.push(index);
        }
    }
    const dato = ref({
        programa_id: '',
        ciclo: '',
        turno: '',
        seccion: '',
        mes: mes,
        anho: anho,
        desde: 1,
        hasta : diaMaxMes(anho, mes),
        errors:[]
    });
    const mesCambiado=()=>{
        dato.value.hasta = diaMaxMes(anho, dato.value.mes);
    }
    const LoadState=ref(false);
    const cargar=async()=>{
        dato.value.errors = []
        await obtenerMarcacionesMensual(dato.value)
        LoadState.value=true
        if(errors.value)
        {
            dato.value.errors = errors.value
        }
    }
    const existeDia=(dia)=>{
        const respuesta = registros.value.diasDelMes.find(dm => dm.dia===dia);
        return respuesta;
    }
    onMounted(() => {
        listaSedes()
        listarAnios()
        listaProgramas()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Reporte de Marcaciones
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-3">
                        <label for="programa_id" class="form-label">Programa de Estudios</label>
                        <select class="form-select" v-model="dato.programa_id" aria-label="" :class="{ 'is-invalid': dato.errors.programa_id }">
                            <option selected="" value="" disabled>Todos</option>
                            <option v-for="programa in programas" :key="programa.id" :value="programa.id"
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
                        <label for="name" class="form-label">Mes</label>
                        <select v-model="dato.mes" class="form-control"
                            :class="{ 'is-invalid': dato.errors.mes }" @change="mesCambiado()">
                            <option v-for="mes in meses" :key="mes.numero" :value="mes.numero"
                                :title="mes.nombre">
                                {{ mes.nombre }}
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="anio" class="form-label">Año</label>
                        <select v-model="dato.anho" class="form-control"
                            :class="{ 'is-invalid': dato.errors.anho }">
                            <option v-for="anho in anios" :key="anho" :value="anho"
                                :title="anho">
                                {{ anho }}
                            </option>
                        </select>
                    </div>                      
                    <div class="col-md-1 mb-3">
                        <label for="fecha" class="form-label">DESDE </label>
                        <input type="number" class="form-control" v-model="dato.desde" :class="{ 'is-invalid': dato.errors.desde }" :min="1" :max="dato.hasta">
                        <small class="text-danger" v-for="error in dato.errors.desde" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="col-md-1 mb-3">
                        <label for="fecha" class="form-label">HASTA </label>
                        <input type="number" class="form-control" v-model="dato.hasta" :class="{ 'is-invalid': dato.errors.hasta }" :min="1" :max="31">
                        <small class="text-danger" v-for="error in dato.errors.hasta" :key="error">{{ error
                                }}</small>
                    </div>                    
                    <div class="col-md-3 mb-1">
                        <button class="btn btn-primary" @click="cargar()">
                            Cargar
                        </button>&nbsp;
                        <JsonExcel v-if="LoadState" class="btn btn-success" :fields="jsonFields" :data="registros.alumnos">
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
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>APENOM</th>
                                        <th>PROGRAMA</th>
                                        <th>CICLO</th>
                                        <th>TURNO</th>
                                        <th>SECCION</th>
                                        <template v-for="dia in registros.diasDelMes">
                                            <th class="tex-center">
                                                {{ dia.dia }}<br>
                                                {{ dia.nombreDia }}
                                            </th>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="registros.alumnos?.length == 0">
                                        <td class="text-danger text-center" colspan="12">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(marcacion,index) in registros.alumnos" :key="marcacion.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ marcacion.numero_dni }}</td>
                                        <td>{{ marcacion.nombre_completo }}</td>
                                        <td>{{ marcacion.programa }}</td>
                                        <td>{{ marcacion.ciclo_academico }}</td>
                                        <td>{{ marcacion.turno }}</td>
                                        <td>{{ marcacion.seccion }}</td>
                                        <td v-if="existeDia(1)">{{ marcacion.dia_1 }}</td>
                                        <td v-if="existeDia(2)">{{ marcacion.dia_2 }}</td>
                                        <td v-if="existeDia(3)">{{ marcacion.dia_3 }}</td>
                                        <td v-if="existeDia(4)">{{ marcacion.dia_4 }}</td>
                                        <td v-if="existeDia(5)">{{ marcacion.dia_5 }}</td>
                                        <td v-if="existeDia(6)">{{ marcacion.dia_6 }}</td>
                                        <td v-if="existeDia(7)">{{ marcacion.dia_7 }}</td>
                                        <td v-if="existeDia(8)">{{ marcacion.dia_8 }}</td>
                                        <td v-if="existeDia(9)">{{ marcacion.dia_9 }}</td>
                                        <td v-if="existeDia(10)">{{ marcacion.dia_10 }}</td>
                                        <td v-if="existeDia(11)">{{ marcacion.dia_11 }}</td>
                                        <td v-if="existeDia(12)">{{ marcacion.dia_12 }}</td>
                                        <td v-if="existeDia(13)">{{ marcacion.dia_13 }}</td>
                                        <td v-if="existeDia(14)">{{ marcacion.dia_14 }}</td>
                                        <td v-if="existeDia(15)">{{ marcacion.dia_15 }}</td>
                                        <td v-if="existeDia(16)">{{ marcacion.dia_16 }}</td>
                                        <td v-if="existeDia(17)">{{ marcacion.dia_17 }}</td>
                                        <td v-if="existeDia(18)">{{ marcacion.dia_18 }}</td>
                                        <td v-if="existeDia(19)">{{ marcacion.dia_19 }}</td>
                                        <td v-if="existeDia(20)">{{ marcacion.dia_20 }}</td>
                                        <td v-if="existeDia(21)">{{ marcacion.dia_21 }}</td>
                                        <td v-if="existeDia(22)">{{ marcacion.dia_22 }}</td>
                                        <td v-if="existeDia(23)">{{ marcacion.dia_23 }}</td>
                                        <td v-if="existeDia(24)">{{ marcacion.dia_24 }}</td>
                                        <td v-if="existeDia(25)">{{ marcacion.dia_25 }}</td>
                                        <td v-if="existeDia(26)">{{ marcacion.dia_26 }}</td>
                                        <td v-if="existeDia(27)">{{ marcacion.dia_27 }}</td>
                                        <td v-if="existeDia(28)">{{ marcacion.dia_28 }}</td>
                                        <td v-if="existeDia(29)">{{ marcacion.dia_29 }}</td>
                                        <td v-if="existeDia(30)">{{ marcacion.dia_30 }}</td>
                                        <td v-if="existeDia(31)">{{ marcacion.dia_31 }}</td>
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