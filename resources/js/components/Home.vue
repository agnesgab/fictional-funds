<template>
    <section class="bg-white">
        <div class="mx-auto max-w-screen-xl px-4 py-12 sm:px-6 md:py-16 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                    Fictional Funds
                </h2>

                <p class="mt-4 text-gray-500 text-xl">
                    Are you ready to become the master of fictional funds world? With this platform, you
                    have all the power! Experience the thrill of sending funds to multiple accounts, all from the
                    comfort of your localhost.
                </p>
            </div>

            <div class="mt-8">
                <dl class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div
                        class="flex flex-col rounded-lg border border-gray-100 px-4 py-8 text-center"
                    >

                        <dt class="order-last flex flex-col text-lg font-medium text-gray-500">
                            <span>Total Users</span>
                            <router-link to="/users" class="text-blue-600 transition-colors duration-300 transform mx-1.5 sm:mx-6">
                                View
                            </router-link>
                        </dt>

                        <dd class="text-6xl font-extrabold text-blue-600">
                            {{ users }}
                        </dd>
                    </div>

                    <div
                        class="flex flex-col rounded-lg border border-gray-100 px-4 py-8 text-center"
                    >
                        <dt class="order-last flex flex-col text-lg font-medium text-gray-500">
                            <span>Total Accounts</span>
                            <router-link to="/accounts" class="text-blue-600 transition-colors duration-300 transform mx-1.5 sm:mx-6">
                                View
                            </router-link>
                        </dt>

                        <dd class="text-6xl font-extrabold text-blue-600">{{ accounts }}</dd>
                    </div>

                    <div
                        class="flex flex-col rounded-lg border border-gray-100 px-4 py-8 text-center"
                    >
                        <dt class="order-last flex flex-col text-lg font-medium text-gray-500">
                            <span>Total Transactions</span>
                            <router-link to="/new-transaction" class="text-blue-600 transition-colors duration-300 transform mx-1.5 sm:mx-6">
                                Create
                            </router-link>
                        </dt>

                        <dd class="text-6xl font-extrabold text-blue-600">{{ transactions }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            users: '',
            accounts: '',
            transactions: '',
        };
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            axios.get('/api/').then((response) => {
                this.users = response.data.users;
                this.accounts = response.data.accounts;
                this.transactions = response.data.transactions;
            });
        },
    },
}
</script>
