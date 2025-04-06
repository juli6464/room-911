import { createRouter, createWebHistory } from 'vue-router';
import Login from '../../views/Login.vue';
import Dashboard from '../../views/Dashboard.vue';
import Employees from '../../views/Employees.vue';
import AccessLogs from '../../views/AccessLogs.vue';
import SimulateAccess from '../../views/SimulateAccess.vue';
import CreateEmployee from '../../views/CreateEmployee.vue';

const routes = [
    { path: '/', component: Login },
    { path: '/dashboard', component: Dashboard },
    { path: '/employees', component: Employees },
    { path: '/employees/create', component: CreateEmployee },
    { path: '/employees/create/:id?', component: CreateEmployee},
    { path: '/access-logs', component: AccessLogs },
    { path: '/simulate-access', component: SimulateAccess },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
