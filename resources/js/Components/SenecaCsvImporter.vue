<script>
import { VueCsvToggleHeaders, VueCsvSubmit, VueCsvMap, VueCsvInput, VueCsvErrors, VueCsvImport } from 'vue-csv-import';
import { Link } from '@inertiajs/vue3';

export default {
    components: {
        VueCsvToggleHeaders,
        VueCsvSubmit,
        VueCsvMap,
        VueCsvInput,
        VueCsvErrors,
        VueCsvImport,
        Link,
    },
    props: {
        headers: {
            type: Array,
            default: () => [],
        },
        firstCsvData: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            csv: null,
            fields: null,
        };
    },
    computed: {
        canSubmit() {
            return this.csv && Array.isArray(this.csv) && this.csv.length > 0 && this.firstCsvData && Array.isArray(this.firstCsvData) && this.firstCsvData.length > 0;
        },
    },
    mounted() {
        // Map the headers prop to construct the fields object expected by vue-csv-import
        if (Array.isArray(this.headers) && this.headers.length > 0) {
            this.fields = this.headers.reduce((acc, header) => {
                const sanitizedHeader = header.replace(/\./g, ' ').trim();
                acc[sanitizedHeader] = { required: false, label: sanitizedHeader };
                return acc;
            }, {});
        }
    },
    methods: {
        handleSubmit() {
            if (!this.canSubmit) {
                return;
            }
            // The Link component will handle the submission
        },
    },
};
</script>

<template>
    <div class="seneca-csv-importer">
        <vue-csv-import
            v-if="fields"
            v-slot="{ file }"
            v-model="csv"
            :fields="fields"
        >
            <vue-csv-toggle-headers></vue-csv-toggle-headers>
            <vue-csv-errors></vue-csv-errors>
            <vue-csv-input></vue-csv-input>
            <vue-csv-map :auto-match="false"></vue-csv-map>
        </vue-csv-import>

        <div v-if="!fields" class="mt-4 text-sm text-gray-500">
            No headers available. Please configure headers first.
        </div>

        <Link
            v-if="fields"
            :href="route('seneca.import')"
            method="post"
            as="button"
            :data="{ firstCsv: firstCsvData, secondCsv: csv }"
            :disabled="!canSubmit"
            class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors"
            @click="handleSubmit"
        >
            Compara ambos archivos
        </Link>

        <div v-if="!canSubmit && csv" class="mt-2 text-sm text-amber-600">
            Por favor, asegúrate de que ambos archivos CSV tengan datos.
        </div>
    </div>
</template>