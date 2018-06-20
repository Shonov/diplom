<template>
   <div class="register-image">
      <div class="container d-flex flex-column">
         <div class="row my-auto">
            <div id="register-blur" class="col-lg-9 col-md-10 col-sm-12 col-xs-12 mx-auto my-5 py-5">
               <div class="card ">
                  <div class="card-header bg-transparent px-5">
                     <h2>Регистрация</h2>
                  </div>
                  <div class="card-block pt-4 px-5 pb-1">
                     <form id="user_register" @submit.prevent="register" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                           <div class="form-group col-lg-4 col-md-12 col-sm-12">
                              <label class="text-secondary" for="lastName">
                                 <small>Фамилия</small>
                              </label>
                              <input v-model="last_name"  v-validate="'required'" name="Фамилия" type="text" id="lastName" placeholder="Иванов" class="form-control form-control-lg rounded-0" :class="{'input': true, 'is-danger': errors.has('Фамилия') }">
                              <span class="error">{{ errors.first('Фамилия') }}</span>
                           </div>
                           <div class="form-group col-lg-4 col-md-12 col-sm-12">
                              <label class="text-secondary" for="firstName">
                                 <small>Имя</small>
                              </label>
                              <input v-model="first_name" v-validate="'required'" name="Имя" type="text" id="firstName" placeholder="Иван" class="form-control form-control-lg rounded-0" :class="{'input': true, 'is-danger': errors.has('Имя') }">
                              <span class="error">{{ errors.first('Имя') }}</span>
                           </div>
                           <div class="form-group col-lg-4 col-md-12 col-sm-12">
                              <label class="text-secondary" for="middleName">
                                 <small>Отчество</small>
                              </label>
                              <input v-model="middle_name" v-validate="'required'" type="text" name="Отчество" id="middleName" placeholder="Иванович" class="form-control form-control-lg rounded-0" :class="{'input': true, 'is-danger': errors.has('Отчество') }">
                              <span class="error">{{ errors.first('Отчество') }}</span>
                           </div>
                        </div>
                        <div class="form-row">
                           <div class="form-group col-lg-4 col-md-12 col-sm-12">
                              <label class="text-secondary" for="phone">
                                 <small>Телефон</small>
                              </label>
                              <input v-model="phone" v-validate="'required'" type="tel" name="Телефон" id="phone" placeholder="+7(999)9999999" class="form-control form-control-lg rounded-0" :class="{'input': true, 'is-danger': errors.has('Телефон') }">
                              <span class="error">{{ errors.first('Телефон') }}</span>
                           </div>
                           <div class="form-group col-lg-4 col-md-12 col-sm-12">
                              <label class="text-secondary" for="email">
                                 <small>Почта</small>
                              </label>
                              <input v-model="email" v-validate="'required|email'" type="email" id="email" name="Почта" placeholder="ivan@mail.ru" class="form-control form-control-lg rounded-0" :class="{'input': true, 'is-danger': errors.has('Почта') }">
                              <span class="error">{{ errors.first('Почта') }}</span>
                           </div>
                           <div class="form-group col-lg-4 col-md-12 col-sm-12">
                              <label class="text-secondary" for="birthDate">
                                 <small>Дата рождения</small>
                              </label>
                              <datepicker v-model="birthday" :language="language" :format="customFormatter" placeholder="дд.мм.гггг"></datepicker>
                           </div>
                        </div>
                        <div class="form-group mb-3">
                           <label class="text-secondary" for="description">
                              <small>Описание</small>
                           </label>
                           <textarea v-model="description" rows="5" cols="15" id="description" placeholder="Немного о себе" class="form-control form-control-lg rounded-0"></textarea>
                        </div>
                        <div class="form-group mb-3">
                           <label class="text-secondary" for="multiselect">
                              <small>Категории</small>
                           </label>
                           <multiselect tag="input" v-model="value" :options="work_categories"  track-by="id" label="title" :limit="1" :limit-text="limitText" :searchable="false" :multiple="true" placeholder=""></multiselect>
                        </div>
                        <div class="form-row">
                           <div class="form-group col-lg-6 col-md-12 col-sm-12">
                              <label class="text-secondary" for="password">
                                 <small>Пароль</small>
                              </label>
                              <input v-model="password" v-validate="'required'" type="password" name="Пароль" id="password" placeholder="*******" class="form-control form-control-lg rounded-0" :class="{'input': true, 'is-danger': errors.has('Пароль') }">
                              <span class="error">{{ errors.first('Пароль') }}</span>
                           </div>
                           <div class="form-group col-lg-6 col-md-12 col-sm-12">
                              <label class="text-secondary" for="password_confirmation">
                                 <small>Повтор пароля</small>
                              </label>
                              <input v-model="password_confirmation" v-validate="'required|confirmed:Пароль'" type="password" name="Повтор пароля" id="password_confirmation" placeholder="********" class="form-control form-control-lg rounded-0" :class="{'input': true, 'is-danger': errors.has('Повтор пароля') }">
                              <span class="error">{{ errors.first('Повтор пароля') }}</span>
                           </div>
                        </div>
                        <div class="form-group mb-3">
                           <label class="text-secondary" for="city">
                              <small>Город</small>
                           </label>
                           <GmapAutocomplete v-model="city" @place_changed="setPlace" class="form-control form-control-lg rounded-0" id="city" country="ru" :options="options_map"></GmapAutocomplete>
                        </div>
                        <div class="form-group mb-3">
                           <label class="text-secondary" for="gender">
                              <small>Пол</small>
                           </label>
                           <div class="row no-gutters">
                              <div class="col-sm-6">
                                 <label class="radio-inline">
                                    <input v-model="gender" type="radio" value="Мужской"> Мужской
                                 </label>
                              </div>
                              <div class="col-sm-6">
                                 <label class="radio-inline">
                                    <input v-model="gender" type="radio" value="Женский"> Женский
                                 </label>
                              </div>
                           </div>
                        </div>
                        <div class="form-group mb-3">
                           <label class="text-secondary" for="city"></label>
                           <input v-model="public_offer" v-validate="'required'" data-vv-as=" "  name="public_offer" type="checkbox"  > Даю согласие на обработку персональных данных
                           <span class="error">{{ errors.first('public_offer') }}</span>
                        </div>
                        <button class="btn btn-lg btn-warning mb-4 w-100 rounded-0" :disabled="errors.any()" type="submit">Зарегистрироваться</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
    import axios from 'axios'
    import user from '@mixins/user';
    import Multiselect from 'vue-multiselect'
    import {mapGetters} from 'vuex';
    import Datepicker from 'vuejs-datepicker';
    import {ru} from 'vuejs-datepicker/dist/locale'
    import moment from 'moment'

    export default {
        name: "registrer",
        mixin: [user],
        components: {
            Multiselect,
            Datepicker,
        },
        computed: {
            ...mapGetters({
                work_categories: "performers/categories",
            }),
        },
        mounted() {
            this.$store.dispatch('performers/allWorkCategories');
        },
        data: () => ({
            language: ru,
            value: [],
            options_map: {
                types: ['(cities)'],
                componentRestrictions: {country: "ru"},
            },
            password: '',
            last_name: '',
            first_name: '',
            middle_name: '',
            email: '',
            phone: '',
            password_confirmation: '',
            categories: [],
            city: '',
            gender: null,
            birthday: null,
            description: '',
            confirmed: false,
            public_offer: 1,
        }),
        created () {
            this.options = this.work_categories;
        },
        methods: {
            customFormatter(date) {
                return moment(date).format('l');
            },
            limitText (count) {
                if (count === 1) {
                    return `и ${count} другая категория`
                } else
                    return `и ${count} других категорий`;
            },
            setPlace(place) {
                this.city = place.formatted_address;
            },
            register() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        let base = this.init_config.baseURI;
                        axios.post(base + '/api/register', {
                            last_name: this.last_name,
                            first_name: this.first_name,
                            middle_name: this.middle_name,
                            email: this.email,
                            phone: this.phone,
                            gender: this.gender,
                            birthday: this.birthday,
                            description: this.description,
                            city: this.city,
                            password: this.password,
                            password_confirmation: this.password_confirmation,
                            role: 'Исполнитель',
                            categories: this.value,
                            public_offer: this.public_offer,
                        }).then(
                            response => {
                                this.sign_in({'url': 'index', 'login': this.email, 'password': this.password});
                            }
                        )
                    }
                });
            }
        },

    }
</script>
<style>
   #user_register img {
      height: 315px;
   }
   .register-image {
      position: relative;
   }
   .register-image::before {
      position:absolute;
      width: 100%;
      height: 100%;
      content: '';
      z-index: -1;
      background: url('~@/assets/img/city.jpg') no-repeat center center;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      -webkit-filter: blur(5px);
      -moz-filter: blur(5px);
      -o-filter: blur(5px);
      -ms-filter: blur(5px);
      filter: blur(5px);
   }
   #register-blur {
      position: relative;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
   }
   #user_register .multiselect .multiselect__tags {
      font-size: 1rem;
      border-radius: 0 !important;
      border: 1px solid #ced4da;
   }
   .vdp-datepicker input{
      border: 1px solid #ced4da;
      padding: 0.5rem 1rem;
      font-size: 1.25rem;
      width: 100%;
   }
</style>