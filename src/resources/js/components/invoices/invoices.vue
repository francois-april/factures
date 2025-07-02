<script setup>
import axios from "axios"
import { onMounted, ref } from "vue"
import { useRouter } from "vue-router"

const router = useRouter()

let invoices = ref([])

onMounted(async () => {
    getInvoices()
})

const getInvoices = async () => {
    let response = await axios.get("/api/get_invoices")

    invoices.value = response.data.invoices;
    console.log(invoices);
}

const newInvoice = async () => {
    let response = await axios.get("/api/create_invoice")

    console.log(response);
    router.push('/invoice/edit/' + response.data.invoice.id)
}

const editInvoice = async (id) => {

    router.push('/invoice/edit/' + id)
}
</script>

<template>
    <h2 class="text-4xl font-bold leading-none tracking-tight dark:text-white">Invoices</h2>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Customer name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Currency
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Discount rate
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Issued at
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Paid at
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" @click="newInvoice">New Invoice</button>
                    </th>
                </tr>
            </thead>
             <tbody>
                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200" v-for="invoice in invoices" :key="invoice.id">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{invoice.customer_name}}
                    </th>
                    <td class="px-6 py-4">
                        {{invoice.currency}}
                    </td>
                    <td class="px-6 py-4">
                        {{invoice.discount_rate}}%
                    </td>
                    <td class="px-6 py-4">
                        {{invoice.status}}
                    </td>
                    <td class="px-6 py-4">
                        {{invoice.issued_at}}
                    </td>
                    <td class="px-6 py-4">
                        {{invoice.paid_at}}
                    </td>
                    <td class="px-6 py-4">
                        <button type="button" @click="editInvoice(invoice.id)" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg py-2 px-4 rounded-l">Edit</button>
                    </td>
                </tr>
             </tbody>
        </table>
    </div>
</template>