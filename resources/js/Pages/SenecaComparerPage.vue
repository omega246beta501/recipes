<script>
import CsvHeaderParser from '@/Components/CsvHeaderParser.vue';
import SenecaCsvImporter from '@/Components/SenecaCsvImporter.vue';
import StringListDeleter from '@/Components/StringListDeleter.vue';
import { Head } from '@inertiajs/vue3';

export default {
    components: {
        CsvHeaderParser,
        SenecaCsvImporter,
        StringListDeleter,
        Head,
    },
    data() {
        return {
            csv: null,
            firstCsvData: [],
            firstCsvHeaders: [],
            hasFieldsBeenSet: false,
        };
    },
    watch: {
        firstCsvData: {
            handler(newVal) {
                if (Array.isArray(newVal) && newVal.length > 0 && newVal[0]) {
                    const firstRow = newVal[0];
                    this.firstCsvHeaders = Object.keys(firstRow);
                } else {
                    this.firstCsvHeaders = [];
                    this.hasFieldsBeenSet = false;
                }
            },
            immediate: true,
        },
    },
    methods: {
        handleFieldsSet(headers) {
            if (Array.isArray(headers) && headers.length > 0) {
                this.hasFieldsBeenSet = true;
                this.firstCsvHeaders = headers;
            }
        },
    },
};
</script>

<template>
    <Head title="Seneca CSV Comparer" />

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Seneca CSV Comparer</h1>

            <div class="space-y-6">
                <!-- Step 1: Upload first CSV -->
                <div v-if="firstCsvData.length === 0" class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Paso 1: Sube el primer archivo CSV</h2>
                    <CsvHeaderParser v-model="firstCsvData" />
                </div>

                <!-- Step 2: Select headers to remove -->
                <div v-if="!hasFieldsBeenSet && firstCsvHeaders.length > 0" class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Paso 2: Selecciona los encabezados a eliminar</h2>
                    <StringListDeleter :items="firstCsvHeaders" @deletion-confirmed="handleFieldsSet" />
                </div>

                <!-- Step 3: Upload and compare second CSV -->
                <div v-if="hasFieldsBeenSet && firstCsvHeaders.length > 0" class="bg-white shadow rounded-lg p-6">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Paso 3: Sube el segundo archivo CSV para comparar</h2>
                    <SenecaCsvImporter :headers="firstCsvHeaders" :first-csv-data="firstCsvData" />
                </div>
            </div>
        </div>
    </div>
</template>
