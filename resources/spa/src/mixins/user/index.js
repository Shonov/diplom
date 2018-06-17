import axios from 'axios'

export default {
    install(Vue, options) {
        Vue.mixin({
            watch: {},
            data() {
                return {
                }
            },
            computed: {},
            methods: {
                sign_in(data) {
                    let base = this.init_config.baseURI;
                    axios.post(base + '/api/login', {
                        login: data.login,
                        password: data.password
                    }).then(
                        response => {
                            console.log("Auth info", response);
                            let {user, token, status, role} = response.data;
                            this.$ls.set('token', token);
                            this.$ls.set('role', role[0].title);
                            this.$ls.set('user', JSON.stringify(user));
                            location.reload();
                            this.go_to(data.url);
                        }
                    ).catch(e => {
                        console.error(e);
                    })
                },
                _clear_user_info() {
                    this.$ls.remove('user');
                    this.$ls.remove('role');
                    this.$ls.remove('token');
                },
                exit() {
                    Vue.ls.remove('token','user', 'status', 'role', false);
                    location.reload();
                    this.go_to('main');
                    // this.isLogged = this.checkIfIsLogged();
                },
            },
            created() {
                let user = this.$ls.get('user', false);
                let token = this.$ls.get('token', false);
                if (user && token) {
                    try {
                        this.user = JSON.parse(user);
                        this.$store.commit('user/token', token);
                    } catch (e) {
                        console.error(e);
                        this._clear_user_info();
                    }
                } else {
                    this._clear_user_info();
                }
            },
        })
    }
}