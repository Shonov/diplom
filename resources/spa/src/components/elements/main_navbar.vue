<template>
    <div>
        <div class="navbar-absolute-top">
            <b-navbar toggleable="md" type="dark" variant="dark">
                <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
                <b-navbar-brand :to="{name: 'main'}"><span class="title">PROF</span>PLATFORMA</b-navbar-brand>
                <b-collapse is-nav id="nav_collapse" class="justify-content-center">
                    <b-nav class="navbar-nav" v-if="isLogged">
                        <!--<b-nav-item :to="{name: 'main'}">Главная</b-nav-item>-->
                        <b-nav-item :to="{name: 'orders-views'}" >Заказы</b-nav-item>
                        <!--<template v-if="role !== 'Исполнитель'">-->
                            <b-nav-item :to="{name: 'performers'}">Исполнители</b-nav-item>
                        <!--</template>-->
                    </b-nav>
                    <b-nav class="navbar-nav ml-auto">
                        <template v-if="!isLogged">
                            <b-nav-item :to="{name: 'register'}">Регистрация</b-nav-item>
                            <b-nav-item :to="{name: 'login'}">Авторизация</b-nav-item>
                        </template>
                        <template v-else>
                            <b-nav-item-dropdown right>
                                <template slot="button-content">
                                    <em>{{user.first_name}}</em>
                                </template>
                                <b-dropdown-item :to="{name: 'profile'}">Профиль</b-dropdown-item>
                                <b-dropdown-item @click="exit">Выйти</b-dropdown-item>
                            </b-nav-item-dropdown>
                        </template>
                    </b-nav>
                </b-collapse>


            </b-navbar>
        </div>
        <header id="home">
            <div class="container">
                <div class="intro-text">
                    <h5 class="intro-heading">Найти необходимого исполнителя просто указав</h5>
                    <form method="post">
                        <div class="row col-md-12 no-gutters align-items-center justify-content-center">
                            <label class="works col-md-2">Вид работы</label>
                            <multiselect class="col-md-7" v-model="value" :options="categories" track-by="id" label="title" placeholder="Введите для поиска"><span slot="noResult">К сожалению! Элементов не найдено.Измените запрос</span></multiselect>
                            <router-link class="col-md-2" :to="{name:'performers', params: { category: value }}"> Найти </router-link>
                        </div>
                        <!--<input type=" submit" class="col-md-2" @click.prevent="searchPerformers" value="Найти">-->
                    </form>
                </div>
            </div>
        </header>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import {mapGetters} from 'vuex';

    export default {
        name: "main_navbar",
        components: {
            Multiselect
        },
        data: () => ({
            search: '',
            value: null,
        }),
        computed: {
            ...mapGetters({
                categories: "performers/categories",
            }),
        },
        created () {
            this.isLogged = !!this.$ls.get('token');
            this.role = this.$ls.get('role');
        },
        mounted() {
            this.$store.dispatch('performers/allWorkCategories');
        },

        methods: {
            searchPerformers(){
                if(!this.value) {
                    alert("Выберите категорию!!");
                }
            },
        }
    }
</script>