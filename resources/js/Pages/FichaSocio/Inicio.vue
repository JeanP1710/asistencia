<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import { useAutenticacion } from '@/Composables/autenticacion';
import DatosPersonalesView from './DatosPersonales.vue'
import DatosAcademicosView from './DatosAcademicos.vue'
import DatosEconomicosView from './DatosEconomicos.vue'
import AptitudesView from './AptitudesView.vue';
import FinalView from './FinalView.vue';
import { jwtDecode } from 'jwt-decode'
const { logoutAlumno }= useAutenticacion();
const route = useRoute()
const router = useRouter()
const alumno = localStorage.getItem('alumnoSession') ? JSON.parse( JSON.stringify(jwtDecode(localStorage.getItem('alumnoSession')).alumno)) : null
;
const pasoActual = ref(0);
const pasos = [
  'DatosPersonales',
  'DatosAcademicos',
  'DatosEconomicos',
  'Aptitudes',
  'Final'
];
const formDatosPersonales = ref({
  codigo: '',
  numero_dni: '',
  nombres: '',
  apellido_paterno: '',
  apellido_materno: '',
  fecha_nacimiento: '2024-10-01',
  telefono: '',
  estado_civil: 'SOLTERO',
  programa_id: '',
  seguro_id: null,
  sexo: 'M',
  es_discapacitado: 0,
  tipo_id: 1,
  agua : 'SI',
  telefono : 'SI',
  computadora : 'SI',
  desague : 'SI',
  internet : 'SI',
  energia_electrica : 'SI',
  tv_cable : 'SI',
  padre:'SI',
  madre:'SI',
  programa_id:1,
  padre_edad:30,
  padre_grado_instruccion_id:1,
  madre_edad:30,
  madre_grado_instruccion_id:1,
  hijos:0,
  es_padre:0,
})
const formDatosAcademicos = ref({
  tipo:'Publico',
  colegio_id : '',
  medio_difusion_id : '',
  modalidad_id : '',
  semestre_id : '',
  ciclo_academico : '',
  debe : '',
  turno : '',
});

const formDatosEconomicos = ref({
  es_trabajador: 'NO',
  tipo_trabajo: '',
  nombre_empresa: '',
  ingreso: null,
  turno_trabajo: '',
  donde_come: ''
})
const logout = async() => {
    await logoutAlumno()
  }
// Validaciones por paso (opcional)
const validarPaso = () => {
  // Ejemplo simple de validación del primer paso (puedes hacer más detallado)
  if (pasoActual.value === 0) {
    // Aquí puedes hacer validaciones a tus modelos, por ejemplo:
    // if (!form.email.match(emailRegex)) { return false; }
    return true;
  }
  return true;
};

const siguientePaso = () => {
  if (validarPaso() && pasoActual.value < pasos.length - 1) {
    pasoActual.value++;
  }
};

const pasoAnterior = () => {
  if (pasoActual.value > 0) {
    pasoActual.value--;
  }
};
const getIcon = (paso) => {
  switch (paso) {
    case 'DatosPersonales': return 'fas fa-user';
    case 'DatosAcademicos': return 'fas fa-lock';
    case 'DatosEconomicos': return 'fas fa-dollar-sign';
    case 'Aptitudes': return 'fas fa-brain';
    case 'Final': return 'fas fa-thumbs-up';
    default: return 'fas fa-circle';
  }
};
onMounted(async () => {
  await nextTick();
  if(!localStorage.getItem('alumnoSession') )
  {
      const redirect = route.query.redirect || '/alumno-login'
      router.push(redirect)
      return;
  }
  if (alumno && alumno.codigo) {
    formDatosPersonales.value = {
      ...formDatosPersonales.value, // conserva valores por defecto si no se sobreescriben
      codigo: alumno.codigo,
      numero_dni: alumno.numero_dni,
      nombres: alumno.nombres,
      apellido_paterno: alumno.apellido_paterno,
      apellido_materno: alumno.apellido_materno,
      fecha_nacimiento: alumno.fecha_nacimiento || '2024-10-01',
      telefono: alumno.telefono || '',
      estado_civil: alumno.estado_civil || 'SOLTERO',
      programa_id: alumno.programa_id,
      seguro_id: alumno.seguro_id,
      sexo: alumno.sexo || 'M',
      es_discapacitado: alumno.es_discapacitado || 0,
    };
  }
});
</script>

<template>
  <div class="container mt-5" v-if="alumno">
    <h3 class="text-center mb-4">REGISTRO FICHA SOCIO ECONOMICO &nbsp; <button type="button" class="btn btn-warning" @click="logout()">Cerrar Session</button></h3>
    <h4 class="mb-4">{{ alumno.apellido_paterno + ' ' + alumno.apellido_materno + ' ' + alumno.nombres }}</h4>
    <div class="card custom-wizard">
      <!-- Wizard Tabs -->
      <div class="card-header bg-light pt-3 pb-2">
        <ul class="nav justify-content-between nav-wizard">
          <li v-for="(paso, index) in pasos" :key="index" class="nav-item">
            <a
              href="#"
              class="nav-link fw-semi-bold"
              :class="{ active: pasoActual === index }"
              @click.prevent="pasoActual = index"
            >
              <span class="nav-item-circle-parent">
                <span class="nav-item-circle">
                  <span :class="getIcon(paso)"></span>
                </span>
              </span>
              <span class="d-none d-md-block mt-1 fs--1">{{ paso }}</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body py-4">
        <div v-show="pasoActual === 0">
          <datos-personales-view :form="formDatosPersonales" />
        </div>
        <div v-show="pasoActual === 1">
          <datos-academicos-view :form="formDatosAcademicos" />
        </div>
        <div v-show="pasoActual === 2">
          <datos-economicos-view :form="formDatosEconomicos" />
        </div>
        <div v-show="pasoActual === 3">
          <aptitudes-view />
        </div>
        <div v-show="pasoActual === 4">
          <final-view />
        </div>
  
        <div class="card-footer mt-4 d-flex justify-content-between">
          <button
            class="btn btn-secondary"
            @click="pasoAnterior"
            :disabled="pasoActual === 0"
          >
            Anterior
          </button>
          <button
            class="btn btn-primary"
            @click="siguientePaso"
            :disabled="pasoActual === pasos.length - 1"
          >
            Siguiente
          </button>
        </div>
        
      </div>
    </div>
  </div>
</template>
