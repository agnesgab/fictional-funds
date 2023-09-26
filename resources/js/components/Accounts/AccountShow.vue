<template>
    <div class="w-1/3 mb-4">
        <label for="account-id" class="block text-sm text-gray-500">Account ID</label>

        <input v-model.lazy="accountId" type="text" placeholder="12345" id="account-id"
               class="block mt-2 w-full placeholder-gray-400/70 rounded-lg border bg-white px-5 py-2.5 text-gray-700 focus:border-purple-400 focus:outline-none focus:ring focus:ring-purple-300 focus:ring-opacity-40"/>
    </div>

    <template v-if="account">
        <Account :account="account"/>
    </template>
    <div v-if="accountId && !account">Nothing found.</div>

</template>
<script>
import axios from "axios";
import Account from "./Account.vue";

export default {
    components: {
        Account,
    },
    data() {
        return {
            account: null,
            accountId: '',
        }
    },
    methods: {
        getAccount() {
            const accountId = this.accountId.trim();

            if (accountId) {
                axios.get(`/api/account/${this.accountId}`)
                    .then((response) => {
                        console.log(response.data.data[0]);
                        this.account = response.data.data[0];
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }

        },
    },
    watch: {
        accountId() {
            this.getAccount();
        }
    }
}
</script>
