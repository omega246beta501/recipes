<script>

import {VueCsvToggleHeaders, VueCsvSubmit, VueCsvMap, VueCsvInput, VueCsvErrors, VueCsvImport} from 'vue-csv-import';
import CsvHeaderParser from '@/Components/CsvHeaderParser.vue';
import SenecaCsvImporter from '@/Components/SenecaCsvImporter.vue';
import StringListDeleter from '@/Components/StringListDeleter.vue';


export default {
    components: {VueCsvToggleHeaders, VueCsvSubmit, VueCsvMap, VueCsvInput, VueCsvErrors, VueCsvImport, CsvHeaderParser, SenecaCsvImporter, StringListDeleter},
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
                if(newVal.length > 0) {
                    let firstRow = newVal[0];
                    this.firstCsvHeaders = Object.keys(firstRow)
                }
            }
        }
    },
    methods: {
        handleFieldsSet(headers) {
            this.hasFieldsBeenSet = true;
            this.firstCsvHeaders = headers;
        }
    }

}
</script>


<template>
    <CsvHeaderParser v-if="firstCsvData.length == 0" v-model="firstCsvData" />
    <StringListDeleter v-if="!hasFieldsBeenSet && firstCsvHeaders.length > 0" :items="firstCsvHeaders" @deletion-confirmed="handleFieldsSet" />
    
    <SenecaCsvImporter v-if="hasFieldsBeenSet && firstCsvHeaders.length > 0" :headers="firstCsvHeaders" :firstCsvData="firstCsvData"/>

</template>
