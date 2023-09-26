<template>
    <div class="w-1/3 mb-4">
        <label for="user-id" class="block text-sm text-gray-500">User ID</label>

        <input v-model.lazy="userId" type="text" placeholder="12345" id="user-id"
               class="block mt-2 w-full placeholder-gray-400/70 rounded-lg border bg-white px-5 py-2.5 text-gray-700 focus:border-purple-400 focus:outline-none focus:ring focus:ring-purple-300 focus:ring-opacity-40"/>
    </div>

    <template v-if="user">
        <User :user="user"/>
    </template>
    <div v-if="userId && !user">Nothing found.</div>

</template>
<script>
import axios from "axios";
import User from "./User.vue";

export default {
    components: {
        User,
    },
    data() {
        return {
            user: null,
            userId: '',
        }
    },
    methods: {
        getUser() {
            const userId = this.userId.trim();

            if (userId) {
                axios.get(`/api/user/${this.userId}`)
                    .then((response) => {
                        console.log(response.data.data[0]);
                        this.user = response.data.data[0];
                    })
                    .catch((error) => {
                        console.error(error);
                    });
            }
        },
    },
    watch: {
        userId() {
            this.getUser();
        }
    }
}
</script>
