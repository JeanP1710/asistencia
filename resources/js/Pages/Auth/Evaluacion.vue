<script setup>
import {useAutenticacion} from '@/Composables/autenticacion';
import { ref, onMounted } from 'vue';
    const {errors, loginUsuario } = useAutenticacion();
    const user = ref({
        username:'',
        password:'',
        remember:false,
        tipo:'academico'
    });
    const autenticar = async() => {
        await loginUsuario(user.value);
    }
</script>

<template>
    <div class="container text-center mt-4">
        <h1 class="display-3 mb-3">SISTEMA DE EVALUACION</h1>
        <div class="row justify-content-center">
            <div class="col-md-4 pb-2">
                <div class="text-center mb-4"> 
                    <a href="/"><img src="/juanbosco_logo.png" class="img-fluid img-thumbnail rounded-circle" alt=""></a>
                </div>
                <div class="card">
                    <div class="card-body p-4 p-sm-5">
                        <div class="row flex-between-center mb-2">
                            <div class="col-auto">
                                <h5>Iniciar Sesión</h5>
                            </div>
                        </div>
                        <form @submit.prevent="autenticar" method="POST">
                            <div class="mb-3">
                                <input class="form-control" type="text" placeholder="Codigo" v-model="user.username" :class="{ 'is-invalid' : errors.username }">
                                <small class="text-danger" v-for="error in errors.username" :key="error">{{ error }}</small>
                            </div>
                            <div class="mb-3">
                                <input class="form-control" type="password" placeholder="Password" v-model="user.password" :class="{ 'is-invalid' : errors.password }">
                                <small class="text-danger" v-for="error in errors.password" :key="error">{{ error }}</small>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>    
</template>
