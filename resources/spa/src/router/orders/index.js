import navbar from '@/components/elements/navbar.vue'
import orders from '@/components/pages/orders/orders'
import view from '@/components/pages/orders/view/order-view'
import views from '@/components/pages/orders/views/orders-views'
import edit from '@/components/pages/orders/edit/order-edit'
import create from '@/components/pages/orders/create/order-create'


export default {
    path: '/',
    name: 'index',
    components: {
        default: orders,
        navbar: navbar
    },
    children: [
        {
            path: 'orders',
            name: 'orders-views',
            component: views,
        },
        {
            path: 'orders/create',
            name: 'order-create',
            component: create,
        },
        {
            path: 'orders/:id',
            name: 'order-view',
            component: view,
            props:true
        },
        {
            path: 'orders/:id/edit',
            name: 'order-edit',
            component: edit,
            props:true
        },
    ]
}