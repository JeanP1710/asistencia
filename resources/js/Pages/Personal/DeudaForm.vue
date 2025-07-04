<script setup>
import { toRefs, onMounted } from 'vue';
import useDeuda from '@/Composables/Deuda.js';
import usePrograma from '@/Composables/programa.js';
import useHelper from '@/Helpers';  
const { meses, Swal, Toast } = useHelper();
const props = defineProps({
    deudas : Array,
    form : Object,
    anios : Array,
});

const { deudas, form, anios } = toRefs(props)
const {
    agregarDeuda, respuesta, eliminarDeuda, errors
} = useDeuda();
const  emit  =defineEmits(['onListar'])
const buscarMes = (numero) => {
  const mes = meses.find(mes => mes.numero === numero.toString());
  return mes ? mes.nombre : 'Mes no encontrado';
};
const guardar = async() => {
    //form.value.nombreMes = meses[form.value.mes]

    form.value.nombreMes = buscarMes(form.value.mes)
    await agregarDeuda(form.value)
    emit('onListar', form.value.alumno_id)
}
const eliminar = (id) => {
    Swal.fire({
        title: '¿Estás seguro de Eliminar?',
        text: "Deuda",
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
    await eliminarDeuda(id)
    form.value.errors = []
    if(errors.value)
    {
        form.value.errors = errors.value
    }
    if(respuesta.value.ok==1){
        form.value.errors = []
        Toast.fire({icon:'success', title:respuesta.value.mensaje})
        emit('onListar', form.value.alumno_id)
    }
}
</script>
<style>
.custom-btn {
    padding: 2px 5px;
    font-size: 12px;
    line-height: 1;
}
</style>
<template>
    <form @submit.prevent="guardar">
    <div class="modal fade" id="modaldeuda" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modaldeudaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs--4" id="modaldeudaLabel">Modal title</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="name" class="form-label">Mes</label>
                            <select v-model="form.mes" class="form-control" :class="{ 'is-invalid': form.errors.mes }">
                                <option v-for="mes in meses" :key="mes.numero" :value="mes.numero"
                                    :title="mes.nombre">
                                    {{ mes.nombre }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="anio" class="form-label">Año</label>
                            <select v-model="form.anio" class="form-control"
                                :class="{ 'is-invalid': form.errors.anho }">
                                <option v-for="anho in anios" :key="anho" :value="anho"
                                    :title="anho">
                                    {{ anho }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2"><br>
                            <button class="btn btn-primary" @click.prevent="guardar()">
                            Cargar
                            </button>&nbsp;
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <div class="table-responsive">         
                                <table class="table table-bordered table-hover table-sm table-striped small">
                                    <thead class="table-dark">
                                        <tr>
                                            <th colspan="13" class="text-center">Registros</th>
                                        </tr>
                                        <tr>
                                            <th>#</th>
                                            <th>Nro</th>
                                            <th>Mes</th>
                                            <th>Año</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="deudas.length == 0">
                                            <td class="text-danger text-center" colspan="13">
                                                -- No hay Deudas --
                                            </td>
                                        </tr>
                                        <tr v-else v-for="(deuda,index) in deudas" :key="deuda.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ deuda.mes }}</td>
                                            <td>{{ deuda.nombreMes }}</td>
                                            <td>{{ deuda.anio }}</td>
                                            <td>
                                                <button class="btn btn-danger custom-btn" title="Eliminar" @click.prevent="eliminar(deuda.id)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    </form>
</template>