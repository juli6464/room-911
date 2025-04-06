<template>
    <div class="max-w-lg mx-auto bg-white shadow p-6 rounded mt-8">
      <h2 class="text-xl font-semibold mb-4">Crear Empleado</h2>
      <form @submit.prevent="createEmployee">
        <div class="mb-4">
          <label class="block text-gray-700">Nombre</label>
          <input v-model="form.name" type="text" class="w-full border border-gray-300 rounded px-3 py-2" required />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Apellido</label>
          <input v-model="form.last_name" type="text" class="w-full border border-gray-300 rounded px-3 py-2" required />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Departamento</label>
          <input v-model="form.department_id" type="text" class="w-full border border-gray-300 rounded px-3 py-2" required />
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
      </form>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    name: 'CreateEmployee',
    data() {
      return {
        form: {
          name: '',
          last_name: '',
          department_id: ''
        }
      };
    },
    methods: {
      async createEmployee() {
        try {
          await axios.post('/employees', this.form);
          this.$router.push('/employees');
        } catch (error) {
          alert('Error al crear empleado');
          console.error(error);
        }
      }
    }
  };
  </script>
