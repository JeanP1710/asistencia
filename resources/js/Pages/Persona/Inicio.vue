<script setup>
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import usePersona from '@/Composables/Persona.js';
  import useCertificado from '@/Composables/Certificado.js';
  import PersonaForm from './Form.vue'
  import RegistrosForm from './Registros.vue'
  const { openModal, Toast, Swal, formatoFecha } = useHelper();
  const {
        personas, errors, persona, respuesta,
        obtenerPersonas, obtenerPersona, eliminarPersona
    } = usePersona();
    const {
        listaCertificados, certificados
    } = useCertificado();
    const titleHeader = ref({
      titulo: "Personas",
      subTitulo: "Inicio",
      icon: "",
      vista: ""
    });
    const dato = ref({
        page:'',
        buscar:'',
        paginacion: 10
    });
    const form = ref({
        id:'',
        dni : '',
        ape_paterno : '',
        ape_materno : '',
        nombres : '',
        tipo : '',
        estadoCrud:'',
        errors:[]
    });
    const limpiar = ()=> {
        form.value.id='',
        form.value.dni='',
        form.value.ape_paterno='',
        form.value.ape_materno='',
        form.value.nombres='',
        form.value.tipo='',
        form.value.estadoCrud = '',          
        form.value.errors = []
        errors.value = []
    }
    const obtenerDatos = async(id) => {
        await obtenerPersona(id);
        if(persona.value)
        {
            form.value.id=persona.value.id;
            form.value.dni=persona.value.dni;
            form.value.ape_paterno = persona.value.ape_paterno;
            form.value.ape_materno = persona.value.ape_materno;
            form.value.nombres = persona.value.nombres;
            form.value.tipo = persona.value.tipo;
        }
    }
    const editar = (id) => {
        limpiar();
        obtenerDatos(id)
        form.value.estadoCrud = 'editar'
        document.getElementById("modalpersonaLabel").innerHTML = 'Editar persona';
        openModal('#modalpersona')
    }
    const nuevo = () => {
        limpiar()
        form.value.estadoCrud = 'nuevo'
        openModal('#modalpersona')
        document.getElementById("modalpersonaLabel").innerHTML = 'Nuevo persona';
        //titulo.textContent = 'Editar Datos Personales';
    }
    const listarPersonas = async(page=1) => {
        dato.value.page= page
        await obtenerPersonas(dato.value)
    }
    const eliminar = (id) => {
        Swal.fire({
            title: '¿Estás seguro de Eliminar?',
            text: "persona",
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
        await eliminarPersona(id)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            listarPersonas(personas.value.current_page)
        }
    }
    const mostrarRegistros = async(id)=>{
        await listaCertificados(id)
        document.getElementById("modalregistrosLabel").innerHTML = 'Lista de Certificados';
        openModal('#modalregistros')
    }
    // PAGINACION
    const isActived = () => {
        return personas.value.current_page
    }
    const offset = 2;

    const buscar = () => {
        listarPersonas()
    }
    const cambiarPaginacion = () => {
        listarPersonas()
    }
    const cambiarPagina =(pagina) => {
        listarPersonas(pagina)
    }
    const pagesNumber = () => {
        if(!personas.value.to){
            return []
        }
        let from = personas.value.current_page - offset
        if(from < 1) from = 1
        let to = from + (offset*2)
        if( to >= personas.value.last_page) to = personas.value.last_page
        let pagesArray = []
        while(from <= to) {
            pagesArray.push(from)
            from ++
        }
        return pagesArray
    }
    // CARGA
    onMounted(() => {
        defineTitle(titleHeader.value.titulo)
        listarPersonas()
    })
</script>
<template>
    <div class="app-content">
      <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h6 class="card-title">
                    Listado de Personas
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
                            <input class="form-control" placeholder="Ingrese nombre, código ciiu" type="text" v-model="dato.buscar"
                                @change="buscar" />
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <nav>
                            <ul class="pagination">
                                <li v-if="personas.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="personas.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(personas.current_page - 1)">
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
                                <li v-if="personas.current_page < personas.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(personas.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="personas.current_page <= personas.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(personas.last_page)"
                                        title="Última Página">
                                        <span aria-hidden="true"><i class="fas fa-step-forward"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-1">
                        <div class="table-responsive">         
                            <table class="table table-bordered table-hover table-sm table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th colspan="10" class="text-center">Personas</th>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>DNI</th>
                                        <th>Nombre Completo</th>
                                        <th>Tipo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-if="personas.total == 0">
                                        <td class="text-danger text-center" colspan="10">
                                            -- Datos No Registrados - Tabla Vacía --
                                        </td>
                                    </tr>
                                    <tr v-else v-for="(persona,index) in personas.data" :key="persona.id">
                                        <td>{{ index + personas.from }}</td>
                                        <td>{{ persona.dni }}</td>
                                        <td>{{ persona.ape_paterno + ' ' + persona.ape_materno + ' ' + persona.nombres }}</td>
                                        <td>{{ persona.tipo }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" title="Editar" @click.prevent="editar(persona.id)">
                                                <i class="fas fa-edit"></i>
                                            </button>&nbsp;
                                            <button class="btn btn-danger btn-sm" title="Enviar a Papelera" @click.prevent="eliminar(persona.id, 'Temporal')">
                                                <i class="fas fa-trash"></i>
                                            </button>&nbsp;
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
                <div class="row">
                    <div class="col-md-5 mb-1">
                        Mostrando <b>{{personas.from}}</b> a <b>{{ personas.to }}</b> de <b>{{ personas.total}}</b> Registros
                    </div>
                    <div class="col-md-7 mb-1 text-right">
                        <nav>
                            <ul class="pagination">
                                <li v-if="personas.current_page >= 2" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Primera Página"
                                        @click.prevent="cambiarPagina(1)">
                                        <span><i class="fas fa-backward"></i></span>
                                    </a>
                                </li>
                                <li v-if="personas.current_page > 1" class="page-item">
                                    <a href="#" aria-label="Previous" class="page-link"
                                        title="Página Anterior"
                                        @click.prevent="cambiarPagina(personas.current_page - 1)">

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
                                <li v-if="personas.current_page < personas.last_page" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        title="Página Siguiente"
                                        @click.prevent="cambiarPagina(personas.current_page + 1)">
                                        <span aria-hidden="true"><i class="fas fa-angle-right"></i></span>
                                    </a>
                                </li>
                                    <li v-if="personas.current_page <= personas.last_page-1" class="page-item">
                                    <a href="#" aria-label="Next" class="page-link"
                                        @click.prevent="cambiarPagina(personas.last_page)"
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
    <PersonaForm :form="form" @onListar="listarPersonas" :currentPage="personas.current_page"></PersonaForm>
    <RegistrosForm :registros="certificados"></RegistrosForm>
</template>