<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Certificado de Ausencia
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <h1>Paso 1</h1>
                    
                    <!-- Si viene el numero de tramite significa que estamos editando un paso -->
                    <template v-if="tramite.id">
                        <h2>Editando</h2>
                        <p>Tramite: {{ tramite.id }}</p>
                    </template>

                    
                    
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        props: ['tramite'],

        components: {
            AppLayout
        },
    }
</script>
