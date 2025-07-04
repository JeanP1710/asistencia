<script setup>
import { ref, onMounted, toRefs } from 'vue';
import usePrograma from '@/Composables/programa.js';
const {
    listaProgramas, programas
} = usePrograma();
const props = defineProps({
    form: Object,
});
const { form } = toRefs(props)

const gradosInstruccion = ref([
  { id: 1, nombre: 'Sin instrucción' },
  { id: 2, nombre: 'Educación Primaria Incompleta' },
  { id: 3, nombre: 'Educación Primaria Completa' },
  { id: 4, nombre: 'Educación Secundaria Incompleta' },
  { id: 5, nombre: 'Educación Secundaria Completa' },
  { id: 6, nombre: 'Técnico Superior' },
  { id: 7, nombre: 'Universitario Incompleto' },
  { id: 8, nombre: 'Universitario Completo' },
  { id: 9, nombre: 'Postgrado / Maestría' },
  { id: 10, nombre: 'Doctorado' }
]);

// const programas = ref([
//   { id: 1, nombre: 'Ingeniería de Sistemas' },
//   { id: 2, nombre: 'Medicina' }
// ])
const seguros = ref([
  { id: 1, nombre: 'Essalud' },
  { id: 2, nombre: 'Particular' }
])

const handleSubmit = () => {
  // Aquí iría la lógica de envío al backend
  Swal.fire({
    icon: 'success',
    title: '¡Éxito!',
    text: 'Los datos se han guardado correctamente.'
  })
}

const tiposVivienda = ref([
  { id: 1, nombre: 'Casa Propia' },
  { id: 2, nombre: 'Alquiler' },
  { id: 3, nombre: 'Casa de Familiares' }
])
const serviciosHogar = {
  agua: 'Agua potable',
  computadora: 'Computadora',
  desague: 'Desagüe',
  internet: 'Internet',
  energia_electrica: 'Energía eléctrica',
  tv_cable: 'TV por cable'
}


onMounted(() => {
  listaProgramas()
})


