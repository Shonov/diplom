<template>
    <div class="content">
        <section id="services" class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Не хотите сами искать нужного профессионала?</h2>
                        <div class="row justify-content-center">
                            <h5>Добавьте заказ и они сами найдут вас!</h5>
                            <template v-if="!role || role !== 'Исполнитель'">
                                <router-link :to="{name: 'order-create'}" class="link">Создать заказ</router-link>
                            </template>
                        </div>
                            <h5 class="margin-title">Как работает наш сервис</h5>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="right"><img src="~@/assets/img/right.png"/></div>
                        <div class="service">
                            <div class="service-circle"><img src="~@/assets/img/pensil.png"/></div>
                            <h5>Создайте заказ</h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="right"><img src="~@/assets/img/right.png"/></div>
                        <div class="service">
                            <div class="service-circle"><img src="~@/assets/img/search.png"/></div>
                            <h5>Исполнители обратятся к вам</h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="right"><img src="~@/assets/img/right.png"/></div>
                        <div class="service">
                            <div class="service-circle"><img src="~@/assets/img/black.png"/></div>
                            <h5>За вами выбор лучшего</h5>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="service">
                            <div class="service-circle"><img src="~@/assets/img/home.png"/></div>
                            <h5>Пора работать</h5>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="advantages" class="section-padding advantages">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Преимущества</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-4">
                            <h4>Lorem ipsum</h4>
                            <h6>Lorem ipsum dolor sit amet</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                        <div class="col-lg-4">
                            <h4>Lorem ipsum</h4>
                            <h6>Lorem ipsum dolor sit amet</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                        <div class="col-lg-4">
                            <h4>Lorem ipsum</h4>
                            <h6>Lorem ipsum dolor sit amet</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="categories-work" class="section-padding categories">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h2>Доступные категроии работ</h2>
                    </div>
                    <div class="row ml-auto">
                        <div class="col-lg-6">
                            <ul>
                                <li><span> ▶ </span>Ремонтно-отделочные работы</li>
                                <li><span> ▶ </span>Строительство</li>
                                <li><span> ▶ </span>Архитектура, дизайн и проектирование</li>
                                <li><span> ▶ </span>Доставка, грузоперевозки</li>
                                <li><span> ▶ </span>Разнорабочие, грузчики</li>
                                <li><span> ▶ </span>Срочные работы (электрик, сантехник, срочный монтаж сплит-систем)</li>
                                <li><span> ▶ </span>Строительная техника</li>
                                <li><span> ▶ </span>Клининг</li>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <ul>
                                <li><span> ▶ </span>Вентиляция и кондиционирование</li>
                                <li><span> ▶ </span>Видеонаблюдение, домофоны, спутниковое ТВ</li>
                                <li><span> ▶ </span>Изготовление кухонь,шкафов и мебели</li>
                                <li><span> ▶ </span>Душевые кабины и изделия из стекла</li>
                                <li><span> ▶ </span>Окна</li>
                                <li><span> ▶ </span>Благоустройство и уход за территорией</li>
                                <li><span> ▶ </span>Экспертиза</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="footer" class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-text">ProfRlatforma 2018. &copy; Все права защищены</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    export default {
        name: "index",
        created() {
            this.role = this.$ls.get('role', false);
            console.log(this.role);
        }
    }
</script>