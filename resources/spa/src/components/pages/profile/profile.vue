<template>
    <div class="container">
        <form class="" role="form" enctype="multipart/form-data" @submit.prevent="validateUser">
            <div class="margin-title line-bottom">
                <h2>Профиль</h2>
            </div>
            <div class="row" id="info-data">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="text-center" id="people">
                        <img v-if="!form.photo" src="~@/assets/img/no-foto.jpg">
                        <img v-else :src="form.photo">
                    </div>
                    <div class="text-center" id="file">
                        <label>
                            <input type="file" class="profile-img" @change="onFileChange">
                            <span>Выберите файл</span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-xs-12">
                    <div id="myTabContent" class="tab-content">
                        <div class="form-group row">
                            <label for="lastName" class="col-sm-3 col-form-label">Фамилия</label>
                            <div class="col-sm-9">
                                <input v-model="form.last_name" type="text" id="lastName" class="form-control"
                                       autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="firstName" class="col-sm-3 col-form-label">Имя</label>
                            <div class="col-sm-9">
                                <input v-model="form.first_name" type="text" id="firstName" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="middleName" class="col-sm-3 col-form-label">Отчество</label>
                            <div class="col-sm-9">
                                <input v-model="form.middle_name" type="text" id="middleName" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="phone" class="col-sm-3 col-form-label">Телефон</label>
                            <div class="col-sm-9">
                                <input v-model="form.phone" type="tel" id="phone" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Емайл</label>
                            <div class="col-sm-9">
                                <input v-model="form.email" type="email" id="email" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="birthDate" class="col-sm-3 col-form-label">Дата рождения</label>
                            <div class="col-sm-9">
                                <input v-model="form.birthday" type="date" id="birthDate" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-sm-3">Пол</label>
                            <div class="col-sm-4">
                                <label class="radio-inline col-form-label">
                                    <input v-model="form.gender" type="radio" id="femaleRadio" value="Мужской">Мужской
                                </label>
                            </div>
                            <div class="col-sm-4">
                                <label class="radio-inline col-form-label">
                                    <input v-model="form.gender" type="radio" id="maleRadio" value="Женский">Женский
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Категории работ</label>
                            <div class="col-sm-9">
                                <multiselect tag="input" v-model="form.categories" :options="work_categories"
                                             track-by="id" label="title" :limit="1" :limit-text="limitText"
                                             :searchable="false" :multiple="true" placeholder=""></multiselect>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>

        <div>
            <div class="line-bottom">
                <h2>Сменить пароль</h2>
            </div>
            <div class="alert alert-danger" v-show="errors.any()">
                <div v-if="errors.has('password')">
                    {{ errors.first('password') }}
                </div>
                <div v-if="errors.has('password_confirmation')">
                    {{ errors.first('password_confirmation') }}
                </div>
            </div>
            <form class="margin-bottom" role="form" @submit.prevent="validatePassword" method="post">
                <div class="form-row justify-content-center">
                    <div class="col-md-6 mb-3">
                        <label for="password">Новый пароль</label>
                        <input v-model="passwordForm.password" v-validate="'required'" data-vv-as="Пароль"
                               type="password" name="password" id="password" class="form-control" placeholder="Пароль">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation">Повтор пароля</label>
                        <input v-model="passwordForm.password_confirmation" v-validate="'required|confirmed:password'"
                               data-vv-as="Повтор пароля" type="password" name="password_confirmation"
                               id="password_confirmation" class="form-control" placeholder="Подтвердите пароль">
                    </div>
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
        <div class="order-request-table" v-if="role !== 'Заказчик'">
            <div class="line-bottom">
                <h2>Активные заявки [{{requests.length}}]</h2>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Заказ</th>
                    <th scope="col">Автор</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Действия</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="request in requests">
                    <td>{{ request.id }}</td>
                    <td>{{ request.user_id }}</td>
                    <td>{{ request.status }}</td>
                    <td>
                        <button type="button" class="btn btn-danger" @click="deleteRequest(request.id)">Удалить</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <div class="line-bottom">
                <h2>Мои заказы</h2>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Заголовок</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Бюджет</th>
                    <th scope="col">Адрес</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order in orders">
                    <td>
                        <router-link :to="{name: 'order-view', params: { id: order.id }}" >{{ order.title }}</router-link>
                    </td>
                    <td>{{ order.description.substr(0, 50) }}...</td>
                    <td>{{ order.budget.interval }} руб.</td>
                    <td>{{ order.address }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "profile",
        data: () => ({
            _user: false,
            form: {
                last_name: null,
                first_name: null,
                middle_name: null,
                email: null,
                phone: null,
                gender: null,
                birthday: null,
                photo: '',
                description: '',
                categories: [],
            },
            passwordForm: {
                password: null,
                password_confirmation: null,
            }
        }),

        methods: {
            save(params) {
                this.$store.dispatch('profile/update', {
                    params: params,
                    id: this._user.id
                });
            },
            async deleteRequest(id) {
                await this.$store.dispatch('orders/deleteRequest', {
                    id: id
                });
                this.$store.dispatch('profile/requests');
            },
            saveUser() {
                this.save({...this.form});
            },
            savePassword() {
                this.save({...this.passwordForm});
            },
            validateUser() {
                this.saveUser();
            },

            validatePassword() {
                this.$validator
                    .validateAll()
                    .then((response) => {
                        if (response === true) {
                            this.savePassword();
                        }
                    })
            },
            onFileChange(e) {
                let image = new Image();
                let files = e.target.files || e.dataTransfer.files;
                this.form.photo = files[0];
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.form.photo = e.target.result;
                };
                reader.readAsDataURL(this.form.photo);
            },
            limitText(count) {
                if (count === 1) {
                    return `и ${count} другая категория`
                } else
                    return `и ${count} других категорий`;
            },
        },
        computed: {
            ...mapGetters({
                orders: "profile/orders",
                requests: "profile/requests",
                work_categories: "performers/categories",
            }),
        },
        mounted() {
            this.$store.dispatch('profile/orders');
            this.$store.dispatch('profile/requests');
            this.$store.dispatch('performers/allWorkCategories');
            this._user = this.user;
            console.log(this.user);
            this.form = {
                last_name: this._user.last_name,
                first_name: this._user.first_name,
                middle_name: this._user.middle_name,
                email: this._user.email,
                phone: this._user.phone,
                gender: this._user.gender,
                birthday: this._user.birthday,
                photo: this._user.photo,
                description: this._user.description,
                categories: this._user.categories,
            };
        },
        created() {
            this.role = this.$ls.get('role');
            this.options = this.work_categories;
        }
    }
</script>
