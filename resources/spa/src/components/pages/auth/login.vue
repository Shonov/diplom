<template>
    <div class="login-wrapper border border-light">
        <div class="alert alert-danger" v-if="error">{{ error }}</div>
        <form class="form-signin" @submit.prevent="sign_user_in" method="post">
            <h2 class="form-signin-heading">Авторизация</h2>
            <label for="login" class="sr-only">Логин</label>
                <input v-model="login" type="text" id="login" name="login" class="form-control" placeholder="Введите логин" required autofocus>
            <label for="password" class="sr-only">Пароль</label>
                <input v-model="password" name='password' type="password" id="password" class="form-control" placeholder="Введите пароль" required>
            <button class="btn btn-lg btn-primary btn-block"  type="submit" :disabled="is_disabled">Sign in</button>
        </form>
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
            }
        },
        methods: {
            sign_user_in() {
                this.sign_in({'url': 'index', 'login': this.login, 'password': this.password});
            }
        }
    }
</script>

<style lang="css">
    .form-signin {
        max-width: 330px;
        padding: 10% 15px;
        margin: 0 auto;
    }
    .form-signin .form-signin-heading,
        .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>