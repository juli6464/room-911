<template>
    <router-link to="/employees/create" class="inline-block mb-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Crear nuevo empleado</router-link>
    <div class="p-6 bg-gray-100 min-h-screen">
      <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Administrative Menu</h2>

        <!-- Card contenedor -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
          <!-- Filtros -->
          <div class="p-4 border-b border-gray-200 grid grid-cols-1 sm:grid-cols-5 gap-4">
            <input
              v-model="filters.internal_id"
              placeholder="Filtrar ID"
              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <input
              v-model="filters.name"
              placeholder="Filtrar Nombre"
              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <input
              v-model="filters.last_name"
              placeholder="Filtrar Apellido"
              class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <input
              v-model="filters.department_id"
              placeholder="Filtrar Departamento"
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
                    class="text-blue-600 hover:text-blue-800 mr-2"
                    @click="editEmployee(employee)"
                  >
                    Update
                  </button>
                  <button
                    class="text-red-600 hover:text-red-800"
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
                  No hay resultados
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
      deleteEmployee(id) {
        // lógica para eliminar
        if (confirm('¿Seguro que deseas eliminar este empleado?')) {
          axios.delete(`/employees/${id}`)
            .then(() => {
              this.employees = this.employees.filter(e => e.id !== id);
            })
            .catch(err => console.error(err));
        }
      }
    }
  };
  </script>

  <style scoped>
  </style>
