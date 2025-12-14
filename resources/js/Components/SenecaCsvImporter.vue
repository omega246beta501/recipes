<script>

    import {VueCsvToggleHeaders, VueCsvSubmit, VueCsvMap, VueCsvInput, VueCsvErrors, VueCsvImport} from 'vue-csv-import';
    import { Link } from '@inertiajs/vue3'
    export default {
        components: {VueCsvToggleHeaders, VueCsvSubmit, VueCsvMap, VueCsvInput, VueCsvErrors, VueCsvImport, Link},
        data() {
            return {
                csv: null,
                fields: null
            };
        },
        props: {
            headers: {
                type: Array,
                default: () => []
            },
            firstCsvData: {
                type: Array,
            }
        },
        mounted() {
            // Map the headers prop to construct the fields object expected by vue-csv-import
            if (Array.isArray(this.headers) && this.headers.length > 0) {
                this.fields = this.headers.reduce((acc, header) => {
                    header = header.replace(/\./g, ' ').trim();
                    acc[header] = { required: false, label: header };
                    return acc;
                }, {});
            }
        },
        methods: {
        }
    }

    </script>
    
    
    <template>
        <vue-csv-import
        v-if="fields"
        v-slot="{file}"
        v-model="csv"
        :fields="fields"
    >
        <vue-csv-toggle-headers></vue-csv-toggle-headers>
        <vue-csv-errors></vue-csv-errors>
        <vue-csv-input></vue-csv-input>
        <vue-csv-map :auto-match="false"></vue-csv-map>
    </vue-csv-import>
    <Link :href="route('seneca.import')" method="post" as="button" :data="{firstCsv: firstCsvData, secondCsv: csv}" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
        Compara ambos archivos
    </Link>
    <pre class="mt-15" v-if="csv"><code>{{ csv }}</code></pre>
    </template>
    