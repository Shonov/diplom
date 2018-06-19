<template>
    <div class="main-order">
        <div class="container d-flex flex-column">
            <div class="row my-auto">
                <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 mx-auto my-5 py-5">
                    <div class="card">
                        <div class="card-header bg-transparent px-5">
                            <h2>Создание заказа</h2>
                        </div>
                        <div class="card-block pt-4 px-5 pb-1">
                            <form class="order" @submit.prevent method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <!--@vdropzone-error="DropZoneError"-->
                                    <!--@vdropzone-success="DropZoneSuccess"-->
                                    <!--@vdropzone-sending="DropZoneSending"-->
                                    <!--@vdropzone-file-added="DropZoneAddedFile"-->
                                    <!--@vdropzone-removed-file="removeThisFile"-->
                                    <!--@vdropzone-complete="DropZoneComplete"-->
                                    <vue-dropzone ref="dropzone" id="dropzone" class="dropzone"
                                                  :options="dropzoneOptions"
                                    />
                                </div>
                                <div class="form-group">
                                    <label class="text-secondary" for="title">
                                        <small>Заголовок</small>
                                    </label>
                                    <input v-model="order.title" type="text" name="Заголовок" id="title" placeholder="Введите название" class="form-control form-control-lg rounded-0" :class="{'input': true, 'is-danger': errors.has('Заголовок') }">
                                    <span class="error">{{ errors.first('Заголовок') }}</span>
                                </div>
                                <div class="form-group">
                                    <label class="text-secondary" for="description">
                                        <small>Описание</small>
                                    </label>
                                    <textarea v-model="order.description" rows="5" cols="15" name="Описание" id="description" placeholder="Опишите ваш заказ" class="form-control form-control-lg rounded-0" :class="{'input': true, 'is-danger': errors.has('Описание') }"></textarea>
                                    <span class="error">{{ errors.first('Описание') }}</span>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                        <label class="text-secondary">
                                            <small>Когда начать работы</small>
                                        </label>
                                        <select v-model="order.time_period" id="period" class="form-control form-control-lg rounded-0">
                                            <option value="В любое время" :selected="order.time_period"> В любое время</option>
                                            <option value="В период" :selected="order.time_period"> В период</option>
                                            <option value="Не позднее чем" :selected="order.time_period"> Не позднее чем</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-8 col-md-12 col-sm-12 mt-2">
                                        <label class="text-secondary"></label>
                                        <input v-model="order.start_date" v-if="visibleDate1" type="date" id="datePeriod" class="form-control form-control-lg rounded-0">
                                    </div>
                                </div>
                                <div class="form-row" v-if="visibleDate2">
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12 mt-2">
                                        <label class="text-secondary" for="datePeriod1">
                                            <small>С</small>
                                        </label>
                                        <input v-model="order.start_date" type="date" id="datePeriod1" class="form-control form-control-lg rounded-0">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12 mt-2">
                                        <label class="text-secondary" for="datePeriod2">
                                            <small>По</small>
                                        </label>
                                        <input v-model="order.end_date" type="date" id="datePeriod2" class="form-control form-control-lg rounded-0">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="text-secondary" for="budget">
                                        <small>Бюджет</small>
                                    </label>
                                    <select v-model="order.budget_scale_id" name="budget" class="form-control form-control-lg rounded-0" id="budget">
                                        <option v-for="option in options" :value="option.id" :selected="order.budget_scale_id"> {{ option.interval }} руб.</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="text-secondary">
                                        <small>Адрес объекта</small>
                                    </label>
                                    <GmapAutocomplete class="form-control form-control-lg rounded-0 form-input" country="ru" :options="options_map" @place_changed="setPlace"></GmapAutocomplete>
                                </div>
                                <div class="form-group">
                                    <gmap-map  class="form-control form-control-lg rounded-0 maps" :zoom="zoom"  :center="center">
                                        <GmapMarker v-for="(marker, index) in markers"
                                                    :key="index"
                                                    :position="marker.position"
                                                    :clickable="true"
                                                    :draggable="true"
                                                    @click="center=marker.position"
                                        />
                                        <GmapMarker v-if="this.place"
                                                    label="★"
                                                    :position="{
                                                            lat: this.place.geometry.location.lat(),
                                                            lng: this.place.geometry.location.lng(),
                                                        }"
                                        />
                                    </gmap-map>
                                </div>
                                <button class="btn btn-lg btn-warning mb-4 w-100 rounded-0" type="submit"  @click="checkUser">Создать</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-flex flex-column" v-if="registration">
            <div class="row my-auto">
                <div class="col-lg-5 col-md-5 col-sm-12 mx-auto my-5 py-5 layout">
                    <div class="card">
                        <div class="card-header bg-transparent px-5">
                            <div class="form-row justify-content-between">
                                <h2>Авторизация</h2>
                                <button type="button" class="close text-right" data-dismiss="modal" aria-label="Close" >
                                    <span aria-hidden="true" @click="formClose">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-block pt-4 px-5 pb-1">
                            <p class="text-center">Для продолжения<a href @click.prevent="openRegister" class="text-right"> зарегистрируйтесь </a>или войдите на сайт.</p>
                            <form @submit.prevent method="post">
                                <div class="form-group">
                                    <label class="text-secondary" for="login">
                                        <small>Почта/Телефон</small>
                                    </label>
                                    <input v-model="sign.login"  class="form-control form-control-lg rounded-0" id="login" type="text" placeholder="Почта или телефон">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-secondary" for="password">
                                        <small>Пароль</small>
                                    </label>
                                    <input v-model="sign.password" class="form-control form-control-lg rounded-0"  type="password" placeholder="Пароль">
                                </div>
                                <button class="btn btn-lg btn-warning mb-4 w-100 rounded-0" type="submit">Войти</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container d-flex flex-column" v-if="startRegister">
            <div class="row my-auto">
                <div class="col-lg-5 col-md-5 col-sm-12 mx-auto my-5 py-5 layout">
                    <div class="card">
                        <div class="card-header bg-transparent px-5">
                            <div class="form-row justify-content-between">
                                <h2>Регистрация</h2>
                                <button type="button" class="close text-right" data-dismiss="modal" aria-label="Close" >
                                    <span aria-hidden="true" @click="formClose">&times;</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-block pt-4 px-5 pb-1">
                            <form id="contactForm" @submit.prevent="customersOrder" method="post">
                                <div class="form-row">
                                    <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                        <label class="text-secondary" for="lastName">
                                            <small>Фамилия</small>
                                        </label>
                                        <input v-model="user.last_name" type="text" id="lastName" placeholder="Иванов" class="form-control form-control-lg rounded-0">
                                    </div>
                                    <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                        <label class="text-secondary" for="firstName">
                                            <small>Имя</small>
                                        </label>
                                        <input v-model="user.first_name" type="text" id="firstName" placeholder="Иван" class="form-control form-control-lg rounded-0">
                                    </div>
                                    <div class="form-group col-lg-4 col-md-12 col-sm-12">
                                        <label class="text-secondary" for="middleName">
                                            <small>Отчество</small>
                                        </label>
                                        <input v-model="user.middle_name" type="text" id="middleName" placeholder="Иванович" class="form-control form-control-lg rounded-0">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label class="text-secondary" for="phone">
                                            <small>Телефон</small>
                                        </label>
                                        <input v-model="user.phone" type="text" id="phone" placeholder="+7(999)9999999" class="form-control form-control-lg rounded-0">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label class="text-secondary" for="phone">
                                            <small>Емайл</small>
                                        </label>
                                        <input v-model="user.email" type="email" id="email" placeholder="Введите почту" class="form-control form-control-lg rounded-0">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label class="text-secondary" for="password">
                                            <small>Пароль</small>
                                        </label>
                                        <input v-model="user.password" type="password" name="password" id="password" placeholder="*******" class="form-control form-control-lg rounded-0">
                                    </div>
                                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                                        <label class="text-secondary" for="password_confirmation">
                                            <small>Повтор пароля</small>
                                        </label>
                                        <input v-model="user.password_confirmation" type="password" name="password_confirmation" id="password_confirmation" placeholder="********" class="form-control form-control-lg rounded-0">
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-secondary"></label>
                                    <input v-model="user.public_offer" type="checkbox"> Даю согласие на обработку персональных данных
                                </div>
                                <button class="btn btn-lg btn-warning mb-4 w-100 rounded-0" type="submit">Продолжить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div :class="{'overplay': overplay}"></div>
    </div>
