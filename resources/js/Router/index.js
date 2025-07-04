import { createRouter, createWebHistory } from "vue-router";
// import jwt_decode from 'jwt-decode';
import { jwtDecode } from 'jwt-decode'
//PLANTILLAS
import LayoutIntranet from '@/Layouts/AppLayoutIntranet.vue'
import LayoutInicio from '@/Layouts/AppLayoutInicio.vue'  //lagout libre

//vistas
import Principal from '@/Pages/Principal.vue' //DASHBOARD ADMINISTRATIVO
import Welcome from '@/Pages/Welcome.vue'
import Login from '@/Pages/Auth/Login.vue'
import EvaluacionLogin from '@/Pages/Auth/Evaluacion.vue'
import Menu from '@/Pages/Menu/Inicio.vue'
import Usuario from '@/Pages/Usuario/Inicio.vue'
import Persona from '@/Pages/Persona/Inicio.vue'
import Asistencia from '@/Pages/Asistencia/Inicio.vue'
import Marcaciones from '@/Pages/marcaciones/Inicio.vue'
import ReporteAsistencia from '@/Pages/Reporte/Asistencia.vue'
import ReporteMarcacionesDocente from '@/Pages/Reporte/AsistenciaDocente.vue'
import ReportePorPersonal from '@/Pages/Reporte/PorPersonal.vue'
import ReportePersonals from '@/Pages/Reporte/Personals.vue'
import Personal from '@/Pages/Personal/Inicio.vue'
import Docente from '@/Pages/Docentes/Inicio.vue'
import Verificaciones from '@/Pages/VerificarDatos/Inicio.vue'
import FichaSocio from '@/Pages/FichaSocio/Inicio.vue'
import LoginPersonal from '@/Pages/FichaSocio/Login.vue'
const routes = [
    {
        path: '/', name:'Inicio', component: Asistencia ,
        meta:{layout: LayoutInicio}
    },
    {
        path: '/principal', name:'Principal', component: Principal ,
        meta:{layout: LayoutIntranet}
    },
    {
        path: '/login',name: 'Login', component: Login,
        meta: {layout: LayoutInicio}
    },
    {
        path: '/evaluacion-login',name: 'EvaluacionLogin', component: EvaluacionLogin,
        meta: {layout: LayoutInicio}
    },
    {
        path: '/reporte-marcaciones',name: 'ReporteMarcaciones', component: ReporteAsistencia,
        meta: {layout: LayoutIntranet}
    },
    {
        path: '/reporte-marcaciones-docente',name: 'ReporteMarcacionesDocente', component: ReporteMarcacionesDocente,
        meta: {layout: LayoutIntranet}
    },    
    {
        path: '/reporte-por-personal',name: 'ReportePersonal', component: ReportePorPersonal,
        meta: {layout: LayoutIntranet}
    },
    {
        path: '/reporte-personal',name: 'ReportePersonals', component: ReportePersonals,
        meta: {layout: LayoutIntranet}
    },    
    {
        path: '/marcaciones',name: 'VerMarcaciones', component: Marcaciones,
        meta: {layout: LayoutIntranet}
    },  
    {
        path: '/personal',name: 'Personals', component: Personal,
        meta: {layout: LayoutIntranet}
    },       
    {
        path: '/gestion-menus',name: 'Menus', component: Menu,
        meta: {layout: LayoutIntranet}
    },
    {
        path: '/gestion-usuarios',name: 'Usuarios', component: Usuario,
        meta: {layout: LayoutIntranet}
    },
    {
        path: '/persona',name: 'Persona', component: Persona,
        meta: {layout: LayoutIntranet}
    },    
    {
        path: '/verificacion',name: 'Verificacion', component: Verificaciones,
        meta: {layout: LayoutInicio}
    },  
    {
        path: '/docente',name: 'Docente', component: Docente,
        meta: {layout: LayoutIntranet}
    },   
    {
        path: '/ficha-socio',name: 'FichaSocio', component: FichaSocio,
        meta: {layout: LayoutInicio}
    },   
    {
        path: '/personal-login',name: 'LoginPersonal', component: LoginPersonal,
        meta: {layout: LayoutInicio}
    },       
]

export default createRouter({
    history: createWebHistory(),
    routes
})