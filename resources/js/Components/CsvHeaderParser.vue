<script setup>
import { ref } from 'vue';

defineProps({
    modelValue: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['update:modelValue']);

const fileInput = ref(null);
const fileName = ref('');
const error = ref('');

const parseLine = (line) => {
    // Handle quoted values with commas inside
    const values = [];
    let current = '';
    let inQuotes = false;
    
    for (let i = 0; i < line.length; i++) {
        const char = line[i];
        
        if (char === '"') {
            inQuotes = !inQuotes;
        } else if (char === ',' && !inQuotes) {
            values.push(current.trim().replace(/^"|"$/g, ''));
            current = '';
        } else {
            current += char;
        }
    }
    // Push the last value
    values.push(current.trim().replace(/^"|"$/g, ''));
    
    return values;
};

const parseCsv = (csvText) => {
    const lines = csvText.split(/\r?\n/).filter(line => line.trim());
    
    if (lines.length === 0) {
        return [];
    }
    
    const headers = parseLine(lines[0]);
    
    // Parse data rows (skip header line)
    const rows = [];
    for (let i = 1; i < lines.length; i++) {
        const values = parseLine(lines[i]);
        const row = {};
        
        headers.forEach((header, index) => {
            row[header] = values[index] !== undefined ? values[index] : '';
        });
        
        rows.push(row);
    }
    
    return rows;
};

const handleFileChange = (event) => {
    const file = event.target.files[0];
    error.value = '';
    
    if (!file) {
        fileName.value = '';
        emit('update:modelValue', []);
        return;
    }
    
    if (!file.name.endsWith('.csv')) {
        error.value = 'Please select a CSV file';
        fileName.value = '';
        emit('update:modelValue', []);
        return;
    }
    
    fileName.value = file.name;
    
    const reader = new FileReader();
    reader.onload = (e) => {
        const text = e.target.result;
        const rows = parseCsv(text);
        emit('update:modelValue', rows);
    };
    reader.onerror = () => {
        error.value = 'Error reading file';
        emit('update:modelValue', []);
    };
    reader.readAsText(file);
};

const clearFile = () => {
    if (fileInput.value) {
        fileInput.value.value = '';
    }
    fileName.value = '';
    error.value = '';
    emit('update:modelValue', []);
};
</script>

<template>
    <div class="csv-header-parser">
        <div class="flex items-center gap-3">
            <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <span>Choose CSV File</span>
                <input
                    ref="fileInput"
                    type="file"
                    accept=".csv"
                    class="hidden"
                    @change="handleFileChange"
                />
            </label>
            <span v-if="fileName" class="text-sm text-gray-600">{{ fileName }}</span>
            <button
                v-if="fileName"
                type="button"
                class="text-sm text-red-600 hover:text-red-800"
                @click="clearFile"
            >
                Clear
            </button>
        </div>
        <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
    </div>
</template>
