<template>
    <div>
      <h2>Historial de Accesos</h2>
      <table>
        <tr>
          <th>Empleado</th>
          <th>Estado</th>
          <th>Fecha</th>
        </tr>
        <tr v-for="log in logs" :key="log.id">
          <td>{{ log.employee.name }}</td>
          <td>{{ log.status }}</td>
          <td>{{ log.attempt_time }}</td>
        </tr>
      </table>
    </div>
  </template>

  <script>
  export default {
    data() {
      return { logs: [] };
    },
    async created() {
      const response = await this.$axios.get('/access-logs');
      this.logs = response.data;
    }
  };
  </script>
