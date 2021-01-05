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

                    <template v-if="tramiteTipo">
                        <p>tramiteTipo: {{ tramiteTipo }}</p>
                    </template>

                    <jet-form-section @submitted="updateTramiteInformation">
                        <template #title>
                            Información Personal
                        </template>

                        <template #description>
                            Por favor, complete todos los campos obligatorios para dar de alta su solicitud de ausencia.
                        </template>

                        <template #form>
                            <!-- Nombre -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="name" value="Nombre" />
                                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.datos.name" autocomplete="name" required />
                                <jet-input-error :message="form.error('name')" class="mt-2" />
                            </div>

                            <!-- Apellido -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="apellido" value="Apellido" />
                                <jet-input id="apellido" type="text" class="mt-1 block w-full" v-model="form.datos.apellido" autocomplete="apellido" required />
                                <jet-input-error :message="form.error('apellido')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="email" value="Email" />
                                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.datos.email" required />
                                <jet-input-error :message="form.error('email')" class="mt-2" />
                            </div>

                            <!-- Fecha Nacimiento -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="fecha_nacimiento" value="Fecha Nacimiento" />
                                <jet-input id="fecha_nacimiento" type="date" class="mt-1 block w-full" v-model="form.datos.fecha_nacimiento" required />
                                <jet-input-error :message="form.error('fecha_nacimiento')" class="mt-2" />
                            </div>

                            <!-- Tipo de Documento -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="tipo_documento" value="Tipo de Documento" />
                                <select id="tipo_documento" v-model="form.datos.tipo_documento" class="mt-1 block w-full" required >
                                    <option disabled value="">Seleccione un elemento</option>
                                    <option>DNI</option>
                                    <option>L.E.</option>
                                    <option>L.U.</option>
                                    <option>Pasaporte</option>
                                </select>
                                <jet-input-error :message="form.error('tipo_documento')" class="mt-2" />
                            </div>


                            <!-- Numero Documento de Identidad -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="documento_identidad" value="Número de Documento de Identidad" />
                                <jet-input id="documento_identidad" type="number" class="mt-1 block w-full" v-model="form.datos.documento_identidad" required />
                                <jet-input-error :message="form.error('documento_identidad')" class="mt-2" />
                            </div>

                            <!-- Archivo Documento Identidad -->
                            <div class="col-span-6 sm:col-span-4">
                                <input type="file" 
                                ref="file_documento_identidad"
                                @change="updatePhotoPreview" required >

                                <jet-label for="file_documento_identidad" value="Adjunte una copia original de su documento de identidad" />

                                <jet-input-error :message="form.error('file_documento_identidad')" class="mt-2" />
                            </div>
                            <!-- TODO: Current Profile Photo -->
                            <div class="mt-2" v-show="! photoPreview">
                                <img :src="user.profile_photo_url" alt="Current Profile Photo" class="rounded-full h-20 w-20 object-cover">
                            </div>

                            <!-- Domicilio -->
                            <div class="col-span-6 sm:col-span-4">
                                <h3>Domicilio</h3>
                            </div>
                            <!-- Calle -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="domicilio_calle" value="Calle" />
                                <jet-input id="domicilio_calle" type="text" class="mt-1 block w-full" v-model="form.datos.domicilio_calle" required />
                                <jet-input-error :message="form.error('domicilio_calle')" class="mt-2" />
                            </div>

                            <!-- Número -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="domicilio_numero" value="Número" />
                                <jet-input id="domicilio_numero" type="number" class="mt-1 block w-full" v-model="form.datos.domicilio_numero" required />
                                <jet-input-error :message="form.error('domicilio_numero')" class="mt-2" />
                            </div>

                            <!-- Código Postal -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="domicilio_codigo_postal" value="Código Postal" />
                                <jet-input id="domicilio_codigo_postal" type="number" class="mt-1 block w-full" v-model="form.datos.domicilio_codigo_postal" required />
                                <jet-input-error :message="form.error('domicilio_codigo_postal')" class="mt-2" />
                            </div>

                            <!-- Departamento y Piso -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="domicilio_departamento_piso" value="Departamento y Piso" />
                                <jet-input id="domicilio_departamento_piso" type="text" class="mt-1 block w-full" v-model="form.datos.domicilio_departamento_piso" />
                                <jet-input-error :message="form.error('domicilio_departamento_piso')" class="mt-2" />
                            </div>

                            <!-- Localidad -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="domicilio_localidad" value="Localidad" />
                                <jet-input id="domicilio_localidad" type="text" class="mt-1 block w-full" v-model="form.datos.domicilio_localidad" required />
                                <jet-input-error :message="form.error('domicilio_localidad')" class="mt-2" />
                            </div>

                            <!-- Partido o Departamento -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="domicilio_partido" value="Partido o Departamento" />
                                <jet-input id="domicilio_partido" type="text" class="mt-1 block w-full" v-model="form.datos.domicilio_partido" required />
                                <jet-input-error :message="form.error('domicilio_partido')" class="mt-2" />
                            </div>

                            <!-- Provincia -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="domicilio_provincia" value="Provincia" />
                                <jet-input id="domicilio_provincia" type="text" class="mt-1 block w-full" v-model="form.datos.domicilio_provincia" required />
                                <jet-input-error :message="form.error('domicilio_provincia')" class="mt-2" />
                            </div>

                            <!-- País -->
                            <div class="col-span-6 sm:col-span-4">
                                <jet-label for="domicilio_pais" value="País" />
                                <select id="domicilio_pais" v-model="form.datos.domicilio_pais" class="mt-1 block w-full" required >
                                    <option disabled value="">Seleccione un país</option>
                                    <option v-for="pais in paises" v-bind:value="pais.name">
                                        {{ pais.name }}
                                    </option>
                                </select>
                                <jet-input-error :message="form.error('domicilio_pais')" class="mt-2" />
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
                    paso: 1,
                    datos: {
                        name: "asdasdasd",
                        email: this.datos.email
                    },
                    tramiteTipo: this.tramiteTipo,
                    tramite: this.tramite.id,
                    file_documento_identidad: null,
                }, {
                    bag: 'updateTramiteInformation',
                    resetOnSuccess: false,
                }),
                photoPreview: null,
                paises: ''
            }
        },

        methods: {
            updateTramiteInformation() {
                if (this.$refs.file_documento_identidad) {
                    this.form.file_documento_identidad = this.$refs.file_documento_identidad.files[0]
                }

                this.form.post(route('tramite.update'), {
                    preserveScroll: true
                });
            },
            async loadPaises () {
                var self = this;
              axios.get(
                'http://localhost:8000/json/countries.json'
              )
              .then(response => {
                this.paises = response.data.countries;
              });
              
            },
            updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };
                reader.readAsDataURL(this.$refs.file_documento_identidad.files[0]);
            },

        },
        created: function(){
            this.loadPaises();
        }
    }
</script>
