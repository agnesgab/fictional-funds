<template>
    <div class="flow-root rounded-lg border border-gray-100 py-3 shadow-sm bg-white">
        <div class="-my-3 grid grid-cols-4 divide-x">
            <div class="flex flex-col items-center px-4 py-3.5">
                <div class="text-sm text-gray-500">User ID</div>
                <div class="text-gray-700 font-medium">{{ user.id }}</div>
            </div>
            <div class="flex flex-col items-center px-4 py-3.5">
                <div class="text-sm text-gray-500">Name</div>
                <div class="text-gray-700 font-medium">{{ user.name }}</div>
            </div>
            <div class="flex flex-col items-center px-4 py-3.5">
                <div class="text-sm text-gray-500">E-mail</div>
                <div class="text-gray-700 font-medium">{{ user.email }}</div>
            </div>
            <div class="flex flex-col items-center px-4 py-3.5">
                <div class="text-sm text-gray-500">Total Accounts</div>
                <div class="text-gray-700 font-medium">{{ user.accounts.length }}</div>
            </div>
        </div>
    </div>

    <template v-if="user.accounts.length > 0">
        <AccountIndex :accounts="user.accounts" :userId="user.id" />
    </template>
    <div v-else class="my-4">This user has no accounts.</div>

</template>
<script>
import AccountIndex from "../Accounts/AccountIndex.vue";

export default {
    components: {AccountIndex},
    props: {
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {};
    },
    methods: {},
};
</script>
