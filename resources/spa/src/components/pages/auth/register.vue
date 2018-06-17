<template>
   <div class="container d-flex flex-column">
      <div class="row my-auto">
         <div class="col-lg-8 col-md-10 col-sm-12 col-xs-12 mx-auto my-5 py-5">
            <div class="card ">
               <div class="card-header bg-transparent px-5">
                  <h2>Регистрация</h2>
               </div>
               <div class="card-block pt-4 px-5 pb-1">
                  <form id="user_register" @submit.prevent="register" method="post" enctype="multipart/form-data">
                     <div class="form-group text-center">
                        <label class="text-secondary text-left" for="photo">
                           <small>Фотография</small>
                        </label>
                        <div v-if="!photo">
                           <input type="file" name="file" @change="onFileChange">
                        </div>
                        <div v-else>
                           <img class="photo" :src="photo" />
                           <div>
                              <button @click.prevent="removeImage" class="mt-3">Удалить</button>
                           </div>
                        </div>
                     </div>
                     <div class="form-row">
                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                           <label class="text-secondary" for="lastName">
                              <small>Фамилия</small>
                           </label>
                           <input v-model="last_name" type="text" id="lastName" placeholder="Иванов" class="form-control form-control-lg rounded-0">
                        </div>
                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                           <label class="text-secondary" for="firstName">
                              <small>Имя</small>
                           </label>
                           <input v-model="first_name" type="text" id="firstName" placeholder="Иван" class="form-control form-control-lg rounded-0">
                        </div>
                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                           <label class="text-secondary" for="middleName">
                              <small>Отчество</small>
                           </label>
                           <input v-model="middle_name" type="text" id="middleName" placeholder="Иванович" class="form-control form-control-lg rounded-0">
                        </div>
                     </div>
                     <div class="form-row">
                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                           <label class="text-secondary" for="phone">
                              <small>Телефон</small>
                           </label>
                           <input v-model="phone" type="text" id="phone" placeholder="+7(999)9999999" class="form-control form-control-lg rounded-0">
                        </div>
                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                           <label class="text-secondary" for="email">
                              <small>Почта</small>
                           </label>
                           <input v-model="email" type="email" id="email" placeholder="ivan@mail.ru" class="form-control form-control-lg rounded-0">
                        </div>
                        <div class="form-group col-lg-4 col-md-12 col-sm-12">
                           <label class="text-secondary" for="birthDate">
                              <small>Дата рождения</small>
                           </label>
                           <input v-model="birthday" type="date" id="birthDate" class="form-control form-control-lg rounded-0">
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
                           <input v-model="password" type="password" name="password" id="password" placeholder="*******" class="form-control form-control-lg rounded-0">
                        </div>
                        <div class="form-group col-lg-6 col-md-12 col-sm-12">
                           <label class="text-secondary" for="password_confirmation">
                              <small>Повтор пароля</small>
                           </label>
                           <input v-model="password_confirmation" type="password" name="password_confirmation" id="password_confirmation" placeholder="********" class="form-control form-control-lg rounded-0">
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
                        <input v-model="public_offer" type="checkbox"> Даю согласие на обработку персональных данных
                     </div>
                     <button class="btn btn-lg btn-warning mb-4 w-100 rounded-0" type="submit">Зарегистрироваться</button>
                  </form>
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

    export default {
        name: "registrer",
        mixin: [user],
        components: {
            Multiselect
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
            photo: '',
            description: '',
            confirmed: false,
            public_offer: 1,
        }),
        created () {
            this.options = this.work_categories;
        },
        methods: {
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.photo = files[0];
                console.log(this.photo );
                this.createImage(files[0]);
            },
            createImage(file) {
                // let image = new Image();
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.photo = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            removeImage: function (e) {
                this.photo = '';
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
                let base = this.init_config.baseURI;
                axios.post(base + '/api/register', {
                    last_name: this.last_name,
                    first_name: this.first_name,
                    middle_name: this.middle_name,
                    email: this.email,
                    phone: this.phone,
                    gender: this.gender,
                    birthday: this.birthday,
                    photo: this.photo,
                    description: this.description,
                    city: this.city,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    role: 'Исполнитель',
                    categories: this.value,
                    public_offer: this.public_offer,
                }).then(
                    response => {
                        console.log("register info", response);
                        location.reload();
                    }
                )

            }
        },

    }
</script>
<style>
   #user_register img {
      height: 315px;
   }
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
   #user_register .multiselect .multiselect__tags {
      font-size: 1rem;
      border-radius: 0 !important;
      border: 1px solid #ced4da;
   }
</style>