<template>
    <section class="container px-4 mx-auto my-10">
        <div class="flex flex-col items-end gap-1 px-8 my-2">
            <span class="text-gray-500">
                Rows per page:
            </span>
            <div class="flex gap-1">
                <button v-for="(option, index) in limitOptions" :key="index" @click="limit = option" :class="limit === option ? 'bg-blue-600 text-white' : ''"
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
                                    Account ID
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Title
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Balance
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Currency
                                </th>

                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Total transactions
                                </th>
                                <th scope="col"
                                    class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                                    Created at
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="(account, index) in displayedAccounts" :key="index">
                                <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                    <div class="inline-flex items-center gap-x-3">
                                        <span>{{ account.id }}</span>
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ account.title }}
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ account.balance }}
                                </td>

                                <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ account.currency.code }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    {{ account.transactions_total_count }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    <div class="flex justify-between">
                                        <span>{{ account.datetime }}</span>
                                    </div>

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

                    <button v-for="pageNumber in pageNumbers" :key="pageNumber" @click="goToPage(pageNumber)" :class="currentPage === pageNumber ? 'bg-blue-600 text-white' : ''" class="items-center hidden px-4 py-2 mx-1 text-gray-700 transition-colors duration-300 transform bg-white rounded-md sm:flex">
                        {{ pageNumber }}
                    </button>

                    <button @click="nextPage" class="flex items-center px-4 py-2 text-gray-700 transition-colors duration-300 transform bg-white rounded-md">
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
        accounts: {
            type: Array,
            required: true,
        },
        userId: {
            type: Number,
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
            return Math.ceil(this.accounts.length / this.limit);
        },
        displayedAccounts() {
            const startIndex = this.offset;
            const endIndex = startIndex + this.limit;
            return this.accounts.slice(startIndex, endIndex);
        },
        pageNumbers() {
            return Array.from({ length: this.totalPages }, (_, index) => index + 1);
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
        userId(newId, previousId) {
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
        },
    },
}
</script>
