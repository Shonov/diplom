<template>
    <div class="container">
        <div class="col-sm-11 mx-auto">
            <form class="order" @submit.prevent method="post" enctype="multipart/form-data">
                <div class="form-title">
                    <h2>Создание заказа</h2>
                    <hr>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
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
                </div>

                <div class="form-group">
                    <label for="title" class="col-sm-3 control-label">Заголовок</label>
                    <div class="col-sm-12">
                        <input v-model="order.title" type="text" id="title" placeholder="Введите название" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description" class="col-sm-3 control-label">Описание</label>
                    <div class="col-sm-12">
                        <textarea v-model="order.description" rows="5" cols="15" id="description" placeholder="Опишите ваш заказ" class="form-control"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="period" class="col-sm-5 control-label">Когда надо начать работы</label>
                    <div class="form-inline">
                        <div class="form-group mb-2">
                            <div class="col-sm-12">
                                <select v-model="order.time_period" id="period" class="form-control">
                                    <option value="В любое время" :selected="order.time_period"> В любое время</option>
                                    <option value="В период" :selected="order.time_period"> В период</option>
                                    <option value="Не позднее чем" :selected="order.time_period"> Не позднее чем</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                            <div class="col-sm-12">
                                <input v-model="order.start_date" v-if="visibleDate1" type="date" id="datePeriod" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline" v-if="visibleDate2">
                    <div class="form-group mb-2">
                        <label for="datePeriod1" class="col-sm-2 control-label">С</label>
                        <div class="col-sm-10">
                            <input v-model="order.start_date" type="date" id="datePeriod1" class="form-control">
                        </div>
                    </div>
                    <div class="form-group mx-sm-3 mb-2">
                        <label for="datePeriod2" class="col-sm-2 control-label">по</label>
                        <div class="col-sm-10">
                            <input v-model="order.end_date" type="date" id="datePeriod2" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="budget" class="col-sm-3 control-label">Бюджет</label>
                    <div class="col-sm-6">
                        <select v-model="order.budget_scale_id" name="budget" class="form-control" id="budget">
                                <option v-for="option in options" :value="option.id" :selected="order.budget_scale_id"> {{ option.interval }} руб.</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Адрес объекта</label>
                    <div class="col-sm-12">
                            <GmapAutocomplete class="form-control form-input" country="ru" :options="options_map" @place_changed="setPlace"></GmapAutocomplete>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-12">
                        <gmap-map  class="form-control maps" :zoom="zoom"  :center="center">
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
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary  col-sm-4 offset-sm-8" @click="checkUser">Создать</button>
                    </div>
               </div>
            </form>
        </div>
        <div class="container mx-auto customer-form h-100 d-flex flex-column justify-content-center my-0" id="sign_in" v-if="registration">
        <form class="customer" @submit.prevent method="post">
                <div class="form-title">
                    <div class="modal-header">
                            <h1>Авторизация</h1>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="formClose">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <p>Для продолжения войдите на сайт с помощью формы ниже.</p>
                <p>Еще не зарегестрированы? Нажмите <a href="" @click.prevent="openRegister">Зарегистирироваться</a></p>
                <div class="form-group">
                    <label for="lastName" class="col-sm-3 form-label">Логин</label>
                    <div class="col-sm-12">
                        <input v-model="sign.login" type="text" id="login" placeholder="Введите почту или телефон" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Пароль</label>
                    <div class="col-sm-12">
                        <input v-model="sign.password" type="password" name="password" placeholder="Введите пароль" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-block" @click="customersOrder">Войти</button>
                    </div>
                </div>
            </form>
        </div>


        <div class="container mx-auto customer-form h-100 d-flex flex-column justify-content-center my-0" id="sign_up" v-if="startRegister">
            <!--<div class="modal-dialog" role="document" id="sign_up" v-if="startRegister">-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Регистрация заказчика</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="formClose">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="contactForm" @submit.prevent="customersOrder"  method="post">
                            <div class="form-group">
                                <label for="lastName">Фамилия</label>
                                <input v-model="user.last_name" type="text" id="lastName" placeholder="Введите фамилию" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="firstName">Имя</label>
                                <input v-model="user.first_name" type="text" id="firstName" placeholder="Введите имя" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="middleName">Отчество</label>
                                    <input v-model="user.middle_name" type="text" id="middleName" placeholder="Введите отчество" class="form-control">
                                </div>
                            <div class="form-group">
                                <label for="phone">Телефон</label>
                                <input v-model="user.phone" type="text" id="phone" placeholder="Введите телефон" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email">Емайл</label>
                                <input v-model="user.email" type="email" id="email" placeholder="Введите почту" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Пароль</label>
                                <input v-model="user.password" type="password" name="password" id="password" placeholder="Введите пароль" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Повтор пароля</label>
                                <input v-model="user.password_confirmation" type="password" name="password_confirmation" id="password_confirmation" placeholder="Повторите введенный пароль" class="form-control">
                            </div>
                            <div class="form-group form-check">
                                <input id="check" class="form-check-input" checked type="checkbox">
                                <label class="form-check-label" for="check">Я даю согласие на обработку персональных данных.</label>
                            </div>
                            <button id="button" class="btn btn-success" type="submit">Отправить</button>
                        </form>
                    </div>
                <!--</div>-->
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
                if (val == "Не позднее чем") {
                    this.order.start_date = formatDate();
                    this.visibleDate1 = true;
                    this.visibleDate2 = false;
                } else if (val == "В период") {
                    this.order.start_date = formatDate();
                    this.visibleDate1 = false;
                    this.visibleDate2 = true;
                } else {
                    // this.order.start_date = '';
                    // this.order.end_date = '';
                    this.visibleDate1 = false;
                    this.visibleDate2 = false;
                }
            }

        },
    }
</script>