<template>
    <section class="container px-4 mx-auto my-10">
        <div class="flex flex-col items-end gap-1 px-8 my-2">
            <span class="text-gray-500">
                Rows per page:
            </span>
            <div class="flex gap-1">
                <button v-for="(option, index) in limitOptions" :key="index" @click="limit = option"
                        :class="limit === option ? 'font-bold' : ''"
                        class="items-center hidden px-4 py-2 text-gray-700 transition-colors duration-300 transform bg-white rounded-md sm:flex">
                    {{ option }}
                </button>
            </div>
        </div>

        <div class="flex flex-col items-center">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 w-full">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden border border-gray-200 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Transaction ID
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Type
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Amount
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Amount in base currency
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Sender
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Receiver
                                </th>
                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Date and time
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(transaction, index) in displayedTransactions" :key="index">
                                <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-x-3">
                                        <span>{{ transaction.id }}</span>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                    <div class="inline-flex items-center px-3 py-1 rounded-full gap-x-2"
                                         :class="transaction.sender_account_id === accountId ? 'text-blue-500 bg-blue-100/60' : 'text-green-500 bg-green-100/60'">
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10 3L4.5 8.5L2 6" stroke="currentColor" stroke-width="1.5"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                        <h2 class="text-sm font-normal">
                                            {{ transaction.sender_account_id === accountId ? 'Sent' : 'Received' }}</h2>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <div><span>Sent:</span> {{ transaction.amount_in_sender_currency }}
                                            <span>{{
                                                    transaction.sender ? transaction.sender.currency.code : currency
                                                }}</span>
                                        </div>
                                        <div><span>Received:</span> {{ transaction.amount_in_receiver_currency }}
                                            <span>{{
                                                    transaction.receiver ? transaction.receiver.currency.code : currency
                                                }}</span></div>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ transaction.amount_in_base_currency }} EUR
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ transaction.sender_account_id }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ transaction.receiver_account_id }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ transaction.datetime }}
                                </td>
                            </tr>
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>

            <div class="flex justify-between my-2 px-8 w-full">
                <div class="flex">
                    <button @click="prevPage" class="flex items-center px-4 py-2 text-gray-500 bg-white rounded-md">
                        Previous
                    </button>

                    <button v-for="pageNumber in pageNumbers" :key="pageNumber" @click="goToPage(pageNumber)"
                            :class="currentPage === pageNumber ? 'font-bold' : ''"
                            class="items-center hidden px-4 py-2 mx-1 text-gray-700 transition-colors duration-300 transform bg-white rounded-md sm:flex">
                        {{ pageNumber }}
                    </button>

                    <button @click="nextPage"
                            class="flex items-center px-4 py-2 text-gray-700 transition-colors duration-300 transform bg-white rounded-md">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    props: {
        transactions: {
            type: Array,
            required: true,
        },
        accountId: {
            type: Number,
            required: true,
        },
        currency: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            currentPage: 1,
            offset: 0,
            limit: 5,
            limitOptions: [5, 10, 20],
        };
    },
    created() {
        this.updateOffset();
    },
    computed: {
        totalPages() {
            return Math.ceil(this.transactions.length / this.limit);
        },
        displayedTransactions() {
            const startIndex = this.offset;
            const endIndex = startIndex + this.limit;
            return this.transactions.slice(startIndex, endIndex);
        },
        pageNumbers() {
            return Array.from({length: this.totalPages}, (_, index) => index + 1);
        },
    },
    methods: {
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
                this.updateOffset();
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
                this.updateOffset();
            }
        },
        goToPage(pageNumber) {
            this.currentPage = pageNumber;
            this.updateOffset();
        },
        updateOffset() {
            this.offset = (this.currentPage - 1) * this.limit;
        },
    },
    watch: {
        accountId(newId, previousId) {
            if (newId !== previousId) {
                this.currentPage = 1;
                this.updateOffset();
            }
        },
        transactions() {
            this.updateOffset();
        },
        limit() {
            this.updateOffset();
            this.goToPage(1);
        },
    },
};
</script>
