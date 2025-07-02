<script setup>
import axios from "axios"
import { onMounted, ref} from "vue"
import { useRouter } from "vue-router"

const router = useRouter();

let form = ref({ id: '' })

const tableRows = ref([])
const invoice = ref([])
const dates = ref([])
const totals = ref([])

const props = defineProps({
    id: {
        type: String,
        default: ''
    }
})

onMounted(async () => {
    getInvoice()
})

const getInvoice = async () => {
    let response = await axios.get(`/api/get_invoice_details/${props.id}`)
    form.value = response.data.invoice
    tableRows.value = response.data.tableRows
    invoice.value = response.data.invoice
    dates.value = response.data.dates
    totals.value = response.data.totals
    console.log(response.data.dates)
}
const insertRow = () => {
      tableRows.value.push(
        {
        "linePosition": tableRows.value.length+1,
        "id": null,
        "description": '',
        "quantity": 0,
        "unit_price": 0
        }
      )
      console.log('tableRows', tableRows)
}

const updateInvoice = async () => {
  const invoiceFormData = new FormData()
  invoiceFormData.append('id', invoice.value.id)
  invoiceFormData.append('customer_name', invoice.value.customer_name)
  invoiceFormData.append('currency', invoice.value.currency)
  invoiceFormData.append('discount_rate', invoice.value.discount_rate)
  invoiceFormData.append('status', invoice.value.status)
  invoiceFormData.append('date_issued', dates.value.issued_at)
  invoiceFormData.append('date_due', dates.value.due_at)
  invoiceFormData.append('invoice_lines', JSON.stringify(tableRows.value))
  console.log(invoiceFormData)

  let response = await axios.post("/api/update_invoice", invoiceFormData)

  getInvoice()
}

const backToMainPage = async () => {
router.back()
}

</script>

<template>
  <div class="bg-white border border-4 rounded-lg shadow relative m-10">
    <button type="button" @click.stop="backToMainPage" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg py-2 px-4 rounded-l">Back</button>
    <div class="flex items-start justify-between p-5 border-b rounded-t">
        <h3 class="text-xl font-semibold">
            Edit Invoice
        </h3>
    </div>

    <div class="p-6 space-y-6">
        <form action="#">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="customer-name" class="text-sm font-medium text-gray-900 block mb-2">Customer Name</label>
                    <input type="text" name="customer-name" id="customer-name" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" v-model="invoice.customer_name" placeholder="Jane Doe" required="">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="currency" class="text-sm font-medium text-gray-900 block mb-2">Currency</label>
                    <input type="text" name="currency" id="currency" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" v-model="invoice.currency" placeholder="CAD" required="">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="discount" class="text-sm font-medium text-gray-900 block mb-2">Discount Rate (%)</label>
                    <input type="text" name="discount" id="discount" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" v-model="invoice.discount_rate" placeholder="0" required="">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="status" class="text-sm font-medium text-gray-900 block mb-2">Status</label>
                    <input disabled type="text" name="status" id="status" class="shadow-sm bg-gray-150 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" v-model="invoice.status">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="date-issued" class="text-sm font-medium text-gray-900 block mb-2">Date Issued</label>
                    <input type="date" name="date-issued" id="date-issued" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" v-model="dates.issued_at" placeholder="0" required="">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="date-paid" class="text-sm font-medium text-gray-900 block mb-2">Date Due</label>
                    <input type="date" name="date-paid" id="date-paid" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" v-model="dates.due_at" placeholder="0" required="">
                </div>
            </div>

            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h4 class="text-xl font-semibold">
                    Items
                </h4>
            </div>

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Description
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Quantity
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Unit Price
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200" v-for="(tableRow, index) in tableRows" :key="tableRow.linePosition">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="description" class="text-sm font-medium text-gray-900 block mb-2">Description</label>
                                    <input type="text" name="description" id="description" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" v-model="tableRow.description" placeholder="Description" required="">
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="quantity" class="text-sm font-medium text-gray-900 block mb-2">quantity</label>
                                    <input type="text" name="quantity" id="quantity" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" v-model="tableRow.quantity" placeholder="0" required="">
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="unit-price" class="text-sm font-medium text-gray-900 block mb-2">Unit Price</label>
                                    <input type="text" name="unit-price" id="unit-price" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" v-model="tableRow.unit_price" placeholder="0" required="">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <div class="flex items-start justify-between p-5 border-b rounded-t">
                      <button type="button" @click.stop="insertRow" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold rounded-lg py-2 px-4 rounded-l">Add Item</button>
                    </div>
                </table>
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                  <tbody>
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                          <td class="px-6 py-4">
                            Subtotal: {{ totals.subtotal }} {{ invoice.currency }}
                          </td>
                        </tr>
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                          <td class="px-6 py-4">
                            Discount: {{ totals.discount_amount }} {{ invoice.currency }}
                          </td>
                        </tr>
                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                          <td class="px-6 py-4">
                              Total: {{ totals.total }} {{ invoice.currency }}
                          </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <div class="p-6 border-t border-gray-200 rounded-b">
        <button @click.stop="updateInvoice" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">Save and calculate totals</button>
    </div>

</div>
</template>