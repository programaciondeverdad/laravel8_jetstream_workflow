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
                    <h1>Paso 4</h1>
                    
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
                            <!-- Firma -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="firma" value="Nombre" />
                                <jet-input id="firma" type="text" class="mt-1 block w-full" v-model="form.datos.firma" autocomplete="name" />
                                <jet-input-error :message="form.error('firma')" class="mt-2" />
                            </div>

                            <!-- Apruebo Ausencia -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="apruebo_ausencia" value="Apruebo y Acepto Ausencia" />
                                <input id="apruebo_ausencia" type="checkbox" v-model="form.datos.apruebo_ausencia">
                                
                                <jet-input-error :message="form.error('apruebo_ausencia')" class="mt-2" />
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
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    paso: 4,
                    datos: {
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
