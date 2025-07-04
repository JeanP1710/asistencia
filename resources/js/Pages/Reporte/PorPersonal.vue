<script setup>
    import { ref, onMounted } from 'vue';
    import { defineTitle } from '@/Helpers';
    import useHelper from '@/Helpers';  
    import useMarcacion from '@/Composables/marcacion.js';
    import JsonExcel from 'vue-json-excel3';
    const {
        marcaciones, errors, grupo, respuesta,
        obtenerMarcaciones, obtenerMarcacion, obtenerMarcacionesReporte, eliminarGrupo
    } = useMarcacion();

    const { openModal, Toast, Swal, formatoFecha, meses } = useHelper();
    const anios = ref([]);
    const listarAnios=()=>{
        const anioActual=parseInt(formatoFecha(null,"YYYY"))
        for (let index = anioActual; index >= anioActual - 4; index--) {
            anios.value.push(index);
        }
    }
    
    const jsonFields = ref({
        "DNI" : "numero_dni",
        "Apellidos y Nombres": "apenom",
        "Tipo de Trabajador": "tipo_trabajador",
        "Fecha": "fecha",
        "Hora": "hora",
        "Tipo":"tipo",
    })
    const dato = ref({
        dni:'',
        sede_id: '',
        anho:formatoFecha(null,'YYYY'),
        mes:parseInt(formatoFecha(null,'MM')),
        errors:[]
    });
    const LoadState=ref(false);
    const cargar=async()=>{
        dato.value.errors = []
        await obtenerMarcacionesReporte(dato.value)
        LoadState.value=true
        // if(marcaciones.value){
        //     total.value = 0
        //     marcaciones.value.forEach(m => {
        //         total.value += (m.diferencia_entrada ?? 0)
        //     });
        // }
        // if(errors.value)
        // {
        //     dato.value.errors = errors.value
        // }
    }
    // PAGINACION
    const isActived = () => {
        return marcaciones.value.current_page
    }
    const offset = 2;

    const pagesNumber = () => {
        if(!marcaciones.value.to){
            return []
        }
        let from = marcaciones.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= marcaciones.value.last_page) to = marcaciones.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    // CARGA
    onMounted(() => {
        listaSedes()
        listarAnios()

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
                    <div class="col-md-3">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">DNI</span>
                            <input class="form-control" placeholder="Ingrese DNI" type="text" v-model="dato.dni"
                                @change="buscar" :class="{ 'is-invalid': dato.errors.dni }" />
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.dni" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select mb-3" v-model="dato.sede_id" aria-label="">
                            <option selected="" value="" disabled>Sede</option>
                            <option v-for="sede in sedes" :key="sede.id" :value="sede.id"
                                :title="sede.nombre">
                                {{ sede.nombre }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in dato.errors.sede_id" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2 mb-1">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Mes</span>
                            <select v-model="dato.mes" class="form-control" :class="{ 'is-invalid': dato.errors.mes }">
                                <option v-for="mes in meses" :key="mes.numero" :value="mes.numero">
                                    {{ mes.nombre }}
                                </option>
                            </select>
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.mes" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2 mb-1">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Año</span>
                            <select v-model="dato.anho" class="form-control"
                            :class="{ 'is-invalid': dato.errors.anho }">
                                <option v-for="anho in anios" :key="anho" :value="anho"
                                    :title="anho">
                                    {{ anho }}
                                </option>
                            </select>
                        </div>
                        <small class="text-danger" v-for="error in dato.errors.mes" :key="error">{{ error
                                }}<br></small>
                    </div>     
                    <div class="col-md-3 mb-1">
                        <button class="btn btn-primary" @click="cargar()">
                            Cargar
                        </button>&nbsp;
                        <JsonExcel v-if="LoadState" class="btn btn-success" :fields="jsonFields" :data="marcaciones">
                            <i class="fa-solid fa-file-excel"></i> Descargar
                        </JsonExcel>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="9" class="text-center">Marcaciones</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>APENOM</th>
                                        <th>PROGRAMA</th>
                                        <th>CICLO</th>
                                        <th>FECHA</th>
                                        <th>MARCO</th>
                                        <th>SEDE</th>
                                        <th>TIPO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="marcaciones.length == 0">
                                        <td class="text-danger text-center" colspan="7">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(marcacion,index) in marcaciones" :key="marcacion.id">
                                        <td>{{ index+1 }}</td>
                                        <td>{{ marcacion.numero_dni }}</td>
                                        <td>{{ marcacion.apenom }}</td>
                                        <td>{{ marcacion.programa }}</td>
                                        <td>{{ marcacion.ciclo }}</td>
                                        <td>{{ marcacion.fecha }}</td>
                                        <td>{{ marcacion.hora }}</td>
                                        <td>{{ marcacion.sede }}</td>
                                        <td>{{ marcacion.tipo }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-1">
                        Mostrando <b>{{marcaciones.from}}</b> a <b>{{ marcaciones.to }}</b> de <b>{{ marcaciones.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="marcaciones.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="marcaciones.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(marcaciones.current_page - 1)">

                                        <span><i class="fas fa-angle-left"></i></span>
                                    </a>
                                </li>
                                <li v-for="page in pagesNumber()" class="page-item"
                                    :key="page"
                                    :class="[ page == isActived() ? 'active' : '']"
                                    :title="'Página '+ page">
                                    <a href="#" class="page-link"
                                        @click.prevent="cambiarPagina(page)">{{ page }}</a>
                                </li>
                                <li v-if="marcaciones.current_page < marcaciones.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(marcaciones.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="marcaciones.current_page <= marcaciones.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(marcaciones.last_page)"
                                        title="Última Página">
                                        <span aria-hidden="true"><i class="fas fa-step-forward"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>