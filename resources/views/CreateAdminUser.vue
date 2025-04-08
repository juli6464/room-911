<template>
    <div class="max-w-lg mx-auto bg-white shadow p-6 rounded mt-8">
      <h2 class="text-xl font-semibold mb-4">Create Admin User</h2>
      <form @submit.prevent="saveAdminUser">
        <div class="mb-4">
          <label class="block text-gray-700">Username</label>
          <input v-model="form.username" type="text" class="w-full border border-gray-300 rounded px-3 py-2" required />
        </div>
        <div class="mb-4">
          <label class="block text-gray-700">Password</label>
          <input v-model="form.password" type="password" class="w-full border border-gray-300 rounded px-3 py-2" required />
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Save
        </button>
      </form>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    name: 'CreateAdminUser',
    data() {
      return {
        form: {
          username: '',
          password: ''
        }
      };
    },
    methods: {
      async saveAdminUser() {
        try {
          console.log('Datos enviados:', this.form);
          await axios.post('http://localhost:8000/api/admin-users', this.form);
          alert('Admin user created successfully');
          this.$router.push('/');
        } catch (error) {
          alert('Error creating admin user, check if the password has 6 or more characters');
          console.error('Error to create admin user:', error.response?.data || error);
        }
      }
    }
  };
  </script>
