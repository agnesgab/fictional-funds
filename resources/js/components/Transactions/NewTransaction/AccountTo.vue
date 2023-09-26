<template>
    <div class="rounded-xl border bg-white p-4">
        <div class="inline-flex items-center w-full px-3 py-1 rounded-full gap-x-2 text-green-500 bg-green-100/60">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M10 3L4.5 8.5L2 6" stroke="currentColor" stroke-width="1.5"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            <h2 class="text-m font-normal">Receiver account: <span class="font-bold">{{ accountTo.id }}</span></h2>
        </div>

        <div class="flex flex-col">
            <div class="flex justify-between items-center mt-2 text-center">
                <span>Balance:</span>
                <span class="font-bold text-xl">{{ accountTo.balance }} {{ accountTo.currency.code }}</span>
            </div>
            <div class="flex justify-between items-center text-center">
                <span>Exchange rate:</span>
                <span class="font-bold">{{ accountTo.currency.exchange_rate }}</span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        accountTo: {
            type: Object,
            required: true,
        }
    },
}
</script>
