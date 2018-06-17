<template>
    <div class="container">
        <div id="main">
            <div class="row">
                <template>
                    <div class="col-sm-12">
                        <b-carousel id="carousel1"
                                    style="text-shadow: 1px 1px 2px #333;"
                                    controls
                                    indicators
                                    background="#ababab"
                                    :interval="4000"
                                    img-width="1024"
                                    img-height="480"
                                    v-model="slide"
                                    @sliding-start="onSlideStart"
                                    @sliding-end="onSlideEnd"
                        >

                            <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=52"></b-carousel-slide>

                            <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=54"></b-carousel-slide>

                            <b-carousel-slide img-src="https://picsum.photos/1024/480/?image=58"></b-carousel-slide>

                            <b-carousel-slide>
                                <img slot="img" class="d-block img-fluid w-100" width="1024" height="480"
                                     src="https://picsum.photos/1024/480/?image=55" alt="image slot">
                            </b-carousel-slide>
                        </b-carousel>
                    </div>
                </template>
                <div class="col-lg-12 col-md-12 col-xs-8">
                    <h3>{{ order.title }}</h3>
                    <table class="table table-th-block">
                        <tbody>
                            <tr>
                                <td class="active">Город</td>
                                <td>{{ order.address }}</td>
                            </tr>
                            <tr>
                                <td class="active">Когда начать работы</td>
                                <td>{{ order.time_period }}</td>
                            </tr>
                            <tr>
                                <td class="active">Бюджет</td>
                                <td>{{ order.budget_scale_id }} руб.</td>
                            </tr>
                            <tr>
                                <td class="active">Объем работ</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="active">Описание заказа</td>
                                <td>{{ order.description }}</td>
                            </tr>
                            <tr>
                                <td class="active">Категория</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td class="active">Пользователь, разместивший заказ</td>
                                <td>
                                    <router-link :to="{name: 'customer', params: { id: order.author.id }}"> {{ order.author.first_name }}  {{ order.author.last_name }}</router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row justify-content-center">
                        <template v-if="role === 'Исполнитель'">
                            <a href="" v-if="flag === false" @click.prevent="createRequest" class="row justify-content-center order-request"> Подать заявку на выполнение заказа</a>
                            <a href="" v-if="flag" @click.prevent="deleteOrderRequest" class="row justify-content-center order-request"> Удалить заявку на выполнение заказа</a>
                        </template>
                        <template v-else>

                        </template>
                    </div>

                    <div>
                        <b-modal ref="myModal" hide-footer title="Ура!">
                            <div class="d-block text-center">
                                <h3>Ваша заявка отправлена!</h3>
                            </div>
                            <b-btn class="mt-3" variant="outline-danger" block @click="hideModal">Закрыть</b-btn>
                        </b-modal>
                    </div>

                    <label class="col-sm-3 control-label"></label>
                    <div class="col-sm-12">
                        <gmap-map  class="form-control maps maps-order" :zoom="zoom"  :center="center">
                            <GmapMarker v-for="(marker, index) in markers"
                                        :key="index"
                                        :position="marker.position"
                            />
                        </gmap-map>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        name: "order-view",
        props:['position'],
        data: () => ({
            flag: false,
            list: [],
            role: false,
            slide: 0,
            sliding: null,
            order: {
                title: '',
                description: '',
                coordinates: '',
                address:'',
                date: '',
                time_period:'',
                budget_scale_id: '',
                author: {
                    id: null,
                    first_name: '',
                    last_name: '',
                }
            },
            zoom: 16,
            center: { lat: 0, lng: 0 },
            markers: [{
                position: {
                    lat: 0,
                    lng: 0,
                }
            }],
        }),
        mounted() {
        },
        async created() {
            let order = await this.$store.dispatch('orders/getOrder', {
                id: this.$route.params.id
            });
            this.order = order.order;
            this.markers[0].position.lat = parseFloat(this.order.coordinates.lat);
            this.markers[0].position.lng = parseFloat(this.order.coordinates.lng);
            this.center = this.markers[0].position;


            this.$ls.remove('list');
            this.list = this.$ls.get('list');
            this.role = this.$ls.get('role');
        },
        watch: {
            list:  function () {
                if (this.list) {

                    console.log(this.list);
                    console.log('check',this.list.indexOf(JSON.parse(this.$route.params.id)));
                    if (this.list.indexOf(JSON.parse(this.$route.params.id)) != -1) {
                        this.flag = true;
                    } else this. flag = false;
                }
            }
        },
        methods: {
            showModal () {
                this.$refs.myModal.show()
            },
            hideModal () {
                this.$refs.myModal.hide()
            },
            onSlideStart (slide) {
                this.sliding = true
            },
            onSlideEnd (slide) {
                this.sliding = false
            },
            createRequest() {
                axios.post(this.init_config.baseURI + '/api/orders/createOrderRequest', {
                    order_id: this.$route.params.id,
                    user_id: this.user.id,
                    status: false
                }).then(
                    response => {
                        let a = [];
                        if (JSON.parse(this.$ls.get('list')) === null)
                            a=[];
                        else
                            a = JSON.parse(this.$ls.get('list'));
                        console.log('a', a);
                        a[this.order.id] = JSON.parse(this.$route.params.id);
                        console.log('a', a);
                        // this.list = a;
                        // this.$ls.set('list', JSON.stringify(a));
                        this.showModal();
                    });
            },
            deleteOrderRequest() {
              // this.$store.dispatch('orders/request/:id', {
              //     // id: ,
              // }).then(
              //     response => {
              //     console.log("DELETE");
              // })
            },
        }
    }
</script>
<style>
    #main {
        padding: 20px;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        border-bottom: 4px solid #ddd;
    }

    .row h3 {
        text-align: left;
        margin: 10px 0;
    }

    table .active {
        background-color: #f2f2f2;
    }
    .maps-order {
        margin-top: 30px;
    }
    .order-request {
        margin-top: 10px;
        font-size: 20px;
    }
</style>