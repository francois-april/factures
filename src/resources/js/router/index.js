import { createRouter, createWebHistory} from "vue-router"

import invoices from '../components/invoices/invoices.vue'
import edit from '../components/invoices/edit.vue'
import axios from "axios"

const routes = [
    {
        path: '/',
        component: invoices
    },
    {
        path: '/invoice/edit/:id',
        component: edit,
        props:true
    },
]

const router = createRouter({
    history:createWebHistory(),
    routes
})

const newInvoice = async () => {
    let form = await axios.get("api/create_invoice")
}

export default router;