<script setup>
    import { ref, onMounted } from 'vue';
    import useHelper from '@/Helpers'; 
    import useMarcacion from '@/Composables/marcacion.js';
    import { jwtDecode } from 'jwt-decode'
    const {
        errors,
        respuesta,
        agregarMarcacion,
    } = useMarcacion();
    const personal = ref({});
    const { openModal, Toast, Swal, formatoFecha, hideModal } = useHelper();
    const form = ref({
        numero_dni:'',
        fecha: formatoFecha(null,"YYYY-MM-DD"),
        hora: formatoFecha(null,"HH:mm:ss"),
        errors:[]
    });
    const maxSegundos = ref(1);
    const contador = ref(0);
    const temporizadorId = ref('');
    const incrementarContador = () => {
      contador.value++;
    };
    const activarTemporizador = () => {
      temporizadorId.value = setTimeout(
        function(){
            incrementarContador()
            if(contador.value<maxSegundos.value){
                activarTemporizador()
            }else{
                hideModal('#modalpersonal')
                maxSegundos.value=1
                cargarFocus()
            }
        }
      , 1000); // Temporizador de 1 segundo (1000 ms)
    };

    function actualizarHora() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        var ap = (hr < 12) ? "<span>a.m.</span>" : "<span>p.m.</span>";
        hr = (hr == 0) ? 12 : hr;
        hr = (hr > 12) ? hr - 12 : hr;
        //Add a zero in front of numbers<10
        hr = checkTime(hr);
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;
        var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        var dias = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        var curWeekDay = dias[today.getDay()];
        var curDay = today.getDate();
        var curMonth = meses[today.getMonth()];
        var curYear = today.getFullYear();
        var date = curWeekDay+", "+curDay+" "+curMonth+" "+curYear;
        document.getElementById("date").innerHTML = date;   
        var time = setTimeout(function(){ actualizarHora() }, 500);
        form.value.hora = formatoFecha(null,"HH:mm:ss");
    }
    const imagenNoEncontrada = (event)=>{
        event.target.src = "/storage/personals/default.png"; // Imagen por defecto
    }
    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    const detenerTemporizador = () => {
      clearInterval(temporizadorId.value);
    };
    const miInput = ref(null);
    const guardar = async () => {
        if(form.value.numero_dni){
            await agregarMarcacion(form.value)
            personal.value = respuesta.value.personal
            form.value.errors = []
            if(errors.value)
            {
                form.value.errors = errors.value
                Swal.fire({
                    title: "Error en el Registro!",
                    html: Object.values(form.value.errors).map(error => error.join('<br>')).join('<br>'),
                    icon: "error"
                });   
                form.value.numero_dni=''
            } else {
                if(respuesta.value.ok==2){
                    Swal.fire({
                        title: "Ya estaba Registrado!",
                        text: respuesta.value.mensaje,
                        timer: 1000,
                        showConfirmButton: false
                    });
                } else {
                    form.value.errors = []
                }
            }
            personal.value = respuesta.value.personal
            form.value.numero_dni=''
        }
    }
    const cargarFocus=()=>{
        miInput.value.focus();
    }
    onMounted(() => {
        actualizarHora()
        cargarFocus()
    });
</script>
<style>
    .btn-custom {
    background-color: #4D61F4;
    color: #fff;
    border: none;
    font-size: 1.2rem;
    padding: 15px 30px;
    border-radius: 50px;
    }       
    .btn-custom:hover {
        background-color: #3C4FCB;
    }
    .clockdate-wrapper {
        background-color: #333;
        padding:18px;
        max-width:510px;
        width:100%;
        text-align:center;
        border-radius:5px;
        margin:0 auto;
    }
    #clock, #date {
        font-family: 'Courier New', monospace;
        color: #fff;
    }
    #clock {
        font-size: 3.5rem;
        text-shadow: 0px 0px 2px #fff;
    }
    #date {
        font-size: 1.2rem;
        letter-spacing: 2px;
    }
</style>
<template>
    <div class="container-fluid mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="text-center mb-4"> 
                    <a href="/"><img src="/logo.png" class="img-fluid img-thumbnail rounded-circle" alt=""></a>
                </div>
                <div class="clockdate-wrapper mt-6">
                    <div id="clock" class="text-center"></div>
                    <div id="date" class="text-center"></div>
                </div>
                <br>
                <form @submit.prevent="guardar">
                    <div class="form-group mb-4">
                        <input type="text"
                            v-model="form.numero_dni"
                            class="form-control form-control-lg text-center"
                            style="font-size: 2.5rem; border: 3px solid #007bff; border-radius: 10px;"
                            id="dniEstudiante"
                            placeholder="DNI"
                            ref="miInput"> 
                    </div>
                    <div class="text-center">
                        <button class="btn btn-custom btn-lg" type="submit">REGISTRAR</button>
                    </div>                
                </form>
            </div>
            <div class="col-md-6">
                <div class="card border h-100 border-primary" :class="{ 'bg-danger': personal?.deudas_count>=1 }" >
                    <div class="card-body">
                        <div class="p-4 p-md-5 text-center">
                            <div class="row" v-if="personal?.tipo_trabajador">
                                
                                <div class="col">
                                    <h1 class="display-1 mb-3 text-primary">{{personal.nombres}}</h1>
                                    <h1 class="display-5 mb-3">{{personal.apellido_paterno.toUpperCase() + ' ' + personal.apellido_materno.toUpperCase()}}</h1>
                                    <h1 class="display-5 mb-3">TIPO TRABAJADOR : {{personal.tipo_trabajador.nombre}}</h1>
                                    <h1 class="display-5 mb-3">EMAIL : {{personal.email}}</h1>
                                    <h1 class="display-5 mb-3">CARGO : {{personal.cargo.nombre}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>