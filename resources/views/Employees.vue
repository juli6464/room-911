<template>
    <div class="p-6 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto">
            <h5 class="text-2xl font-semibold text-gray-800 mb-6">Administrative Menu</h5>
            <div class="max-w-4xl mx-auto mt-8 space-y-8">
                <!-- new employee button -->
                <div class="flex justify-end">
                    <router-link to="/employees/create" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        New Employee
                    </router-link>
                </div>

                <!-- upload csv employee -->
                <div class="bg-white shadow rounded p-2">
                    <h3 class="text-lg font-semibold mb-2">Upload CSV Employees</h3>

                    <form @submit.prevent="UploadCSV">
                        <div class="mb-4">
                            <input
                                type="file"
                                id="file"
                                ref="file"
                                @change="handleFileUpload()"
                                accept=".xlsx, .csv"
                                class="w-full border border-gray-300 rounded px-3 py-2"
                            />
                        </div>

                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Upload
                        </button>
                    </form>
                </div>
            </div>
            <!-- Card contenedor -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mt-2">
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
                <input
                type="date"
                v-model="filters.start_date"
                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
                />
                <input
                type="date"
                v-model="filters.end_date"
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

            <!-- table -->
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
                    Attempts
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    {{ employee.access_attempts ?? 0 }}
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
                        class="bg-yellow-500 text-white hover:bg-yellow-600 p-2 m-2 rounded-md"
                        @click="generatePDF(employee)"
                    >
                        History
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
    import jsPDF from 'jspdf';
    import autoTable from 'jspdf-autotable';

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
                access_granted: '',
                file: '',
                start_date: '',
                end_date: ''
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
                const matchDate = () => {
                    if (!this.filters.start_date && !this.filters.end_date) return true;
                    if (!emp.attempt_time) return false;

                    const attemptDate = new Date(emp.attempt_time);

                    const startDate = this.filters.start_date ? new Date(this.filters.start_date) : null;
                    const endDate = this.filters.end_date ? new Date(this.filters.end_date) : null;

                    // Sumamos un día al endDate para incluir todo el día
                    if (endDate) {
                        endDate.setDate(endDate.getDate() + 1);
                    }

                    if (startDate && endDate) {
                        return attemptDate >= startDate && attemptDate < endDate; // usamos "<" en lugar de "<="
                    } else if (startDate) {
                        return attemptDate >= startDate;
                    } else if (endDate) {
                        return attemptDate < endDate;
                    }

                    return true;
                };
                return matchId && matchName && matchLast && matchDept && matchAccess && matchDate();
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
            editEmployee(employee) {
                this.$router.push(`/employees/create/${employee.id}`);
            },
            async deleteEmployee(id) {
            if (confirm('¿Are you sure?')) {
            try {
                await axios.delete(`http://localhost:8000/api/employees/${id}`);
                this.employees = this.employees.filter(emp => emp.id !== id);
                alert('Employee deleted successfully');
                } catch (error) {
                    console.error('Error to delete:', error);
                    alert('Error to delete employee');
                }
            }
            },
            async UploadCSV() {
            if (!this.file) {
                alert('Please select a file first.');
                return;
            }

            const formData = new FormData();
            formData.append('file', this.file);

            try {
                const response = await axios.post('http://localhost:8000/api/import-excel-employees', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
                });

                alert('CSV uploaded successfully');
                // Puedes recargar los empleados si se han agregado nuevos
                const { data } = await axios.get('/employees');
                this.employees = data;
                } catch (error) {
                    console.error('Error uploading CSV:', error);
                    alert('Failed to upload CSV file.');
                }
            },
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
                // this.$refs.file.value = '';
            },
            async generatePDF(employee) {
                try {
                    const { data: history } = await axios.get(`http://localhost:8000/api/employees/${employee.id}/access-history`);

                    const doc = new jsPDF();
                    doc.setFontSize(14);
                    doc.text(`Access History for ${employee.name} ${employee.last_name}`, 14, 15);

                    // Tabla de historial de accesos
                    const rows = history.map(item => [item.attempt_time]);

                    autoTable(doc, {
                        head: [['Attempt Time']],
                        body: rows,
                        startY: 20,
                    });

                    // Tabla resumen de intentos (después del historial)
                    autoTable(doc, {
                        head: [['Employee Name', 'Total Attempts']],
                        body: [[`${employee.name} ${employee.last_name}`, employee.access_attempts ?? 0]],
                        startY: doc.lastAutoTable.finalY + 10,
                    });

                    doc.save(`Access_History_${employee.name}_${employee.last_name}.pdf`);
                } catch (error) {
                    console.error('Error generating PDF:', error);
                    alert('Failed to generate PDF');
                }
            }


        }
    };
</script>

<style scoped>
</style>