</script>
<template>
  <h4>Datos Personales</h4>
  <div class="row">
    <div class="col">
        <div class="p-4">
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-barcode"></i> Código</label>
            <input type="text" v-model="form.codigo" class="form-control" maxlength="15" required />
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-id-card"></i> DNI</label>
            <input type="text" v-model="form.numero_dni" class="form-control" maxlength="15" required />
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-user-tag"></i> Apellido Paterno</label>
            <input type="text" v-model="form.apellido_paterno" class="form-control" />
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-user-tag"></i> Apellido Materno</label>
            <input type="text" v-model="form.apellido_materno" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label"><i class="fas fa-user"></i> Nombres</label>
          <input type="text" v-model="form.nombres" class="form-control" required />
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-calendar-alt"></i> Fecha de Nacimiento</label>
            <input type="date" v-model="form.fecha_nacimiento" class="form-control" />
        </div>
        <div class="mb-3">
            <label class="form-label"><i class="fas fa-phone"></i> Teléfono</label>
            <input type="text" v-model="form.telefono" class="form-control" maxlength="9" />
        </div>
      </div>                          
    </div>
    <div class="col">
      <div class="p-4">
        <div class="mb-3">
        <label class="form-label"><i class="fas fa-heart"></i> Estado Civil</label>
        <select v-model="form.estado_civil" class="form-select">
            <option>SOLTERO</option>
            <option>CASADO</option>
            <option>DIVORCIADO</option>
            <option>VIUDO</option>
        </select>
        </div>
        <div class="mb-3">
        <label class="form-label"><i class="fas fa-graduation-cap"></i> Programa</label>
        <select v-model="form.programa_id" class="form-select" required>
            <option v-for="programa in programas" :key="programa.id" :value="programa.id">
            {{ programa.nombre }}
            </option>
        </select>
        </div>
        <div class="mb-3">
        <label class="form-label"><i class="fas fa-shield-alt"></i> Seguro</label>
        <select v-model="form.seguro_id" class="form-select">
            <option :value="null">Ninguno</option>
            <option v-for="seguro in seguros" :key="seguro.id" :value="seguro.id">
            {{ seguro.nombre }}
            </option>
        </select>
        </div>
        <div class="mb-3">
        <label class="form-label"><i class="fas fa-venus-mars"></i> Sexo</label>
        <div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" value="M" v-model="form.sexo" id="sexoM" />
            <label class="form-check-label" for="sexoM">Masculino</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" value="F" v-model="form.sexo" id="sexoF" />
            <label class="form-check-label" for="sexoF">Femenino</label>
            </div>
        </div>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" v-model="form.es_discapacitado" :true-value="1" :false-value="0" id="discapacidad" />
          <label class="form-check-label" for="discapacidad"><i class="fas fa-wheelchair"></i> ¿Es discapacitado?</label>
        </div>
        <div class="row mb-3">
          <div class="col">
            <label class="form-label"><i class="fas fa-user-clock"></i> Eres Padre/Madre</label>
            <select v-model="form.es_padre" class="form-select">
              <option value="1">Sí</option>
              <option value="0">No</option>
            </select>
          </div>
          <div class="col" v-if="form.es_padre==1">
            <label class="form-label"><i class="fas fa-user-clock"></i> Cantidad de Hijos</label>
            <input type="number" v-model="form.hijos" min="0" class="form-control" />
          </div>
        </div>
        <div class="mb-3" v-if="form.es_padre==1">
            <label class="form-label"><i class="fas fa-user-clock"></i> Fecha Nacimiento Menor hijo</label>
            <input type="date" class="form-control" value="">
        </div>
        <label class="form-label">Datos de Vivienda</label>
        <!-- Tipo de vivienda -->
        <div class="mb-3">
          <label class="form-label"><i class="fas fa-home"></i> Tipo de Vivienda</label>
          <select v-model="form.tipo_id" class="form-select" required>
            <option v-for="tipo in tiposVivienda" :key="tipo.id" :value="tipo.id">
              {{ tipo.nombre }}
            </option>
          </select>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="p-4">
        <label class="form-label">Servicios de Vivienda</label>
        <div class="row">
          <div class="col-md-6 mb-3" v-for="(label, key) in serviciosHogar" :key="key">
            <label class="form-label">
              <i class="fas fa-check-circle"></i> {{ label }}
            </label>
            <select v-model="form[key]" class="form-select">
              <option value="SI">Sí</option>
              <option value="NO">No</option>
            </select>
          </div>
        </div>
        <label for="form-label">Datos Parentales</label>
        <!-- Vive el padre -->
        <div class="row mb-3">
          <div class="col">
            <label class="form-label"><i class="fas fa-male"></i> ¿Vive el padre?</label>
            <select v-model="form.padre" class="form-select">
              <option value="SI">Sí</option>
              <option value="NO">No</option>
            </select>
          </div>
          <div class="col" v-if="form.padre === 'SI'">
            <label class="form-label"><i class="fas fa-user-clock"></i> Edad del padre</label>
            <input type="number" v-model="form.padre_edad" min="0" class="form-control" />
          </div>
        </div>
        <!-- Grado de instrucción del padre -->
        <div class="mb-3" v-if="form.padre === 'SI'">
          <label class="form-label"><i class="fas fa-user-graduate"></i> Grado de instrucción del padre</label>
          <select v-model="form.padre_grado_instruccion_id" class="form-select" required>
            <option v-for="grado in gradosInstruccion" :key="grado.id" :value="grado.id">
              {{ grado.nombre }}
            </option>
          </select>
        </div>
        <!-- Vive la madre -->
        <div class="row mb-3">
          <div class="col">
            <label class="form-label"><i class="fas fa-female"></i> ¿Vive la madre?</label>
            <select v-model="form.madre" class="form-select">
              <option value="SI">Sí</option>
              <option value="NO">No</option>
            </select>
          </div>
          <div class="col" v-if="form.madre === 'SI'">
            <label class="form-label"><i class="fas fa-user-clock"></i> Edad de la madre</label>
            <input type="number" v-model="form.madre_edad" min="0" class="form-control" />
          </div>
        </div>
        <!-- Edad de la madre -->
        <!-- Grado de instrucción de la madre -->
        <div class="mb-3">
          <label class="form-label"><i class="fas fa-user-graduate"></i> Grado de instrucción de la madre</label>
          <select v-model="form.madre_grado_instruccion_id" class="form-select" required>
            <option v-for="grado in gradosInstruccion" :key="grado.id" :value="grado.id">
              {{ grado.nombre }}
            </option>
          </select>
        </div>
      </div>
    </div>
  </div>
</template>