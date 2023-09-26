<template>
    <div class="flow-root rounded-lg border border-gray-100 py-3 shadow-sm bg-white">
        <div class="-my-3 grid grid-cols-5 divide-x">
            <div class="flex flex-col items-center px-4 py-3.5">
                <div class="text-sm text-gray-500">Account ID</div>
                <div class="text-gray-700 font-medium">{{ account.id }}</div>
            </div>
            <div class="flex flex-col items-center px-4 py-3.5">
                <div class="text-sm text-gray-500">Currency</div>
                <div class="text-gray-700 font-medium">{{ account.currency.code}}</div>
            </div>
            <div class="flex flex-col items-center px-4 py-3.5">
                <div class="text-sm text-gray-500">Managed by user</div>
                <div class="text-gray-700 font-medium">{{ account.user.id }}</div>
            </div>
            <div class="flex flex-col items-center px-4 py-3.5">
                <div class="text-sm text-gray-500">Balance</div>
                <div class="text-gray-700 font-medium">{{ account.balance }} {{ account.currency.code}}</div>
            </div>
            <div class="flex flex-col items-center px-4 py-3.5">
                <div class="text-sm text-gray-500">Total transactions</div>
                <div class="text-gray-700 font-medium">{{ account.total_transactions }}</div>
            </div>
        </div>
    </div>

    <template v-if="account.total_transactions > 0">
        <TransactionIndex :transactions="account.all_transactions" :accountId="account.id" :currency="account.currency.code"/>
    </template>
    <div v-else class="my-4">This account has no transactions.</div>

</template>
<script>
import TransactionIndex from "../Transactions/TransactionIndex.vue";

export default {
    components: {TransactionIndex},
    props: {
        account: {
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
