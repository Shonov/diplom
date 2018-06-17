<template>

</template>

<script>
    export default {
        name: "customer-view",
        async created() {
            this.customer = await this.$store.dispatch('orders/getCustomer', {
                id: this.$route.params.id
            });
            console.log(this.customer);
        },
    }
</script>

<style scoped>

</style>