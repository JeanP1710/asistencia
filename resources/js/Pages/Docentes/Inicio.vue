<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import useDocente from '@/Composables/Docente.js';
  import DocenteForm from './Form.vue'
  import useProfesion from '@/Composables/Profesion.js';    
  const { openModal, Toast, Swal, formatoFecha } = useHelper();
  const {
        docentes, errors, docente, respuesta,
        obtenerDocentes, obtenerDocente, eliminarDocente,
        cambiarEstado
    } = useDocente();
    const {
        listaProfesiones,
        profesiones
    } = useProfesion(); 
    const anios = ref([]);
    const listarAnios=()=>{
        const anioActual=anho
        for (let index = anioActual; index >= anioActual - 4; index--) {
            anios.value.push(index);
        }
    }
    const titleHeader = ref({
      titulo: "Docente",
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
        profesion_id:'',
        errors:[]
    })
    const form = ref({
        id:'',
        numero_dni : '',
        apellido_paterno : '',
        apellido_materno : '',
        nombres : '',
        profesion_id : '',
        estadoCrud:'',
        errors:[]
    });
    const limpiar = ()=> {
        form.value.id='',
        form.value.codigo='',
        form.value.numero_dni='',
        form.value.apellido_paterno='',
        form.value.apellido_materno='',
        form.value.nombres='',
        form.value.profesion_id='',
        form.value.estadoCrud = '',          
        form.value.errors = []
        errors.value = []
    }
    const obtenerDatos = async(id) => {
        await obtenerDocente(id);
        if(docente.value)
        {
            form.value.id=docente.value.id;
            form.value.codigo=docente.value.codigo;
            form.value.numero_dni=docente.value.numero_dni;
            form.value.apellido_paterno=docente.value.apellido_paterno;
            form.value.apellido_materno=docente.value.apellido_materno;
            form.value.nombres=docente.value.nombres;
            form.value.profesion_id=docente.value.profesion_id;
        }
    }
    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modaldocenteLabel").innerHTML = 'Editar Docente';
        openModal('#modaldocente')
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modaldocente')
        document.getElementById("modaldocenteLabel").innerHTML = 'Nuevo Docente';
        //titulo.textContent = 'Editar Datos Personales';
    }
    const listarDocentes = async(page=1) => {
        dato.value.page= page
        await obtenerDocentes(dato.value, datoBuscar.value)
    }
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "Docente",
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
        await eliminarDocente(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarDocentes(docentes.value.current_page)
        }
    }
    // PAGINACION
    const isActived = () => {
        return docentes.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarDocentes()
    }
    const cambiarPaginacion = () => {
        listarDocentes()
    }
    const cambiarPagina =(pagina) => {
        listarDocentes(pagina)
    }
    const cambEstado= async(id)=>{
        await cambiarEstado(id)
        if(respuesta.value.ok==1){
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarDocentes()
        }
    }
    const pagesNumber = () => {
        if(!docentes.value.to){
            return []
        }
        let from = docentes.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= docentes.value.last_page) to = docentes.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
        listarDocentes()
        listaProfesiones()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de docentes
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
                                <li v-if="docentes.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="docentes.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(docentes.current_page - 1)">
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
                                <li v-if="docentes.current_page < docentes.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(docentes.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="docentes.current_page <= docentes.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(docentes.last_page)"
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
                        <label for="profesion_id" class="form-label">Profesion </label>
                        <select class="form-select mb-3" v-model="datoBuscar.profesion_id" aria-label="">
                            <option selected="" value="" disabled>Todos</option>
                            <option v-for="profesion in profesiones" :key="profesion.id" :value="profesion.id"
                                :title="profesion.descripcion">
                                {{ profesion.descripcion }}
                            </option>
                        </select>
                        <small class="text-danger" v-for="error in datoBuscar.errors.profesion_id" :key="error">{{ error }}<br></small>
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
                                        <th colspan="13" class="text-center">Docentes</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>CODIGO</th>
                                        <th>DNI</th>
                                        <th>Apellido Paterno</th>
                                        <th>Apellido Materno</th>
                                        <th>Nombre</th>
                                        <th>Foto</th>
                                        <th>Profesion</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="docentes.total == 0">
                                        <td class="text-danger text-center" colspan="13">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(docente,index) in docentes.data" :class="{ 'table-danger': docente.deudas_count >= 1 }" :key="docente.id">
                                        <td>{{ index + docentes.from }}</td>
                                        <td>{{ docente.codigo }}</td>
                                        <td>{{ docente.numero_dni }}</td>
                                        <td>{{ docente.apellido_paterno }}</td>
                                        <td>{{ docente.apellido_materno }}</td>
                                        <td>{{ docente.nombres }}</td>
                                        <td>
                                            <div class="avatar avatar-xl"><img class="rounded-circle" :src="'storage/docentes/'+docente.numero_dni+'.jpg'" alt=""></div>
                                        </td>
                                        <td>{{ docente.profesion.descripcion }}</td>
                                        <td>
                                            <span
                                                :class="{'badge bg-success': docente.es_activo === 1, 'badge bg-secondary': docente.es_activo !== 1}"
                                                @click="cambEstado(docente.id)"
                                                style="cursor: pointer;"
                                                title="Cambiar Estado" >
                                                {{ docente.es_activo === 1 ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="editar(docente.id)">
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
                        Mostrando <b>{{docentes.from}}</b> a <b>{{ docentes.to }}</b> de <b>{{ docentes.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="docentes.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="docentes.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(docentes.current_page - 1)">

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
                                <li v-if="docentes.current_page < docentes.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(docentes.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="docentes.current_page <= docentes.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(docentes.last_page)"
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
    <DocenteForm :form="form" :profesiones="profesiones" @onListar="listarDocentes" :currentPage="docentes.current_page"></DocenteForm>
</template>