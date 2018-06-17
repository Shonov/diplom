<template>
    <div class="container">
        <div class="line-bottom">
            <div class="row" id="info-data">
                <div class="col-lg-4 col-md-4 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center" id="people">
                                <!--<img src="http://bootstraptema.ru/snippets/element/2016/profilesection/myprofile.jpg">-->
                                <img v-if="!performer.photo" src="~@/assets/img/no-foto.jpg">
                                <img v-else :src="performer.photo">
                                <h3>{{ performer.first_name }} {{ performer.last_name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-xs-12">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active">
                                    <h4>История профиля</h4>
                                    <table class="table table-th-block">
                                        <tbody>
                                            <tr>
                                                <td class="active">Город:</td>
                                                <td>{{ performer.city }}</td>
                                            </tr>
                                            <tr>
                                                <td class="active">Пол:</td>
                                                <td>{{ performer.gender }}</td>
                                            </tr>
                                            <tr>
                                                <td class="active">Дата рождения:</td>
                                                <td>{{ performer.birthday }}</td>
                                            </tr>
                                            <tr class="table-tr">
                                                <td class="active">О себе:</td>
                                                <td>{{ performer.description }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <h6 class="active">Категории работ:</h6>
                                <ul class="list-inline" v-for="category in performer.categories">
                                    <li class="list-inline-item"><span> ▶ </span>{{ category.title }} </li>
                                </ul>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "performer-view",
        data: () => ({
            performer: {
                password: '',
                last_name: '',
                first_name: '',
                middle_name: '',
                email: '',
                phone: '',
                categories: [],
                city: '',
                gender: null,
                birthday: null,
                photo: '',
                description: '',
                confirmed: false,
                public_offer: false,
            }
        }),
        async created() {
            let variable = await this.$store.dispatch('performers/getPerformer', {
                id: this.$route.params.id
            });
            console.log(variable);
            this.performer = variable[0];
            this.performer.categories = variable[1];
            console.log(this.performer.categories);
        },
    }
</script>