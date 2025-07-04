<script setup>
import useDatosSession from '@/Composables/session';
import NavBar from '@/Components/NavBar.vue';
import SideBar from '@/Components/SideBar.vue';
import Footer from '@/Components/Footer.vue';
import { onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';

const {usuario, roles, menus } = useDatosSession();
const route = useRoute()
const router = useRouter()

onMounted(() => {
    if(!localStorage.getItem('userSession') )
    {
        const redirect = route.query.redirect || '/login'
        router.push(redirect)
    }
})
</script>

<template>
    
        <nav-bar :menus="menus"></nav-bar>
        <div class="content">
            <side-bar :usuario="usuario" :roles="roles"></side-bar>
            <router-view></router-view>
            <footer></footer>
        </div>
    
</template>