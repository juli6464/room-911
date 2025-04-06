<template>

    <div class="p-6 bg-gray-100 min-h-screen">
      <div class="max-w-7xl mx-auto">
        <h5 class="text-2xl font-semibold text-gray-800 mb-6">Administrative Menu</h5>
        <div class="flex justify-end mb-4 mr-4">
            <router-link to="/employees/create" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                New Employee
            </router-link>
        </div>
        <!-- Card contenedor -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
          <!-- Filtros -->
          <div class="p-4 border-b border-gray-200 grid grid-cols-1 sm:grid-cols-5 gap-4">
            <input
              v-model="filters.internal_id"
              placeholder="ID"
              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <input
              v-model="filters.name"
              placeholder="Name"
              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <input
              v-model="filters.last_name"
              placeholder="Last Name"
              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <input
              v-model="filters.department_id"
              placeholder="Department"
              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <select
              v-model="filters.access_granted"
              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
              <option value="">All filters</option>
              <option value="true">Yes</option>
              <option value="false">No</option>
            </select>
          </div>

          <!-- Tabla -->
          <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Employee ID
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Firstname
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  LastName
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Department
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Total Access
                </th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Actions
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr
                v-for="employee in filteredEmployees"
                :key="employee.id"
                class="hover:bg-gray-50"
              >
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ employee.internal_id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ employee.name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ employee.last_name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                  {{ employee.department_id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <span
                    :class="employee.access_granted ? 'text-green-600' : 'text-red-600'"
                  >
                    {{ employee.access_granted ? 'Sí' : 'No' }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                  <button
                    class="bg-gray-500 text-white hover:bg-gray-800 p-2 m-2 rounded-md"
                    @click="editEmployee(employee)"
                  >
                    Update
                  </button>
                  <button
                    class="bg-red-500 text-white hover:bg-red-800 p-2 m-2 rounded-md"
                    @click="deleteEmployee(employee.id)"
                  >
                    Delete
                  </button>
                </td>
              </tr>
              <tr v-if="filteredEmployees.length === 0">
                <td
                  class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center"
                  colspan="6"
                >
                  No Results Found
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    name: 'Employees',
    data() {
      return {
        employees: [],
        filters: {
          internal_id: '',
          name: '',
          last_name: '',
          department_id: '',
          access_granted: ''
        }
      };
    },
    computed: {
      filteredEmployees() {
        return this.employees.filter(emp => {
          const matchId = emp.internal_id
            .toString()
            .includes(this.filters.internal_id);
          const matchName = emp.name
            .toLowerCase()
            .includes(this.filters.name.toLowerCase());
          const matchLast = emp.last_name
            .toLowerCase()
            .includes(this.filters.last_name.toLowerCase());
          const matchDept = emp.department_id
            .toString()
            .includes(this.filters.department_id);
          let matchAccess = true;
          if (this.filters.access_granted === 'true')
            matchAccess = emp.access_granted === true;
          if (this.filters.access_granted === 'false')
            matchAccess = emp.access_granted === false;
          return matchId && matchName && matchLast && matchDept && matchAccess;
        });
      }
    },
    async created() {
      try {
        const { data } = await axios.get('/employees');
        this.employees = data;
      } catch (error) {
        console.error('Error al cargar empleados:', error);
      }
    },
    methods: {
      editEmployee(emp) {
        // lógica para editar
        this.$router.push(`/employees/${emp.id}/edit`);
      },
      async deleteEmployee(id) {
        if (confirm('¿Estás seguro de eliminar este empleado?')) {
        try {
            await axios.delete(`http://localhost:8000/api/employees/${id}`);
            // Quita el empleado de la lista sin recargar
            this.employees = this.employees.filter(emp => emp.id !== id);
            alert('Empleado eliminado');
            } catch (error) {
                console.error('Error al eliminar:', error);
                alert('Error al eliminar el empleado');
            }
        }
     }
    }
  };
  </script>

  <style scoped>
  </style>
