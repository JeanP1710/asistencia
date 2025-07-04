<template>
    <div>
      <h1>Estado de la página: {{ visibilityState }}</h1>
    </div>
  </template>
  
  <script>
  import { ref, onMounted, onUnmounted } from 'vue';
  
  export default {
    name: 'VisibilityComponent',
    setup() {
      const visibilityState = ref(document.visibilityState);
  
      const handleVisibilityChange = () => {
        visibilityState.value = document.visibilityState;
        console.log('cambio')
      };
  
      onMounted(() => {
        document.addEventListener('visibilitychange', handleVisibilityChange);
      });
  
      onUnmounted(() => {
        document.removeEventListener('visibilitychange', handleVisibilityChange);
      });
  
      return {
        visibilityState
      };
    }
  };
  </script>