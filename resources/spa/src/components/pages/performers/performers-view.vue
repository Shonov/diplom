<template>
    <div class="container">
        <div class="card performers-table">
            <div class="card-header">
                <b-container fluid>
                    <b-row>
                        <b-col md="6" class="my-1">
                            <b-form-group horizontal label="Поиск" class="mb-0">
                                <b-input-group>
                                    <b-form-input v-model="filter" placeholder="Введите для поиска" class="col-sm-8 col-md-8 col-lg-12"></b-form-input>
                                    <b-input-group-append>
                                        <b-btn :disabled="!filter" @click="filter = ''">Сбросить</b-btn>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>
                        <b-col md="6" class="my-1 text-right">
                            <b-form-select :options="pageOptions" class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3" v-model="perPage" ></b-form-select>
                        </b-col>
                    </b-row>
                </b-container>
            </div>
            <b-table class="table table-striped table-bordered"
                     :fields="fields"
                     :items="performers"
                     :current-page="currentPage"
                     :per-page="perPage"
                     :filter="filter"
                     :sort-by.sync="sortBy"
                     :sort-desc.sync="sortDesc"
                     :sort-direction="sortDirection"
                     @filtered="onFiltered"
                     caption-top>
                <template slot="fio" slot-scope="row">
                    <router-link :to="{name: 'performer', params: { id: row.item.id }}">{{ row.item.last_name }} {{ row.item.first_name }}</router-link>
                </template>
                <template slot="city" slot-scope="row">
                    {{ row.item.city }}
                </template>
                <template slot="categories" slot-scope="row">
                    <ul>
                        <li class="categories-list" v-for="category in row.item.categories"><span> ▶ </span>{{ category.title }}</li>
                    </ul>
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
        name: "performers-view",
        mixins:[filter],
        mounted() {
            this.$store.dispatch('performers/list');
        },
        computed: {
            ...mapGetters({
                performers: "performers/list",
            }),

            performers_length() {
                return this.performers.length;
            }
        },
        created() {
            if (this.$route.params.category) {
                this.filter = this.$route.params.category.title;
            }
        },
        data: () => ({
            fields: [
                {
                    key: "fio",
                    label: "ФИО",
                },
                {
                    key: "city",
                    label: "Город",
                    sortable: true
                },
                {
                    key: "categories",
                    label: "Категории",
                },
                // {
                //     key: "",
                //     label: "",
                // },
            ],
            totalRows: this.performers_length,
        }),
    }
</script>
<style>
    .categories-list {
        list-style: none;
    }
    .categories-list span {
        color: #f16528;
    }
    .performers-table {
        margin-top: 50px;
    }
</style>