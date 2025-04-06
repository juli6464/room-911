<template>
    <div>
        <Employees />
        <nav>
            <router-link to="/access-logs"> Registros de Acceso</router-link>
        </nav>
    </div>
</template>

<script>
    import Employees from './Employees.vue';

    export default {
        components: {
            Employees
        }
    };
</script>
