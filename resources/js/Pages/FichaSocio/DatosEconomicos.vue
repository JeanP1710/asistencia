<script setup>
import { ref, onMounted, toRefs } from 'vue';
const props = defineProps({
    form: Object,
});
const { form } = toRefs(props)
</script>
<template>
    <!-- ¿Es trabajador? -->
    <div class="mb-3">
    <label class="form-label"><i class="fas fa-briefcase"></i> ¿Es trabajador?</label>
    <select v-model="form.es_trabajador" class="form-select">
        <option value="NO">NO</option>
        <option value="SI">SÍ</option>
    </select>
    </div>

    <!-- Tipo de trabajo -->
    <div class="mb-3" v-if="form.es_trabajador === 'SI'">
    <label class="form-label"><i class="fas fa-industry"></i> Tipo de trabajo</label>
    <select v-model="form.tipo_trabajo" class="form-select">
        <option value="">Seleccione</option>
        <option value="Privado">Privado</option>
        <option value="Público">Público</option>
    </select>
    </div>

    <!-- Nombre de empresa -->
    <div class="mb-3" v-if="form.es_trabajador === 'SI'">
    <label class="form-label"><i class="fas fa-building"></i> Nombre de la empresa</label>
    <input type="text" v-model="form.nombre_empresa" class="form-control" />
    </div>

    <!-- Ingreso -->
    <div class="mb-3" v-if="form.es_trabajador === 'SI'">
    <label class="form-label"><i class="fas fa-money-bill-wave"></i> Ingreso mensual (S/.)</label>
    <input type="number" step="0.01" min="0" v-model="form.ingreso" class="form-control" />
    </div>

    <!-- Turno de trabajo -->
    <div class="mb-3" v-if="form.es_trabajador === 'SI'">
    <label class="form-label"><i class="fas fa-clock"></i> Turno de trabajo</label>
    <select v-model="form.turno_trabajo" class="form-select">
        <option value="">Seleccione</option>
        <option value="Mañana">Mañana</option>
        <option value="Tarde">Tarde</option>
        <option value="Noche">Noche</option>
        <option value="Diurno">Diurno</option>
    </select>
    </div>

    <!-- Dónde come -->
    <div class="mb-3">
    <label class="form-label"><i class="fas fa-utensils"></i> ¿Dónde suele comer?</label>
    <select v-model="form.donde_come" class="form-select" required>
        <option value="">Seleccione</option>
        <option value="Casa">Casa</option>
        <option value="Pensión">Pensión</option>
        <option value="Otros">Otros</option>
    </select>
    </div>
</template>