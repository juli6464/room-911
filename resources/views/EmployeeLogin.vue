<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700 mb-6">Login Employee Room 911</h2>

        <form @submit.prevent="login" class="space-y-4 p-4">
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-1">Internal ID</label>
                <input
                v-model="internal_id"
                type="text"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Internal ID"
                required
                />
          </div>
            <button
                type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200"
            >
                <span>Login</span>
            </button>
        </form>
        <p v-if="error" class="text-red-600 text-sm mt-4 text-center">{{ error }}</p>
      </div>
    </div>
</template>

  <script>
  import axios from 'axios'

  export default {
    data() {
      return {
        internal_id: 'EMP001',
        error: null,
      }
    },
    methods: {
      async login() {
        this.error = null
        try {
          const response = await axios.post('http://localhost:8000/api/employee-login', {
            internal_id: this.internal_id,
          })

          const employee = response.data.employee

            if (employee.access_granted) {
                localStorage.setItem('id', employee.id)
                this.$router.push('/dashboard')
            } else {
                this.error = 'You do not have permission to access the dashboard.'
            }

        } catch (error) {
          this.error = error.response?.data?.message || 'Login failed'
        }
      },
    },
  }
  </script>

  <style scoped>

  </style>