</template>

<script>
    import orders from '@mixins/orders';
    import vueDropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'
    import {mapGetters} from 'vuex';
    import axios from 'axios'
    function formatDate() {
        let date = new Date(),
            month = '' + (date.getMonth() + 1),
            day = '' + date.getDate(),
            year = date.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;

        date = [year, month, day,].join('-');
        return date;
    }
    export default {
        name: "order-create",
        mixins: [orders],
        components: {
            vueDropzone,
        },
        computed: {
            ...mapGetters({
                options: "orders/budget_list",
            }),
        },
        mounted() {
            this.$store.dispatch('orders/getBudget');
        },
        data: () => ({
            startRegister: false,
            registration: false,
            isLogged: false,
            overplay: false,
            visibleDate1: false,
            visibleDate2: false,
            user: {
                password: '',
                last_name: '',
                first_name: '',
                middle_name: '',
                email: '',
                phone: '',
                password_confirmation: '',
                public_offer: 1,
            },
            sign: {
                login: 'v-shonov@mail.ru',
                password: 'vfkmdbyf',
            },
            zoom: 3,
            center: {
                lat: 55,
                lng: 55
            },
            options_map: {
                componentRestrictions: {country: "ru"},
            },
            markers: [],
            place: null,
            mas: []
        }),
        created () {
            this.isLogged = !!this.$ls.get('token');
        },
        methods: {
            create() {
                // let a = [];
                // this.order.photos.forEach(function (photo) {
                //     let reader = new FileReader();
                //     reader.onload = function(event) {
                //         a.push(event.target.result);
                //     };
                //     reader.readAsDataURL(photo);
                // });
                // this.order.photos = a;
                // console.log('mas',this.order.photos);

                this.order.user_id = this.user.id;
                this.$store.dispatch('orders/create', {params: this.order}).then(
                    responce => {
                        this.$refs.dropzone.processQueue();
                    });

            },
            customersOrder() {
                let base = this.init_config.baseURI;
                if (this.registration){
                    this.sign_in({'url': 'orders', 'login': this.user.login, 'password': this.user.password});
                } else {
                    axios.post(base + '/api/register', {
                        last_name: this.user.last_name,
                        first_name: this.user.first_name,
                        middle_name: this.user.middle_name,
                        email: this.user.email,
                        phone: this.user.phone,
                        password: this.user.password,
                        password_confirmation: this.user.password_confirmation,
                        role: 'Заказчик',
                    }).then(
                        response => {
                            this.formClose();
                            this.sign_in({
                                'url': 'orders',
                                'login': this.user.email,
                                'password': this.user.password
                            });
                            this.create();
                        }
                    );
                }
            },
            checkUser () {
                if (!this.isLogged) {
                    this.overplay = true;
                    this.registration = true;
                } else {
                    this.create();
                }
                return this.registration;
            },
            openRegister() {
                this.registration = false;
                this.startRegister = true;
            },
            formClose() {
                this.registration = this.registration ? false : '';
                this.startRegister = this.startRegister ? false : '';
                this.overplay = false;
            },
            setPlace(place) {
                this.place = place;
                console.log(this.place.geometry.location.lat());
                this.order.address = place.formatted_address;
                this.order.coordinates = String(this.place.geometry.location.lat()) + ' ' + String(this.place.geometry.location.lng());
                this.center = {
                    lat: place.geometry.location.lat(),
                    lng: place.geometry.location.lng(),
                };
                this.zoom = 16;
            },
        },
        watch: {
            'order.time_period': function (val) {
                if (val === "Не позднее чем") {
                    this.order.start_date = formatDate();
                    this.visibleDate1 = true;
                    this.visibleDate2 = false;
                } else if (val === "В период") {
                    this.order.start_date = formatDate();
                    this.visibleDate1 = false;
                    this.visibleDate2 = true;
                } else {
                    this.order.start_date = '';
                    this.order.end_date = '';
                    this.visibleDate1 = false;
                    this.visibleDate2 = false;
                }
            }

        },
    }
</script>
<style>
    .layout {
        z-index: 100;
        bottom: 0;
        right: 0;
        left: 0;
        top: 10%;
        position: fixed;
    }
    .close {
        font-size: 2.5rem;
        color: red;
    }
</style>
