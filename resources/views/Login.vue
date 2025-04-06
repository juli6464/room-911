<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Iniciar Sesión</h2>
        <form @submit.prevent="login" class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Usuario</label>
            <input
              v-model="username"
              type="text"
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Usuario"
              required
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Contraseña</label>
            <div class="relative">
              <input
                :type="showPassword ? 'text' : 'password'"
                v-model="password"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Contraseña"
                required
              />
              <button
                type="button"
                @click="showPassword = !showPassword"
                class="absolute inset-y-0 right-3 flex items-center text-gray-500"
              >
                <svg v-if="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M10 3C5.454 3 1.732 6.259.458 10.355a1 1 0 000 .29C1.732 13.741 5.454 17 10 17s8.268-3.259 9.542-6.355a1 1 0 000-.29C18.268 6.259 14.546 3 10 3zm0 12c-2.21 0-4.206-1.235-5.25-3 1.044-1.765 3.04-3 5.25-3s4.206 1.235 5.25 3c-1.044 1.765-3.04 3-5.25 3z" />
                  <path d="M10 9a1 1 0 110 2 1 1 0 010-2z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 011.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" />
                </svg>
              </button>
            </div>
          </div>
          <div v-if="error" class="text-red-600 text-sm">{{ error }}</div>
          <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200"
            :disabled="loading"
          >
            <span v-if="loading">Ingresando...</span>
            <span v-else>Ingresar</span>
          </button>
        </form>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    name: 'Login',
    data() {
      return {
        username: 'admin1',
        password: 'password123',
        showPassword: false,
        loading: false,
        error: ''
      };
    },
    methods: {
      async login() {
        this.error = '';
        this.loading = true;
        try {
          await axios.post('/login', {
            username: this.username,
            password: this.password
          });
          this.$router.push('/dashboard');
        } catch (err) {
          this.error = err.response?.data?.message || 'Credenciales incorrectas';
        } finally {
          this.loading = false;
        }
      }
    }
  };
  </script>

  <style scoped>
  @import 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css';
  </style>
