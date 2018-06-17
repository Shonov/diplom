<template>
    <div>
        <div class="image"></div>
        <div class="container d-flex flex-column">
            <div class="row my-auto">
                <div id="blur" class="col-lg-5 col-md-10 col-sm-12 mx-auto my-5 py-5">
                    <div class="card">
                        <div class="card-header bg-transparent px-5">
                            <h2>Авторизация</h2>
                        </div>
                        <div class="card-block pt-4 px-5 pb-1">
                            <form @submit.prevent="sign_user_in" method="post">
                                <div class="form-group">
                                    <label class="text-secondary" for="login">
                                        <small>Почта/Телефон</small>
                                    </label>
                                    <input v-model="login"  class="form-control form-control-lg rounded-0" id="login" type="text" placeholder="Почта или телефон">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-secondary" for="password">
                                        <small>Пароль</small>
                                    </label>
                                    <input v-model="password" class="form-control form-control-lg rounded-0" id="password" type="password" placeholder="Пароль">
                                </div>
                                <button class="btn btn-lg btn-warning mb-4 w-100 rounded-0" type="submit">Войти</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import user from '@mixins/user';
    export default {
        name: "login",
        mixins: [user],
        data() {
            return {
                login: 'v-shonov@mail.ru',
                password: 'vfkmdbyf',
                error: false
            }
        },
        computed: {
            is_disabled() {
                // return this.errors
            },
        },
        methods: {
            sign_user_in() {
                this.sign_in({'url': 'index', 'login': this.login, 'password': this.password});
            }
        }
    }
</script>

<style lang="css">
    .image {
        min-height: 100vh;
        background: url('~@/assets/img/city.jpg') no-repeat center center;
        background-size: cover;
        z-index: 0;
        filter: blur(4px);
    }
    #blur {
        position: absolute;
        top: 20%;
        bottom: 0;
        left: 0;
        right: 0;
    }
</style>