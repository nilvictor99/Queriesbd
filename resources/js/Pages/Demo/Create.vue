<script setup>
    import { useForm } from '@inertiajs/vue3';
    import InputError from '@/Components/InputError.vue';

    const form = useForm({
        document_number: '',
        cod_verificacion: '',
        paternal_last_name: '',
        maternal_last_name: '',
        name: '',
        gender: '',
        date_of_birth: '',
        date_of_death: '',
        department: '',
        province: '',
        district: '',
        marital_status: '',
        education_level: '',
        height: '',
        registration_date: '',
        issue_date: '',
        expiration_date: '',
        father: '',
        mother: '',
        restrictions: '',
        address: '',
        ubigeo_reniec: '',
        ubigeo_inei: '',
        ubigeo_sunat: '',
        postal_code: '',
        photo: '',
    });

    const submitForm = () => {
        form.post(route('data.store'));
    };
</script>

<template>
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg max-w-4xl">
        <h1 class="text-3xl font-bold text-blue-700 mb-8 text-center">
            Formulario de Registro
        </h1>

        <form @submit.prevent="submitForm" method="POST">
            <!-- Sección: Documento -->
            <section
                class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50"
            >
                <h2
                    class="text-xl font-semibold text-blue-800 mb-4 border-b pb-2"
                >
                    📄 Información del Documento
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label
                            for="document_number"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Número de Documento
                        </label>
                        <input
                            id="document_number"
                            v-model="form.document_number"
                            type="text"
                            placeholder="Ingrese número"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <InputError :message="form.errors.document_number" />
                    </div>

                    <div class="form-group">
                        <label
                            for="cod_verificacion"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Código de Verificación
                        </label>
                        <input
                            id="cod_verificacion"
                            v-model="form.cod_verificacion"
                            type="text"
                            placeholder="Código"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>
            </section>

            <!-- Sección: Datos Personales -->
            <section
                class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50"
            >
                <h2
                    class="text-xl font-semibold text-blue-800 mb-4 border-b pb-2"
                >
                    👤 Datos Personales
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="form-group">
                        <label
                            for="paternal_last_name"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Apellido Paterno
                        </label>
                        <input
                            id="paternal_last_name"
                            v-model="form.paternal_last_name"
                            type="text"
                            placeholder="Apellido paterno"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <InputError :message="form.errors.paternal_last_name" />
                    </div>

                    <div class="form-group">
                        <label
                            for="maternal_last_name"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Apellido Materno
                        </label>
                        <input
                            id="maternal_last_name"
                            v-model="form.maternal_last_name"
                            type="text"
                            placeholder="Apellido materno"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <InputError :message="form.errors.maternal_last_name" />
                    </div>

                    <div class="form-group">
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Nombre(s)
                        </label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            placeholder="Nombres"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                        <InputError :message="form.errors.name" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                    <div class="form-group">
                        <label
                            for="gender"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Género
                        </label>
                        <select
                            id="gender"
                            v-model="form.gender"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Seleccione</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                            <option value="O">Otro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label
                            for="date_of_birth"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Fecha de Nacimiento
                        </label>
                        <input
                            id="date_of_birth"
                            v-model="form.date_of_birth"
                            type="date"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            for="date_of_death"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Fecha de Fallecimiento
                        </label>
                        <input
                            id="date_of_death"
                            v-model="form.date_of_death"
                            type="date"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>
            </section>

            <!-- Sección: Ubicación -->
            <section
                class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50"
            >
                <h2
                    class="text-xl font-semibold text-blue-800 mb-4 border-b pb-2"
                >
                    📍 Ubicación y Domicilio
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="form-group">
                        <label
                            for="department"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Departamento
                        </label>
                        <input
                            id="department"
                            v-model="form.department"
                            type="text"
                            placeholder="Departamento"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            for="province"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Provincia
                        </label>
                        <input
                            id="province"
                            v-model="form.province"
                            type="text"
                            placeholder="Provincia"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            for="district"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Distrito
                        </label>
                        <input
                            id="district"
                            v-model="form.district"
                            type="text"
                            placeholder="Distrito"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-4">
                    <div class="form-group">
                        <label
                            for="ubigeo_reniec"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Ubigeo RENIEC
                        </label>
                        <input
                            id="ubigeo_reniec"
                            v-model="form.ubigeo_reniec"
                            type="text"
                            placeholder="Código"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            for="ubigeo_inei"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Ubigeo INEI
                        </label>
                        <input
                            id="ubigeo_inei"
                            v-model="form.ubigeo_inei"
                            type="text"
                            placeholder="Código"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            for="ubigeo_sunat"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Ubigeo SUNAT
                        </label>
                        <input
                            id="ubigeo_sunat"
                            v-model="form.ubigeo_sunat"
                            type="text"
                            placeholder="Código"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            for="postal_code"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Código Postal
                        </label>
                        <input
                            id="postal_code"
                            v-model="form.postal_code"
                            type="text"
                            placeholder="12345"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label
                        for="address"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Dirección
                    </label>
                    <input
                        id="address"
                        v-model="form.address"
                        type="text"
                        placeholder="Dirección completa"
                        class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>
            </section>

            <!-- Sección: Información Adicional -->
            <section
                class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50"
            >
                <h2
                    class="text-xl font-semibold text-blue-800 mb-4 border-b pb-2"
                >
                    📚 Información Adicional
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="form-group">
                        <label
                            for="marital_status"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Estado Civil
                        </label>
                        <select
                            id="marital_status"
                            v-model="form.marital_status"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Seleccione</option>
                            <option value="soltero">Soltero(a)</option>
                            <option value="casado">Casado(a)</option>
                            <option value="divorciado">Divorciado(a)</option>
                            <option value="viudo">Viudo(a)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label
                            for="education_level"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Nivel Educativo
                        </label>
                        <select
                            id="education_level"
                            v-model="form.education_level"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">Seleccione</option>
                            <option value="primaria">Primaria</option>
                            <option value="secundaria">Secundaria</option>
                            <option value="tecnico">Técnico</option>
                            <option value="universitario">Universitario</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label
                            for="height"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Altura (cm)
                        </label>
                        <input
                            id="height"
                            v-model="form.height"
                            type="number"
                            placeholder="170"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div class="form-group">
                        <label
                            for="father"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Nombre del Padre
                        </label>
                        <input
                            id="father"
                            v-model="form.father"
                            type="text"
                            placeholder="Nombre completo"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            for="mother"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Nombre de la Madre
                        </label>
                        <input
                            id="mother"
                            v-model="form.mother"
                            type="text"
                            placeholder="Nombre completo"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label
                        for="restrictions"
                        class="block text-sm font-medium text-gray-700 mb-1"
                    >
                        Restricciones
                    </label>
                    <textarea
                        id="restrictions"
                        v-model="form.restrictions"
                        placeholder="Describa restricciones médicas o legales"
                        rows="3"
                        class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    ></textarea>
                </div>
            </section>

            <!-- Sección: Fechas clave -->
            <section
                class="mb-8 p-6 border border-blue-100 rounded-lg bg-blue-50"
            >
                <h2
                    class="text-xl font-semibold text-blue-800 mb-4 border-b pb-2"
                >
                    🗓️ Fechas Clave
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="form-group">
                        <label
                            for="registration_date"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Fecha de Registro
                        </label>
                        <input
                            id="registration_date"
                            v-model="form.registration_date"
                            type="date"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            for="issue_date"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Fecha de Emisión
                        </label>
                        <input
                            id="issue_date"
                            v-model="form.issue_date"
                            type="date"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            for="expiration_date"
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Fecha de Expiración
                        </label>
                        <input
                            id="expiration_date"
                            v-model="form.expiration_date"
                            type="date"
                            class="w-full px-4 py-2 border border-blue-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>
            </section>

            <!-- Botón de envío -->
            <div class="text-center">
                <button
                    type="submit"
                    class="bg-indigo-600 p-4 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg shadow transition duration-200 transform hover:scale-105"
                >
                    Enviar Registro
                </button>
            </div>
        </form>
    </div>
</template>
