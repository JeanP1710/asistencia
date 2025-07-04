<script setup>
import { toRefs, ref } from 'vue';
import { useAutenticacion } from '@/Composables/autenticacion';
import useHelper from '@/Helpers';
import useUsuario from '@/Composables/Usuario';
const props = defineProps({
    usuario: Object,
    alumno: Object,
    roles: Array
});
const form = ref({
  current_password : '',
  password : '',
  password_confirmation : '',
  errors : []
});
const { usuario, roles, alumno } = toRefs(props);
const {
    errors, respuesta, cambiarClave
} = useUsuario();
  const { logoutAlumno }= useAutenticacion();
  const logout = async() => {
    await logoutAlumno(usuario.value.id)
  }
  const { Swal, hideModal, Toast } = useHelper();
  const cerrarSesion = async() => {
    Swal.fire({
        title:'¿Está seguro de Cerrar Sesión?',
        text:'SISTEMA NET BOSCO',
        icon:'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si',
        cancelButtonText: 'No'
    }).then((result) => {
        if(result.isConfirmed) {
            logout()
        }
    })
  }
  const guardar=async()=>{
    await cambiarClave(form.value)
    form.value.errors = []
    if(errors.value){
        form.value.errors = errors.value
    }
    if(respuesta.value.ok==1){
        form.value.errors = []
        hideModal('#cambiarClaveModal')
        Toast.fire({icon:'success', title:respuesta.value.mensaje})
    }
  }
</script>
<template>

  <nav class="navbar navbar-light navbar-glass navbar-top navbar-expand">
    <button class="btn navbar-toggler-humburger-icon navbar-toggler me-1 me-sm-3" type="button"
    data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse"
    aria-expanded="false" aria-label="Navegacion"><span class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
    <a class="navbar-brand me-1 me-sm-3" href="/">
      <div class="d-flex align-items-center"><img class="me-2" src="logo.jpg" alt="" width="40"><span class="font-sans-serif">NetBoscoApps</span></div>
    </a>

    <ul class="navbar-nav navbar-nav-icons ms-auto flex-row align-items-center">
      <li class="nav-item px-2">
        <div class="theme-control-toggle fa-icon-wait">
          <input class="form-check-input ms-0 theme-control-toggle-input" id="themeControlToggle" type="checkbox" data-theme-control="theme" value="dark">
          <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to light theme">
            <span class="fas fa-sun fs-0"></span></label>
            <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle" data-bs-toggle="tooltip" data-bs-placement="left" title="Switch to dark theme">
              <span class="fas fa-moon fs-0"></span></label>
            </div>
      </li>

      <li class="nav-item dropdown"><a class="nav-link pe-0 ps-2" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-xl">
            <img class="rounded-circle" :src="'storage/alumnos/'+ usuario.name +'.jpg'" alt="">
          </div>
        </a>
        <div class="dropdown-menu dropdown-caret dropdown-caret dropdown-menu-end py-0" aria-labelledby="navbarDropdownUser">
          <div class="bg-white dark__bg-1000 rounded-2 py-2">
            <a class="dropdown-item fw-bold text-info" href="#!">User : <span>{{ usuario.name }}</span></a>
            <a class="dropdown-item fw-bold text-warning" href="#!"><span>{{ usuario.role?.nombre }}</span></a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#perfilModal" data-bs-toggle="modal">Perfil</a>
            <a class="dropdown-item" href="#cambiarClaveModal" data-bs-toggle="modal">Cambiar Clave</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item"
                  @click.prevent="cerrarSesion">
                  Cerrar Sesi&oacute;n
              </a>
          </div>
        </div>
      </li>
    </ul>
  </nav>
  <div class="modal fade" id="perfilModal" tabindex="-1" role="dialog" aria-labelledby="perfilModal-label" aria-hidden="true">
      <div class="modal-dialog mt-6" role="document">
        <div class="modal-content border-0">
          <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
            <div class="position-relative z-1" data-bs-theme="light">
              <h4 class="mb-0 text-white" id="perfilModal-label">Perfil</h4>
            </div><button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-4 px-5">
            <div class="row">
              <div class="col-lg-12">
                <h5 class="fs-0 fw-normal">Alumno</h5>
                <h4 class="mb-1"> {{alumno.apellido_paterno+' '+alumno.apellido_materno+', '+alumno.nombres}}</h4>
                <p class="text-500">DNI: {{alumno.numero_dni}}</p>
                <div class="border-bottom border-dashed my-4 d-lg-none"></div>
                
              </div>              
            </div>
            <div class="row">
              <div class="col">
                <div class="d-flex justify-content-center align-items-center">
                  <div class="avatar avatar-5xl border border-2 border-light rounded-circle">
                    <div class="avatar-name rounded-circle">
                      <img class="rounded-circle" :src="'storage/alumnos/'+ usuario.name +'.jpg'" alt="">
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
  </div> 
  <div class="modal fade" id="cambiarClaveModal" tabindex="-1" role="dialog" aria-labelledby="cambiarClaveModal-label" aria-hidden="true">
      <div class="modal-dialog mt-6 modal-sm" role="document">
        <div class="modal-content border-0">
          <div class="modal-header px-5 position-relative modal-shape-header bg-shape">
            <div class="position-relative z-1" data-bs-theme="light">
              <h4 class="mb-0 text-white" id="cambiarClaveModal-label">Cambiar Clave</h4>
            </div><button class="btn-close btn-close-white position-absolute top-0 end-0 mt-2 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="card">
              <div class="card-body">
                <div class="mb-3">
                    <label for="clave_actual" class="form-label">Clave Actual</label>
                    <input type="password" class="form-control" v-model="form.current_password" :class="{ 'is-invalid': form.errors.current_password }">
                    <small class="text-danger" v-for="error in form.errors.current_password" :key="error">{{ error }}</small>
                  </div>
                  <div class="mb-3">
                    <label for="nueva_clave" class="form-label">Nueva Clave</label>
                    <input type="password" class="form-control" v-model="form.password" :class="{ 'is-invalid': form.errors.password }">
                    <small class="text-danger" v-for="error in form.errors.password" :key="error">{{ error }}</small>
                  </div>
                  <div class="mb-3">
                    <label for="confirmar_clave" class="form-label">Confirmar Nueva Clave</label>
                    <input type="password" class="form-control" v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.password_confirmation }">
                    <small class="text-danger" v-for="error in form.errors.password_confirmation" :key="error">{{ error }}</small>
                  </div>
              </div>
              <div class="card-footer text-muted">
                <button type="button" class="btn btn-primary" @click="guardar">
                  <i class="fas fa-key"></i> Cambiar Clave
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>  
</template>