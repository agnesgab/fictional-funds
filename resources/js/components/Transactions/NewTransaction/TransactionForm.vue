<template>
    <div v-if="!transactionCompleted" class="rounded-xl border bg-white p-4 my-2 w-1/2">
        <div class="w-full border-black flex flex-col items-center">

            <div class="mb-4">
                <label for="amount" class="block text-sm text-gray-500">Transfer amount:</label>

                <div class="flex items-center mt-2">
                    <p class="py-2.5 px-3 text-gray-500 bg-gray-100 border border-r-0 rtl:rounded-r-lg rtl:rounded-l-none rtl:border-l-0 rtl:border-r rounded-l-lg">{{ accountFrom.currency.code }}</p>
                    <input v-model="amountToSend" type="text" placeholder="" id="amount" class="block w-full rounded-l-none rtl:rounded-l-lg rtl:rounded-r-none placeholder-gray-400/70 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40" />
                </div>
            </div>

            <div v-if="updatedBalance && updatedBalance < 0" class="text-red-500">
                There are not enough funds in sender's account.
            </div>
            <div v-if="amountToSend && updatedBalance > 0">
                <button @click="completeTransaction"
                        class="bg-blue-500 text-white flex items-center px-4 py-2 transition-colors duration-300 transform rounded-md">
                    Complete transaction
                </button>
            </div>
        </div>

        <div v-if="transactionError" class="text-center mt-2">
            <span class="text-red-500">{{ transactionError }}</span>
        </div>
    </div>

    <template v-else>
        <TransactionSuccess></TransactionSuccess>
    </template>
</template>
<script>
import axios from "axios";
import TransactionSuccess from "./TransactionSuccess.vue";

export default {
    components: {TransactionSuccess},
    emits: ['transaction-completed'],
    data() {
        return {
            amountToSend: null,
            updatedBalance: null,
            transactionAllowed: false,
            transactionError: null,
        }
    },
    props: {
        accountFrom: {
            type: Object,
            required: true,
        },
        accountTo: {
            type: Object,
            required: true,
        },
        transactionCompleted: {
            type: Boolean,
            required: true,
        }
    },
    methods: {
        updateAccountBalance() {
            this.updatedBalance = this.accountFrom.balance - this.amountToSend;

            if (this.updatedBalance > 0) {
                this.transactionAllowed = true;
            }
        },
        completeTransaction() {
            axios.post('api/complete-transaction', {
                from: this.accountFrom.id,
                to: this.accountTo.id,
                amount: this.amountToSend,
            }) // Adjust the URL to match your API route
                .then((response) => {
                    if (response.data === true) {
                        this.$emit('transaction-completed', true);
                    } else {
                        this.transactionError = 'Transaction failed. Please try again.'
                        this.amountToSend = null;
                    }
                })
                .catch((error) => {
                    console.error(error);
                });
        },
    },
    watch: {
        amountToSend() {
            this.updateAccountBalance();
        }
    },
}
</script>
