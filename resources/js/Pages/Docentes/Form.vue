<script setup>
import { toRefs, onMounted } from 'vue';
import useDocente from '@/Composables/Docente.js';
import useHelper from '@/Helpers';  
const { hideModal, Toast, slugify } = useHelper();
const props = defineProps({
    form: Object,
    currentPage : Number,
    profesiones : Array
});
const { form, currentPage, profesiones } = toRefs(props)
const {
    errors, respuesta, agregarDocente, actualizarDocente
} = useDocente();

const  emit  =defineEmits(['onListar'])
const crud = {
    'nuevo': async() => {
        await agregarDocente(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modaldocente')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)           
        }
    },
    'editar': async() => {
        await actualizarDocente(form.value)
        form.value.errors = []
        if(errors.value)
        {
            form.value.errors = errors.value
        }
        if(respuesta.value.ok==1){
            form.value.errors = []
            hideModal('#modaldocente')
            Toast.fire({icon:'success', title:respuesta.value.mensaje})
            emit('onListar', currentPage.value)
        }
    }
}
const guardar = () => {
    crud[form.value.estadoCrud]()
}
onMounted(() => {

})
</script>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modaldocente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modaldocenteLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs--4" id="modaldocenteLabel">Modal title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <h6 class="card-subtitle mb-2 text-muted">Datos Personales</h6>
                            <div class="mb-3">
                                <label for="numero_dni" class="form-label">Codigo</label>
                                <input type="text" class="form-control" v-model="form.codigo" :class="{ 'is-invalid': form.errors.codigo }" placeholder="codigo">
                                <small class="text-danger" v-for="error in form.errors.codigo" :key="error">{{ error
                                        }}</small>
                            </div>
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
                                <label for="profesion_id" class="form-label">Profesion</label>
                                <select v-model="form.profesion_id" class="form-control" :class="{ 'is-invalid': form.errors.profesion_id }">
                                    <option value="" disabled>--Seleccione--</option>
                                    <option v-for="profesion in profesiones" :key="profesion.id" :value="profesion.id">
                                        {{ profesion.descripcion }}
                                    </option>
                                </select>
                                <small class="text-danger" v-for="error in form.errors.profesion_id" :key="error">{{ error
                                        }}</small>
                            </div>
                        </div>
                        <div class="col">
                            <img :src="'storage/alumnos/'+form?.numero_dni+'.jpg'" alt="" class="img-fluid img-thumbnail rounded-circle">
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