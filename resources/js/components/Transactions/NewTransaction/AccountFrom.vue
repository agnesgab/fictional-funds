<template>
    <div class="rounded-xl border bg-white p-4">
        <div class="inline-flex items-center w-full px-3 py-1 rounded-full gap-x-2 text-blue-500 bg-blue-100/60">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <path d="M10 3L4.5 8.5L2 6" stroke="currentColor" stroke-width="1.5"
                      stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

            <h2 class="text-m font-normal">Sender account: <span class="font-bold">{{ accountFrom.id }}</span></h2>
        </div>

        <div class="flex flex-col">
            <div class="flex justify-between items-center mt-2 text-center">
                <span>Balance:</span>
                <span class="font-bold text-xl">{{ accountFrom.balance }} {{ accountFrom.currency.code }}</span>
            </div>
            <div class="flex justify-between items-center text-center">
                <span>Exchange rate:</span>
                <span class="font-bold">{{ accountFrom.currency.exchange_rate }}</span>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    props: {
        accountFrom: {
            type: Object,
            required: true,
        }
    },
}
</script>
