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
                    <h1>Paso 3</h1>
                    
                    <!-- Si viene el numero de tramite significa que estamos editando un paso -->
                    <template v-if="tramite.id">
                        <h2>Editando</h2>
                        <p>Tramite: {{ tramite.id }}</p>
                    </template>

                    <template v-if="tramiteTipo">
                        <p>tramiteTipo: {{ tramiteTipo }}</p>
                    </template>

                    <jet-form-section @submitted="updateTramiteInformation">
                        <template #title>
                            Profile Information
                        </template>

                        <template #description>
                            Update your account's profile information and email address.
                        </template>

                        <template #form>
                            <!-- Nombre -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="name" value="Nombre" />
                                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.datos.name" autocomplete="name" />
                                <jet-input-error :message="form.error('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="email" value="Email" />
                                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.datos.email" />
                                <jet-input-error :message="form.error('email')" class="mt-2" />
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="tramiteTipo" value="tramiteTipo" />
                                <jet-input id="tramiteTipo" tramiteTipo="email" class="mt-1 block w-full" v-model="form.tramiteTipo" />
                                <jet-input-error :message="form.error('tramiteTipo')" class="mt-2" />
                            </div>
                        </template>

                        <template #actions>
                            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                Saved.
                            </jet-action-message>

                            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Save
                            </jet-button>
                        </template>
                    </jet-form-section>

                    
                    
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetButton from '@/Jetstream/Button'
    import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetLabel from '@/Jetstream/Label'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'
    
    export default {
        props: ['tramite', 'tramiteTipo', 'user', 'datos'],

        components: {
            AppLayout,
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        data() {
            console.log(this.datos);
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    paso: 3,
                    datos: {
                        name: this.datos.name,
                        email: this.datos.email
                    },
                    tramiteTipo: this.tramiteTipo,
                    tramite: this.tramite.id,
                }, {
                    bag: 'updateTramiteInformation',
                    resetOnSuccess: false,
                }),
            }
        },

        methods: {
            updateTramiteInformation() {
                this.form.post(route('tramite.update'), {
                    preserveScroll: true
                });
            },

        },
    }
</script>
