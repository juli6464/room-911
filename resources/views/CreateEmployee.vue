<template>
    <div class="max-w-lg mx-auto bg-white shadow p-6 rounded mt-8">
      <h2 class="text-xl font-semibold mb-4">{{ isEditMode ? 'Edit Employee' : 'Create Employee' }}</h2>
      <form @submit.prevent="saveEmployee">
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
        <!-- <div class="mb-4">
          <label class="block text-gray-700">Department</label>
          <input v-model="form.department_id" type="text" class="w-full border border-gray-300 rounded px-3 py-2" required />
        </div> -->
        <div class="mb-4">
          <label class="block text-gray-700 mb-1">Department</label>
          <select v-model="form.department_id" class="w-full border border-gray-300 rounded px-3 py-2">
            <option :value="1">Departament 1</option>
            <option :value="0">Departament 2</option>
          </select>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 mb-1">Access to room 911</label>
          <select v-model="form.access_granted" class="w-full border border-gray-300 rounded px-3 py-2">
            <option :value="1">Yes</option>
            <option :value="0">No</option>
          </select>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          {{ isEditMode ? 'Update' : 'Save' }}
        </button>
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
        },
        isEditMode: false
      };
    },
    methods: {
      async loadEmployee(id) {
        try {
          const response = await axios.get(`http://localhost:8000/api/employees/${id}`);
          this.form = response.data.employee;
        } catch (error) {
          console.error('Error al cargar empleado:', error);
        }
      },
      async saveEmployee() {
        try {
            console.log("Datos a enviar:", this.form); // 👈 Agrega esto

            if (this.isEditMode) {
            await axios.put(`http://localhost:8000/api/employees/${this.$route.params.id}`, this.form);
            } else {
            await axios.post('http://localhost:8000/api/employees', this.form);
            }
            this.$router.push('/employees');
            } catch (error) {
                console.error('Error al guardar empleado:', error.response?.data || error);
            }
        }

    },
    created() {
      const id = this.$route.params.id;
      if (id) {
        this.isEditMode = true;
        this.loadEmployee(id);
      }
    }
  };
  </script>
