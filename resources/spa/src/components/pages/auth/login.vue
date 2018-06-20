<template>
    <div>
        <div class="image"></div>
        <div class="container d-flex flex-column">
            <div class="row my-auto">
                <div id="blur" class="col-lg-5 col-md-8 col-sm-8 mx-auto my-5 py-5">
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
                                    <input v-model="login" v-validate="'required'" name="Логин" class="form-control form-control-lg rounded-0" id="login" type="text" placeholder="Почта или телефон" :class="{'input': true, 'is-danger': errors.has('Пароль') }">
                                    <span class="error">{{ errors.first('Логин') }}</span>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-secondary" for="password">
                                        <small>Пароль</small>
                                    </label>
                                    <input v-model="password" v-validate="'required'" name="Пароль" class="form-control form-control-lg rounded-0" id="password" type="password" placeholder="Пароль" :class="{'input': true, 'is-danger': errors.has('Пароль') }">
                                    <span class="error">{{ errors.first('Пароль') }}</span>
                                </div>
                                <button class="btn btn-lg btn-warning mb-4 w-100 rounded-0" :disabled="errors.any()" type="submit">Войти</button>
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
        methods: {
            sign_user_in() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        this.sign_in({'url': 'index', 'login': this.login, 'password': this.password});
                    }
                });
            }
        }
    }
</script>

<style>
    .image {
        min-height: 100vh;
        background: url('~@/assets/img/city.jpg') no-repeat center center;
        background-size: cover;
        z-index: 0;
        filter: blur(4px);
    }
    #blur {
        position: absolute;
        top: 12%;
        bottom: 0;
        left: 0;
        right: 0;
    }
</style>