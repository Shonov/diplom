<template>
    <div class="container">
        <div class="card order-table">
            <div class="card-header">
                <b-container fluid>
                    <b-row>
                        <b-col md="6" class="my-1">
                            <b-form-group horizontal label="Поиск" class="mb-0">
                                <b-input-group>
                                    <b-form-input v-model="filter" placeholder="Введите для поиска" ></b-form-input>
                                    <b-input-group-append>
                                        <b-btn :disabled="!filter" @click="filter = ''">Сбросить</b-btn>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" class="my-1 text-right">
                            <b-form-select :options="pageOptions" class="col-sm-3" v-model="perPage" ></b-form-select>
                        </b-col>
                    </b-row>
                </b-container>
            </div>
            <b-table class="table table-striped table-bordered"
                     :fields="fields"
                     :items="orders"
                     :current-page="currentPage"
                     :per-page="perPage"
                     :filter="filter"
                     :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :sort-direction="sortDirection"
                     @filtered="onFiltered"
                     caption-top>
                <template slot="table-caption" v-if="!role || role !== 'Исполнитель'">
                    <router-link :to="{name: 'order-create'}" class="create">Создать заказ</router-link>
                </template>
                <template slot="title" slot-scope="row">
                    <router-link :to="{name:'order-view', params: { id: row.item.id }}"> {{ row.item.title }}</router-link>
                </template>
                <template slot="description" slot-scope="row">
                    {{ row.item.description.substr(0, 200)  }}...
                </template>
                <template slot="budget_scale_id" slot-scope="row" v-if="">
                    {{ row.item.budget_scale_id }} руб.
                </template>
                <template slot="address" slot-scope="row">
                    {{ row.item.address }}
                </template>
            </b-table>
        </div>
        <b-row>
            <b-col md="6" class="my-1">
                <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" ></b-pagination>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import filter from '@mixins/filter';

    export default {
        name: "orders-views",
        mixins:[filter],
        mounted() {
            this.$store.dispatch('orders/list');
            this.$store.dispatch('orders/getBudget');
        },
        computed: {
            ...mapGetters({
                orders: "orders/list",
                options: "orders/budget_list",
            }),
            orders_length() {
                return this.orders.length;
            },
        },
        created() {
            this.role = this.$ls.get('role', false);
            console.log(this.role);
        },
        data: () => ({
            fields: [
                {
                    key: "title",
                    label: "Заголовок",
                },
                {
                    key: "description",
                    label: "Описание",
                },
                {
                    key: "budget_scale_id",
                    label: "Бюджет",
                    sortable: true,
                },
                {
                    key: "address",
                    label: "Адрес",
                    sortable: true,
                },
            ],
            totalRows: this.orders_length,
        }),
    }
</script>
<style>
    .order-table {
        margin-top: 50px;
    }
    .create {
        padding-left: 13px;
    }
</style>