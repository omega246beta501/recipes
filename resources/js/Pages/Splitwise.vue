<script>
import { Head } from '@inertiajs/vue3';
import "@/assets/splitwise-css.css";
import MemberCard from "@/Components/Splitwise/MemberCard.vue"
import GroupCard from "@/Components/Splitwise/GroupCard.vue"
import CategoryCard from "@/Components/Splitwise/CategoryCard.vue"

export default {
    components: { Head, MemberCard, GroupCard, CategoryCard },
    data() {
        return {
            selectedGroup: {},
            selectedCategory: {},
            selectedMember: {},
            isGroupCardEnabled: false,
            isMemberCardEnabled: false,
            isCategoryCardEnabled: false,
            description: null,
            cost: null,
            date: '',
        }
    },
    computed: {
    },
    props: {
        groups: Array,
        categories: Array,
        members: Array,
    },
    created() {
        this.selectedGroup = this.groups[0];
        this.selectedCategory = this.categories[5].subcategories[0];
        this.selectedMember = this.members[Math.floor(Math.random() * this.members.length)]
    },
    beforeDestroy() {
    },
    methods: {
        updateSelectedMember(newMember) {
            this.selectedMember = newMember
        },
        updateSelectedGroup(newGroup) {
            this.selectedGroup = newGroup
        },
        updateSelectedCategory(newCategory) {
            this.selectedCategory = newCategory
        },
        toggleMemberCard() {
            this.isMemberCardEnabled = !this.isMemberCardEnabled
        },
        toggleGroupCard() {
            this.isGroupCardEnabled = !this.isGroupCardEnabled
        },
        toggleCategoryCard() {
            this.isCategoryCardEnabled = !this.isCategoryCardEnabled
        },
        validateData() {
            // Check if the object fields are not empty
            if (Object.keys(this.selectedGroup).length === 0) return false;
            if (Object.keys(this.selectedMember).length === 0) return false;
            if (Object.keys(this.selectedCategory).length === 0) return false;
            // Check if cost, description, and date are provided
            if (this.cost === null || this.cost === '' || this.cost == 0) return false;
            if (!this.description || this.description === '') return false;
            if (!this.date) return false;
            return true;
        },
        async createExpense() {
            try {
                if (!this.validateData()) {
                    alert("Faltan datos")
                    return
                }
    
                const data = {
                    group: this.selectedGroup,
                    member: this.selectedMember,
                    category: this.selectedCategory,
                    cost: this.cost,
                    description: this.description,
                    date: this.date
                };
                const response = await fetch(route('createExpense'), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                // Check if the response is ok.
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                // Notify the user of success and reload the page.
                alert('Se ha creado un cargo en Splitwise');
                location.reload();

            }catch (error) {
                // Handle any errors that occur during the fetch.
                console.error('Error creating expense:', error);
                alert('Ha ocurrido un error al crear el cargo. Por favor, intente nuevamente.');
            }
        }
    }
}
</script>
<style scoped></style>

<template>
    <div class="modal fade transparent in" id="add_bill"
        style="width: 352px;margin-left: -176px;z-index: 1050;display: block;">
        <div class="relative-container">
            <div class="input-data"></div>
            <div class="main-window">
                <header>
                    Add an expense
                </header>
                <div class="body">
                    <div class="main_fields">
                        <img @click="toggleCategoryCard()" :src="selectedCategory.icon"
                            class="category">
                        <input type="text" class="description" placeholder="Enter a description" v-model="description"
                            style="font-size: 20px;">
                        <div id="_size-changing-clone" style="font-size: 20px; position: absolute; left: -9999px; font-family: Lato, &quot;Helvetica Neue&quot;, Helvetica, Arial, sans-serif;">
                        </div>
                        <div class="cost_container">
                            <span class="currency_code">€</span><input type="text" class="cost" placeholder="0.00" v-model="cost">
                        </div>
                    </div>

                    <div class="human_summary">
                            Paid by <a @click="toggleMemberCard()" class="payer">{{ selectedMember.name }}</a> and split <a class="split">equally</a>&ZeroWidthSpace;.
                    </div>
                    <div>
                        <input v-model="date" type="date" class="date slim-button"></input>
                    </div>
                    <div>
                        <a @click="toggleGroupCard()" class="group slim-button">{{ selectedGroup.name }}</a>
                    </div>

                </div>
                <footer>
                    <button @click="createExpense()" class="btn btn-large btn-mint submit">
                        Save
                    </button>
                </footer>
            </div>
            <CategoryCard id="choose_category" :class="['subview', { active: isCategoryCardEnabled}]" :categories="categories" :selectedCategory="selectedCategory" @close-card="toggleCategoryCard" @change-category="updateSelectedCategory"></CategoryCard>
            <MemberCard id="choose_payer" :class="['subview', { active: isMemberCardEnabled}]" :members="members" :selectedMember="selectedMember" @change-member="updateSelectedMember" @close-card="toggleMemberCard"></MemberCard>
            <GroupCard id="choose_group" :class="['subview', { active: isGroupCardEnabled}]" :groups="groups" :selectedGroup="selectedGroup" @change-group="updateSelectedGroup" @close-card="toggleGroupCard"></GroupCard>
        </div>
    </div>
</template>
