<template>
    <b-navbar toggleable="md" class="second-bar" type="dark" variant="dark">

        <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>

        <b-navbar-brand :to="{name: 'main'}"><span class="title">PROF</span>PLATFORMA</b-navbar-brand>

        <b-collapse is-nav id="nav_collapse">

            <b-navbar-nav v-if="isLogged">
                <!--<b-nav-item exact :to="{name: 'main'}">Главная</b-nav-item>-->
                <template v-if="role !== 'Заказчик'">
                    <b-nav-item :to="{name: 'orders-views'}" >Заказы</b-nav-item>
                </template>
                <template v-if="role !== 'Исполнитель'">
                    <b-nav-item :to="{name: 'performers'}">Исполнители</b-nav-item>
                </template>
            </b-navbar-nav>

            <b-navbar-nav class="ml-auto">
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
            </b-navbar-nav>

        </b-collapse>
    </b-navbar>
</template>

<script>
    export default {
        name: "navbar",
        data: () => ({

            isLogged: false,
        }),
        created () {
            this.isLogged = !!this.$ls.get('token');
            this.role = this.$ls.get('role');
        },
        methods: {
            makeActive: () => {
                return this.active;
            },
        }
    }
</script>
<style>
    .second-bar {
        background-color: #4F4F4F!important;
    }
    .title {
        color:#f16528;
    ;
    }
</style>
