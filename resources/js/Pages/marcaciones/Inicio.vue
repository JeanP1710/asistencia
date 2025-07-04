<script setup>
    import { ref, onMounted } from 'vue';
    import { defineTitle } from '@/Helpers';
    import useHelper from '@/Helpers';  
    import useMarcacion from '@/Composables/marcacion.js';
    import useSede from '@/Composables/sede.js';
    import usePrograma from '@/Composables/programa.js';    
    import { jwtDecode } from 'jwt-decode'
    const { openModal, Toast, Swal, formatoFecha } = useHelper();
    const {
        marcaciones, errors, grupo, respuesta,
        obtenerMarcacion, eliminarMarcacion, obtenerMarcacionesFiltros
    } = useMarcacion();
    const {
        listaSedes,
        sedes,
        obtenerSede,
        sede
    } = useSede();
    const {
        listaProgramas,
        programas
    } = usePrograma();    
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10,
    });
    const form=ref({
        sede_id:'',
        programa_id:'',
        ciclo:'',
        fecha:formatoFecha(null,'YYYY-MM-DD'),
        errors:[]
    })
    const buscarPorFiltro = async(page=1) => {
        dato.value.page= page
        await obtenerMarcacionesFiltros(dato.value, form.value)
    }    
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Grupo Menu",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminalo!'
        }).then((result) => {
            if (result.isConfirmed) {
                elimina(id)
            }
        })
    }
    const elimina = async(id) => {
        await eliminarMarcacion(id)
        if(respuesta.value.ok==1){
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarMarcaciones(marcaciones.value.current_page)
        }
    }
    // PAGINACION
    const isActived = () => {
        return marcaciones.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        buscarPorFiltro()
    }
    const cambiarPaginacion = () => {
        buscarPorFiltro()
    }
    const cambiarPagina =(pagina) => {
        buscarPorFiltro(pagina)
    }
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
    const copiarColumna = async () => {
        try {
            const datosColumna = marcaciones.value.data.map(marcacion => marcacion.alumno.apellido_paterno+ ' ' + marcacion.alumno.apellido_materno + ' ' + marcacion.alumno.nombres).join('\n');
            await navigator.clipboard.writeText(datosColumna);
            alert('APENOM copiados al portapapeles!');
        } catch (err) {
            console.error('Error al copiar al portapapeles: ', err);
        }
    };
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de Marcaciones
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2 mb-1">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Mostrar</span>
                            <select class="form-select"  v-model="dato.paginacion" @change="cambiarPaginacion">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Buscar</span>
                            <input class="form-control" placeholder="Ingrese nombre, DNI" type="text" v-model="dato.buscar"
                                @change="buscar" />
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
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
                <div class="row">
                    <div class="col-md-2">
                        <label for="sede_id" class="form-label">Sede </label>
                        <select class="form-select mb-3" v-model="form.sede_id" aria-label="">
                            <option v-for="sede in sedes" :key="sede.id" :value="sede.id"
                                :title="sede.nombre">
                                {{ sede.nombre }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in form.errors.sede_id" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="programa_id" class="form-label">Programa de Estudios </label>
                        <select class="form-select mb-3" v-model="form.programa_id" aria-label="">
                            <option selected="" value="" disabled>Todos</option>
                            <option v-for="programa in programas" :key="programa.id" :value="programa.id"
                                :title="programa.nombre">
                                {{ programa.nombre }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in form.errors.programa_id" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="ciclo" class="form-label">CICLO </label>
                        <select class="form-select mb-3" v-model="form.ciclo" aria-label="">
                            <option selected="" value="" disabled>Todos</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                            <option value="VI">VI</option>
                        </select>
                        <small class="text-danger" v-for="error in form.errors.ciclo" :key="error">{{ error }}<br></small>
                    </div>                    
                    <div class="col-md-2 mb-3">
                        <label for="fecha" class="form-label">Fecha </label>
                        <input type="date" class="form-control" v-model="form.fecha" :class="{ 'is-invalid': form.errors.fecha }">
                        <small class="text-danger" v-for="error in form.errors.fecha" :key="error">{{ error
                                }}</small>
                    </div>
                    <div class="col-md-2"><br>
                        <button class="btn btn-primary" @click="buscar">Buscar</button>
                    </div>
                    <div class="col-md-2"><br>
                        <button @click="copiarColumna" class="btn btn-primary mb-2">Copiar Apellidos Y Nombres</button>
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
                                        <th>PROGRAMA DE ESTUDIOS</th>
                                        <th>FECHA</th>
                                        <th>HORA</th>
                                        <th>SEDE</th>
                                        <th>TIPO</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="marcaciones.total == 0">
                                        <td class="text-danger text-center" colspan="7">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(marcacion,index) in marcaciones.data" :key="marcacion.id">
                                        <td>{{ index + marcaciones.from }}</td>
                                        <td>{{ marcacion.alumno.numero_dni }}</td>
                                        <td>{{ marcacion.alumno.apellido_paterno + ' ' + marcacion.alumno.apellido_materno + ' ' + marcacion.alumno.nombres }}</td>
                                        <td>{{ marcacion.alumno.programa.nombre }}</td>
                                        <td>{{ marcacion.fecha }}</td>
                                        <td>{{ marcacion.hora }}</td>
                                        <td>{{ marcacion.sede.nombre }}</td>
                                        <td>{{ marcacion.tipo }}</td>
                                        <td>
                                            <button class="btn btn-danger btn-sm"
                                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;" title="Enviar a Papelera" @click.prevent="eliminar(marcacion.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>&nbsp;

                                        </td>
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