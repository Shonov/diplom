<template>
   <div class="container">
      <form id="user_register" role="form" @submit.prevent="register" method="post" enctype="multipart/form-data">
         <h2>Регистрация</h2>
         <div class="form-group">
            <label class="col-sm-3 control-label">Фотография</label>
            <div class="col-sm-9">
               <div v-if="!photo">
                  <input type="file" name="file" @change="onFileChange">
               </div>
               <div v-else>
                  <img class="photo" :src="photo" />
                  <button @click.prevent="removeImage">Удалить</button>
               </div>
            </div>
         </div>
         <div class="form-group">
            <label for="lastName" class="col-sm-3 control-label">Фамилия</label>
            <div class="col-sm-9">
               <input v-model="last_name" type="text" id="lastName" placeholder="Введите фамилию" class="form-control" autofocus>
            </div>
         </div>
         <div class="form-group">
            <label for="firstName" class="col-sm-3 control-label">Имя</label>
            <div class="col-sm-9">
               <input v-model="first_name" type="text" id="firstName" placeholder="Введите имя" class="form-control" autofocus>
            </div>
         </div>
         <div class="form-group">
            <label for="middleName" class="col-sm-3 control-label">Отчество</label>
            <div class="col-sm-9">
               <input v-model="middle_name" type="text" id="middleName" placeholder="Введите отчество" class="form-control" autofocus>
            </div>
         </div>
          <div class="form-group">
              <label for="phone" class="col-sm-3 control-label">Телефон</label>
              <div class="col-sm-9">
                  <input v-model="phone" type="text" id="phone" placeholder="Введите телефон" class="form-control">
              </div>
          </div>
         <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Емайл</label>
            <div class="col-sm-9">
               <input v-model="email" type="email" id="email" placeholder="Введите почту" class="form-control">
            </div>
         </div>
         <div class="form-group">
            <label for="description" class="col-sm-3 control-label">Описание</label>
            <div class="col-sm-9">
               <textarea v-model="description" rows="5" cols="15" id="description" placeholder="Немного о себе" class="form-control"></textarea>
            </div>
         </div>
         <div class="form-group">
               <label class="col-sm-4 control-label">Категории работ</label>
            <div class="col-sm-9">
               <multiselect  tag="input" v-model="value" :options="work_categories"  track-by="id" label="title" :limit="1" :limit-text="limitText" :searchable="false" :multiple="true" placeholder=""></multiselect>
            </div>
         </div>
         <div class="form-group">
               <label for="password" class="col-sm-3 control-label">Пароль</label>
            <div class="col-sm-9">
               <input v-model="password" type="password" name="password" id="password" placeholder="Введите пароль" class="form-control">
            </div>
         </div>
         <div class="form-group">
            <label for="password_confirmation" class="col-sm-3 control-label">Повтор пароля</label>
            <div class="col-sm-9">
               <input v-model="password_confirmation" type="password" name="password_confirmation" id="password_confirmation" placeholder="Повторите введенный пароль" class="form-control">
            </div>
         </div>

         <div class="form-group">
            <label for="birthDate" class="col-sm-3 control-label">Дата рождения</label>
            <div class="col-sm-9">
               <input v-model="birthday" type="date" id="birthDate" class="form-control">
            </div>
         </div>
         <div class="form-group">
            <label for="city" class="col-sm-3 control-label">Город</label>
            <div class="col-sm-9">
               <GmapAutocomplete v-model="city" @place_changed="setPlace" class="form-control form-input" id="city" country="ru" :options="options_map"></GmapAutocomplete>
            </div>
         </div>
         <div class="form-group">
            <label class="control-label col-sm-3">Пол</label>
            <div class="col-sm-6">
               <div class="row">
                  <div class="col-sm-4">
                     <label class="radio-inline">
                        <input v-model="gender" type="radio" value="Мужской">Мужской
                     </label>
                  </div>
                  <div class="col-sm-4">
                     <label class="radio-inline">
                        <input v-model="gender" type="radio" value="Женский">Женский
                     </label>
                  </div>
               </div>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
               <div class="checkbox">
                  <label>
                     <input v-model="public_offer" type="checkbox" checked> Даю согласие на обработку персональных данных
                  </label>
               </div>
            </div>
         </div>
         <div class="form-group">
            <div class="col-sm-9 col-sm-offset-3">
               <button type="submit" class="btn btn-primary">Зарегестрироваться</button>
            </div>
         </div>
      </form>
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
            public_offer: false,
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
                let image = new Image();
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
