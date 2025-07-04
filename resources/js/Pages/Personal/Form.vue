<script setup>
import { toRefs, onMounted } from 'vue';
import usePersonal from '@/Composables/Personal.js';
import usePrograma from '@/Composables/programa.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast, slugify } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarPersonal, actualizarPersonal
} = usePersonal();
const {
    listaProgramas, programas
} = usePrograma();
const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarPersonal(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalpersonal')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)

            
        }
    },
    'editar': async() => {
        await actualizarPersonal(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalpersonal')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}
onMounted(() => {
    listaProgramas()
})
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalpersonal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalpersonalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs--4" id="modalpersonalLabel">Modal title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-subtitle mb-2 text-muted">Datos Personales</h6>
                            <div class="mb-3">
                                <label for="numero_dni" class="form-label">Nro Documento</label>
                                <input type="text" class="form-control" v-model="form.numero_dni" :class="{ 'is-invalid': form.errors.numero_dni }" placeholder="Nro de Documento">
                                <small class="text-danger" v-for="error in form.errors.numero_dni" :key="error">{{ error
                                        }}</small>
                            </div>                        
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control" v-model="form.nombres" :class="{ 'is-invalid': form.errors.nombres }" placeholder="Nombres">
                                <small class="text-danger" v-for="error in form.errors.nombres" :key="error">{{ error
                                        }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" v-model="form.apellido_paterno" :class="{ 'is-invalid': form.errors.apellido_paterno }" placeholder="Apellido Paterno">
                                <small class="text-danger" v-for="error in form.errors.apellido_paterno" :key="error">{{ error
                                        }}</small>
                            </div>                            
                            <div class="mb-3">
                                <label for="apellido_materno" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" v-model="form.apellido_materno" :class="{ 'is-invalid': form.errors.apellido_materno }" placeholder="Apellido Materno">
                                <small class="text-danger" v-for="error in form.errors.apellido_materno" :key="error">{{ error
                                        }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="programa_id" class="form-label">Programa de Estudios</label>
                                <select v-model="form.programa_id" class="form-control" :class="{ 'is-invalid': form.errors.programa_id }">
                                    <option value="" disabled>--Seleccione--</option>
                                    <option v-for="programa in programas" :key="programa.id" :value="programa.id">
                                        {{ programa.nombre }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.programa_id" :key="error">{{ error
                                        }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="ciclo_academico" class="form-label">Ciclo Academico</label>
                                <select v-model="form.ciclo_academico" class="form-control" :class="{ 'is-invalid': form.errors.ciclo_academico }">
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="IV">IV</option>
                                    <option value="V">V</option>
                                    <option value="VI">VI</option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.ciclo_academico" :key="error">{{ error
                                        }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="turno" class="form-label">TURNO </label>
                                <select class="form-select mb-3" v-model="form.turno" aria-label="">
                                    <option selected="" value="" disabled>Todos</option>
                                    <option value="Mañana">Mañana</option>
                                    <option value="Tarde">Tarde</option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.ciclo" :key="error">{{ error }}<br></small>
                            </div>
                            <div class="mb-3">
                                <label for="seccion" class="form-label">SECCION </label>
                                <select class="form-select mb-3" v-model="form.seccion" aria-label="">
                                    <option selected="" value="" disabled>Todos</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.ciclo" :key="error">{{ error }}<br></small>
                            </div>
                        </div>
                        <div class="col">
                            <img :src="'storage/personals/'+form?.numero_dni+'.jpg'" alt="" class="img-fluid img-thumbnail rounded-circle">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">{{ (form.estadoCrud=='nuevo') ? 'Guardar' : 'Actualizar' }}</button>
                </div>
            </div>
        </div>
    </div>
    </form>
</template>