<script setup>
import { toRefs, onMounted, ref } from 'vue';
import usePersona from '@/Composables/Persona.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast, slugify } = useHelper();
const props = defineProps({
    registros: Array,
});
const { registros } = toRefs(props)
const {
    errors, respuesta, agregarPersona, actualizarPersona
} = usePersona();


</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalregistros" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalregistrosLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fs-2" id="modalregistrosLabel">Modal title</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive scrollbar">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="small p-0" scope="col">#</th>
                                <th class="small p-0" scope="col">Codigo</th>
                                <th class="small p-0" scope="col">Fecha</th>
                                <th class="small p-0" scope="col">Curso</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(registro,index) in registros">
                                    <td class="small p-0">{{ index+1 }}</td>
                                    <td class="small p-0">{{ registro.codigo }}</td>
                                    <td class="small p-0">{{ registro.fecha }}</td>
                                    <td class="small p-0">{{ registro.curso_tomado }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>