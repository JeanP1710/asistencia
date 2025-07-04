<script setup>
import { toRefs, onMounted } from 'vue';
import useColegio from '@/Composables/Colegio.js';
import useMedioDifusion from '@/Composables/MedioDifusion.js';
import useModalidadDifusion from '@/Composables/Modalidad.js';
import useSemestre from '@/Composables/Semestre.js';
const {
    listaColegios, colegios
} = useColegio();
const {
    listaMedios, medios
} = useMedioDifusion();
const {
    listaModalidades, modalidades
} = useModalidadDifusion();
const {
    listaSemestres, semestres
} = useSemestre();

const props = defineProps({
    form: Object,
});
const { form } = toRefs(props)

const cambiarTipoColegio=async()=>{
    await listaColegios(form.value.tipo)
}

const carcarData = async()=>{
    await listaColegios('Publico')
    await listaMedios()
    await listaModalidades()
    await listaSemestres()
}

onMounted(() => {
    carcarData()
})
</script>
<template>
    <div class="card mb-3">
        <div class="card-header">
        <div class="card-title">
            Datos Academicos
        </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label"><i class="fas fa-school"></i> Tipo Colegio</label>
                            <select v-model="form.tipo" class="form-select" @change="cambiarTipoColegio()">
                                <option value="Publico">Publico</option>
                                <option value="Privado">Privado</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label"><i class="fas fa-school"></i> Nombre Colegio</label>
                            <select v-model="form.colegio_id" class="form-select">
                                <option value="" disabled>Ninguno</option>
                                <option v-for="colegio in colegios" :key="colegio.id" :value="colegio.id">
                                    {{ colegio.nombre }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-bullhorn"></i> Medio de Difusión</label>
                        <select v-model="form.medio_difusion_id" class="form-select">
                        <option value="" disabled>Ninguno</option>
                        <option v-for="medio in medios" :key="medio.id" :value="medio.id">
                            {{ medio.nombre }}
                        </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-list-alt"></i> Modalidad</label>
                        <select v-model="form.modalidad_id" class="form-select">
                        <option :value="null">Ninguno</option>
                        <option v-for="modalidad in modalidades" :key="modalidad.id" :value="modalidad.id">
                            {{ modalidad.nombre }}
                        </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-calendar"></i> Semestre</label>
                        <select v-model="form.semestre_id" class="form-select">
                        <option :value="null">Ninguno</option>
                        <option v-for="semestre in semestres" :key="semestre.id" :value="semestre.id">
                            {{ semestre.nombre }}
                        </option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-layer-group"></i> Ciclo Académico</label>
                        <input type="text" v-model="form.ciclo_academico" class="form-control" maxlength="3" required />
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" v-model="form.debe" :true-value="1" :false-value="0" id="debeCheck" />
                        <label class="form-check-label" for="debeCheck"><i class="fas fa-exclamation-circle"></i> ¿Debe pagos?</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><i class="fas fa-clock"></i> Turno</label>
                        <select v-model="form.turno" class="form-select">
                        <option value="MAÑANA">MAÑANA</option>
                        <option value="TARDE">TARDE</option>
                        <option value="NOCHE">NOCHE</option>
                        </select>
                    </div>
                </div>
            </div>




        </div>
    </div>

</template>