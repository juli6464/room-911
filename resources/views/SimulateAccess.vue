<template>
    <div>
      <h2>Simulación de Acceso</h2>
      <form @submit.prevent="simulateAccess">
        <input type="text" v-model="internalId" placeholder="ID Interno" required />
        <button type="submit">Intentar Acceso</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    data() {
      return { internalId: '' };
    },
    methods: {
      async simulateAccess() {
        await this.$axios.post('/simulate-access', { internal_id: this.internalId });
        alert('Intento registrado');
      }
    }
  };
  </script>
