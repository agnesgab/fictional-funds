<template>
    <div class="w-1/3 font-medium text-xl text-center mb-2">
        Set the sender and receiver account IDs, specify the amount of money for the transfer, and finalize the
        transaction.
    </div>
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="w-full border-black">
            <label for="account-from-id" class="block text-sm text-gray-500">Account ID from:</label>

            <input v-model.lazy="accountIdFrom" type="text" placeholder="12345" id="account-from-id"
                   class="block mt-2 w-full placeholder-gray-400/70 rounded-lg border bg-white px-5 py-2.5 text-gray-700 focus:border-purple-400 focus:outline-none focus:ring focus:ring-purple-300 focus:ring-opacity-40"/>
        </div>

        <div class="w-full border-black">
            <label for="account-to-id" class="block text-sm text-gray-500">Account ID to:</label>

            <input v-model.lazy="accountIdTo" type="text" placeholder="12345" id="account-to-id"
                   class="block mt-2 w-full placeholder-gray-400/70 rounded-lg border bg-white px-5 py-2.5 text-gray-700 focus:border-purple-400 focus:outline-none focus:ring focus:ring-purple-300 focus:ring-opacity-40"/>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 w-1/2">
        <template v-if="accountFrom">
            <AccountFrom :accountFrom="accountFrom"/>
        </template>
        <div v-if="accountIdFrom && !accountFrom">Nothing found.</div>

        <template v-if="accountTo">
            <AccountTo :accountTo="accountTo"/>
        </template>
        <div v-if="accountIdTo && !accountTo">Nothing found.</div>
    </div>

    <TransactionForm
        v-if="accountFrom && accountTo" :accountFrom="accountFrom" :accountTo="accountTo"/>
</template>
<script>
import axios from "axios";
import AccountFrom from "./NewTransaction/AccountFrom.vue";
import AccountTo from "./NewTransaction/AccountTo.vue";
import TransactionForm from "./NewTransaction/TransactionForm.vue";

export default {
    components: {
        AccountFrom,
        AccountTo,
        TransactionForm,
    },
    data() {
        return {
            accountFrom: null,
            accountTo: null,
            accountIdFrom: '',
            accountIdTo: '',
        }
    },
    methods: {
        getAccount(accountId, targetProperty) {
            accountId.trim();

            if (accountId) {
                axios.get(`/api/account/${accountId}`).then((response) => {
                    console.log(response.data.data[0]);
                    this[targetProperty] = response.data.data[0];
                })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
    },
    watch: {
        accountIdFrom(accountId) {
            this.getAccount(accountId, 'accountFrom');
        },
        accountIdTo(accountId) {
            this.getAccount(accountId, 'accountTo');
        },
    }
}
</script>
