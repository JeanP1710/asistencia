<script setup>
import { toRefs, onMounted, ref } from 'vue';
import usePersona from '@/Composables/Persona.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast, slugify } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number
});
const { form, currentPage } = toRefs(props)
const {
    errors, respuesta, agregarPersona, actualizarPersona
} = usePersona();
const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarPersona(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalpersona')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    },
    'editar': async() => {
        await actualizarPersona(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modalpersona')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const tipos=ref([
    'Estudiante',
    'Externo'
])
const guardar = () => {
    crud[form.value.estadoCrud]()
}
const generarNumeroAleatorio = () => {
  return Math.floor(Math.random() * (999 - 100 + 1)) + 100;
};
const generarCodigo = () => {
    const fecha = form.value.fecha;
    const numeroAleatorio = generarNumeroAleatorio();
    const codigo = fecha.replaceAll('-', '') + numeroAleatorio;
    form.value.codigo = codigo;
};
onMounted(() => {
    //listaGrupos()
})
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modalpersona" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalpersonaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fs-2" id="modalpersonaLabel">Modal title</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="text" class="form-control" v-model="form.dni" :class="{ 'is-invalid': form.errors.dni }" placeholder="dni">
                                <small class="text-danger" v-for="error in form.errors.dni" :key="error">{{ error
                                        }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="ape_paterno" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control" v-model="form.ape_paterno" :class="{ 'is-invalid': form.errors.ape_paterno }" placeholder="ape_paterno">
                                <small class="text-danger" v-for="error in form.errors.ape_paterno" :key="error">{{ error
                                        }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="ape_materno" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control" v-model="form.ape_materno" :class="{ 'is-invalid': form.errors.ape_materno }" placeholder="ape_materno">
                                <small class="text-danger" v-for="error in form.errors.dni" :key="error">{{ error
                                        }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres</label>
                                <input type="text" class="form-control" v-model="form.nombres" :class="{ 'is-invalid': form.errors.nombres }" placeholder="nombres">
                                <small class="text-danger" v-for="error in form.errors.nombres" :key="error">{{ error
                                        }}</small>
                            </div>
                            <div class="mb-3">
                                <label for="tipo" class="form-label">TIPO</label>
                                <select v-model="form.tipo" class="form-control"
                                    :class="{ 'is-invalid': form.errors.tipo }">
                                    <option value="" disabled>--Seleccione--</option>
                                    <option v-for="tipo in tipos" :value="tipo"
                                        :title="tipo">
                                        {{ tipo }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.dni" :key="error">{{ error
                                        }}</small>
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