<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
    items: {
        type: Array,
        default: () => [],
    },
});

const emit = defineEmits(['deletion-confirmed']);

const markedForDeletion = ref(new Set());

const remainingItems = computed(() => {
    return props.items.filter((_, index) => !markedForDeletion.value.has(index));
});

const deletionCount = computed(() => markedForDeletion.value.size);

const toggleDeletion = (index) => {
    const newSet = new Set(markedForDeletion.value);
    if (newSet.has(index)) {
        newSet.delete(index);
    } else {
        newSet.add(index);
    }
    markedForDeletion.value = newSet;
};

const isMarkedForDeletion = (index) => {
    return markedForDeletion.value.has(index);
};

const confirmDeletion = () => {
    emit('deletion-confirmed', remainingItems.value);
    markedForDeletion.value = new Set();
};
</script>

<template>
    <div class="string-list-deleter">
        <ul v-if="items.length > 0" class="divide-y divide-gray-200 border border-gray-200 rounded-md">
            <li
                v-for="(item, index) in items"
                :key="index"
                class="flex items-center justify-between px-4 py-3 hover:bg-gray-50 transition-colors"
                :class="{ 'bg-red-50 line-through text-gray-400': isMarkedForDeletion(index) }"
            >
                <span class="text-sm">{{ item }}</span>
                <button
                    type="button"
                    class="text-sm px-3 py-1 rounded-md transition-colors"
                    :class="isMarkedForDeletion(index)
                        ? 'bg-gray-200 text-gray-700 hover:bg-gray-300'
                        : 'bg-red-100 text-red-700 hover:bg-red-200'"
                    @click="toggleDeletion(index)"
                >
                    {{ isMarkedForDeletion(index) ? 'Undo' : 'Delete' }}
                </button>
            </li>
        </ul>

        <p v-else class="text-sm text-gray-500 italic">No items to display.</p>

        <div v-if="items.length > 0" class="mt-4 flex items-center justify-between">
            <span v-if="deletionCount > 0" class="text-sm text-gray-600">
                {{ deletionCount }} item(s) marked for deletion
            </span>
            <span v-else class="text-sm text-gray-400">
                No items marked for deletion
            </span>

            <button
                type="button"
                class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50 disabled:cursor-not-allowed"
                :disabled="deletionCount === 0"
                @click="confirmDeletion"
            >
                Confirm Deletion
            </button>
        </div>
    </div>
</template>

