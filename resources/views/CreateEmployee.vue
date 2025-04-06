<template>
    <div class="max-w-lg mx-auto bg-white shadow p-6 rounded mt-8">
      <h2 class="text-xl font-semibold mb-4">Create Employee</h2>
      <form @submit.prevent="createEmployee">
        <div class="mb-4">
          <label class="block text-gray-700">Internal ID</label>
          <input v-model="form.internal_id" type="text" class="w-full border border-gray-300 rounded px-3 py-2" required />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Name</label>
          <input v-model="form.name" type="text" class="w-full border border-gray-300 rounded px-3 py-2" required />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Last Name</label>
          <input v-model="form.last_name" type="text" class="w-full border border-gray-300 rounded px-3 py-2" required />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Department</label>
          <input v-model="form.department_id" type="text" class="w-full border border-gray-300 rounded px-3 py-2" required />
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-1">Access to room 911</label>
            <select v-model="form.access_granted" class="w-full border border-gray-300 rounded px-3 py-2">
                <option :value="1">Yes</option>
                <option :value="0">No</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save</button>
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
          internal_id: '',
          name: '',
          last_name: '',
          department_id: '',
          access_granted: 1
        }
      };
    },
    methods: {
      async createEmployee() {
        try {
            console.log(this.form)
          await axios.post('http://localhost:8000/api/employees', this.form);
          this.$router.push('/employees');
        } catch (error) {
        //   alert('Error al crear empleado');
          console.error(error);
        }
      }
    }
  };
  </script>
