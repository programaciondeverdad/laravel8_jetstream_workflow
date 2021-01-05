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
                    <h1>Paso 2</h1>
                    
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
                            Motivo de Ausencia
                        </template>

                        <template #description>
                            Por favor, indique su motivo de ausencia completando todos los campos obligatorios.
                        </template>

                        <template #form>
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="motivo" value="Motivo de Ausencia" />
                                <textarea id="motivo" class="mt-1 block w-full" v-model="form.datos.motivo_ausencia" required ></textarea>
                                <jet-input-error :message="form.error('motivo_ausencia')" class="mt-2" />
                            </div>
                            

                            <!-- Archivo Documento Identidad -->
                            <div class="col-span-6 sm:col-span-4">
                                <input type="file" 
                                ref="file_certificado_ausencia"
                                @change="updatePhotoPreview" required >

                                <jet-label for="file_certificado_ausencia" value="Adjunte una copia original de su documento de identidad" />

                                <jet-input-error :message="form.error('file_certificado_ausencia')" class="mt-2" />
                            </div>
                            <!-- TODO: Current Profile Photo -->
                            <div class="mt-2" v-show="! photoPreview">
                                <img :src="user.profile_photo_url" alt="Current Profile Photo" class="rounded-full h-20 w-20 object-cover">
                            </div>

                        

                            <!-- Fecha Inicio Ausencia -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="fecha_inicio_ausencia" value="Fecha Inicio" />
                                <jet-input id="fecha_inicio_ausencia" type="date" class="mt-1 block w-full" v-model="form.datos.fecha_inicio_ausencia" required />
                                <jet-input-error :message="form.error('fecha_inicio_ausencia')" class="mt-2" />
                            </div>

                            <!-- Fecha Fin Ausencia -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="fecha_fin_ausencia" value="Fecha Fin" />
                                <jet-input id="fecha_fin_ausencia" type="date" class="mt-1 block w-full" v-model="form.datos.fecha_fin_ausencia" required />
                                <jet-input-error :message="form.error('fecha_fin_ausencia')" class="mt-2" />
                            </div>

                            <!-- Fecha Fin Ausencia -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="fecha_fin_ausencia_no_se" value="No se cuando termina" />
                                <input id="fecha_fin_ausencia_no_se" type="checkbox" v-model="form.datos.fecha_fin_ausencia_no_se">
                                
                                <jet-input-error :message="form.error('fecha_fin_ausencia_no_se')" class="mt-2" />
                            </div>


                        </template>

                        <template #actions>
                            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                Saved.
                            </jet-action-message>

                            <!-- <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> -->
                            <jet-button :class="{ 'opacity-25': form.processing }">
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
    import axios from 'axios'
    import VueAxios from 'vue-axios'
 
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
            VueAxios, 
            axios
        },

        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    paso: 2,
                    datos: {
                        name: this.datos.name,
                    },
                    tramiteTipo: this.tramiteTipo,
                    tramite: this.tramite.id,
                    file_certificado_ausencia: null,
                }, {
                    bag: 'updateTramiteInformation',
                    resetOnSuccess: false,
                }),
            }
        },

        methods: {
            updateTramiteInformation() {
                if (this.$refs.file_certificado_ausencia) {
                    this.form.file_certificado_ausencia = this.$refs.file_certificado_ausencia.files[0]
                }

                this.form.post(route('tramite.update'), {
                    preserveScroll: true
                });
            },
            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };
                reader.readAsDataURL(this.$refs.file_certificado_ausencia.files[0]);
            },

        }
    }
</script>
