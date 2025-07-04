<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import usePersonal from '@/Composables/Personal.js';
  import useTipoTrabajador from '@/Composables/TipoTrabajador.js';    
  const { openModal, Toast, Swal, formatoFecha } = useHelper();
  const {
        personals, errors, personal, respuesta,
        obtenerPersonals, obtenerPersonal, eliminarPersonal,
        cambiarEstado, cambiarEstadoDeuda
    } = usePersonal();
    const {
        listaTipoTrabajadores,
        tipoTrabajadores
    } = useTipoTrabajador();
    let mes = parseInt(formatoFecha(null,'MM'));
    let anho = parseInt(formatoFecha(null,'YYYY'));

    const titleHeader = ref({
      titulo: "Personal",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const datoBuscar=ref({
        programa_id:'',
        ciclo:'',
        turno:'',
        seccion:'',
        errors:[]
    })
    const form = ref({
        id:'',
        numero_dni : '',
        apellido_paterno : '',
        apellido_materno : '',
        nombres : '',
        programa_id : '',
        ciclo_academico : '',  
        turno:'',
        seccion:'',
        estadoCrud:'',
        errors:[]
    });
    const limpiar = ()=> {
        form.value.id='',
        form.value.numero_dni='',
        form.value.apellido_paterno='',
        form.value.apellido_materno='',
        form.value.nombres='',
        form.value.programa_id='',
        form.value.ciclo_academico= '',
        form.value.turno= '',
        form.value.seccion= '',
        form.value.estadoCrud = '',          
        form.value.errors = []
        errors.value = []
    }
    const obtenerDatos = async(id) => {
        await obtenerPersonal(id);
        if(personal.value)
        {
            form.value.id=personal.value.id;
            form.value.numero_dni=personal.value.numero_dni;
            form.value.apellido_paterno=personal.value.apellido_paterno;
            form.value.apellido_materno=personal.value.apellido_materno;
            form.value.nombres=personal.value.nombres;
            form.value.programa_id=personal.value.programa_id;
            form.value.ciclo_academico= personal.value.ciclo_academico;
            form.value.turno= personal.value.turno;
            form.value.seccion= personal.value.seccion;  
        }
    }
    const cambEstado= async(id)=>{
        await cambiarEstado(id)
        if(respuesta.value.ok==1){
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarPersonal()
        }
    }
    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modalpersonalLabel").innerHTML = 'Editar personal';
        openModal('#modalpersonal')
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modalPersonal')
        document.getElementById("modalPersonalLabel").innerHTML = 'Nuevo Personal';
        //titulo.textContent = 'Editar Datos Personales';
    }
    const listarPersonal = async(page=1) => {
        dato.value.page= page
        await obtenerPersonals(dato.value, datoBuscar.value)
    }
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "personal",
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
        await eliminarPersonal(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarPersonals(personal.value.current_page)
        }
    }
    // PAGINACION
    const isActived = () => {
        return personal.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarPersonals()
    }
    const cambiarPaginacion = () => {
        listarPersonals()
    }
    const cambiarPagina =(pagina) => {
        listarPersonals(pagina)
    }
    const pagesNumber = () => {
        if(!personal.value.to){
            return []
        }
        let from = personal.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= personal.value.last_page) to = personal.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    const estadoDeuda=ref({
        'id':'',
        'debe':''
    });
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
        listarAlumnos()
        listaProgramas()
        listarAnios()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de Alumnos
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1 mb-1">
                        <button  type="button" class="btn btn-danger" @click.prevent="nuevo">
                            <i class="fas fa-plus"></i> Nuevo
                        </button>                        
                    </div>
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
                    <div class="col-md-5">
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Buscar</span>
                            <input class="form-control" placeholder="Ingrese nombre, DNI" type="text" v-model="dato.buscar"
                                @change="buscar" />
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <nav>
                            <ul class="pagination">
                                <li v-if="alumnos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="alumnos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(alumnos.current_page - 1)">
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
                                <li v-if="alumnos.current_page < alumnos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(alumnos.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="alumnos.current_page <= alumnos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(alumnos.last_page)"
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
                        <label for="programa_id" class="form-label">Programa de Estudios </label>
                        <select class="form-select mb-3" v-model="datoBuscar.programa_id" aria-label="">
                            <option selected="" value="" disabled>Todos</option>
                            <option v-for="programa in programas" :key="programa.id" :value="programa.id"
                                :title="programa.nombre">
                                {{ programa.nombre }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in datoBuscar.errors.programa_id" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="ciclo" class="form-label">CICLO </label>
                        <select class="form-select mb-3" v-model="datoBuscar.ciclo" aria-label="">
                            <option selected="" value="" disabled>Todos</option>
                            <option value="I">I</option>
                            <option value="II">II</option>
                            <option value="III">III</option>
                            <option value="IV">IV</option>
                            <option value="V">V</option>
                            <option value="VI">VI</option>
                        </select>
                        <small class="text-danger" v-for="error in datoBuscar.errors.ciclo" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="turno" class="form-label">TURNO </label>
                        <select class="form-select mb-3" v-model="datoBuscar.turno" aria-label="">
                            <option selected="" value="" disabled>Todos</option>
                            <option value="Mañana">Mañana</option>
                            <option value="Tarde">Tarde</option>
                        </select>
                        <small class="text-danger" v-for="error in datoBuscar.errors.turno" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2">
                        <label for="seccion" class="form-label">SECCION </label>
                        <select class="form-select mb-3" v-model="datoBuscar.seccion" aria-label="">
                            <option selected="" value="" disabled>Todos</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                        <small class="text-danger" v-for="error in datoBuscar.errors.seccion" :key="error">{{ error }}<br></small>
                    </div>
                    <div class="col-md-2"><br>
                        <button class="btn btn-primary" @click="buscar">Buscar</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="13" class="text-center">alumnos</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        <th>Nombre</th>
                                        <th>Foto</th>
                                        <th>Programa de Estudios</th>
                                        <th>Ciclo</th>
                                        <th>Turno</th>
                                        <th>Seccion</th>
                                        <th>Ver Deudas</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="alumnos.total == 0">
                                        <td class="text-danger text-center" colspan="13">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(alumno,index) in alumnos.data" :class="{ 'table-danger': alumno.deudas_count >= 1 }" :key="alumno.id">
                                        <td>{{ index + alumnos.from }}</td>
                                        <td>{{ alumno.numero_dni }}</td>
                                        <td>{{ alumno.apellido_paterno }}</td>
                                        <td>{{ alumno.apellido_materno }}</td>
                                        <td>{{ alumno.nombres }}</td>
                                        <td>
                                            <div class="avatar avatar-xl"><img class="rounded-circle" :src="'storage/alumnos/'+alumno.numero_dni+'.jpg'" alt=""></div>
                                        </td>
                                        <td>{{ alumno.programa.nombre }}</td>
                                        <td>{{ alumno.ciclo_academico }}</td>
                                        <td>{{ alumno.turno }}</td>
                                        <td>{{ alumno.seccion }}</td>
                                        <td>
                                            <!-- <div class="form-check form-switch">
                                                <input class="form-check-input" :id="'debeinput'+index" type="checkbox" :checked="alumno.debe==1" @change="guardarSiDebe(alumno)" />
                                                <label class="form-check-label" :for="'debeinput'+index">{{ alumno.debe==0 ? 'NO' : 'SI' }}</label>
                                            </div> -->
                                            <a href="" title="Ver Deudas" @click.prevent="verDeudas(alumno.id)">
                                                <span class="fa-solid fa-eye"></span>
                                                {{ alumno.deudas_count }}
                                            </a>
                                            
                                        </td>
                                        <td>
                                            <span
                                                :class="{'badge bg-success': alumno.es_activo === 1, 'badge bg-secondary': alumno.es_activo !== 1}"
                                                @click="cambEstado(alumno.id)"
                                                style="cursor: pointer;"
                                                title="Cambiar Estado" >
                                                {{ alumno.es_activo === 1 ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="editar(alumno.id)">
                                                <i class="fas fa-edit"></i>
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
                        Mostrando <b>{{alumnos.from}}</b> a <b>{{ alumnos.to }}</b> de <b>{{ alumnos.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="alumnos.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="alumnos.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(alumnos.current_page - 1)">

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
                                <li v-if="alumnos.current_page < alumnos.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(alumnos.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="alumnos.current_page <= alumnos.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(alumnos.last_page)"
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
    <AlumnoForm :form="form" @onListar="listarAlumnos" :currentPage="alumnos.current_page"></AlumnoForm>
</template>