export default {
    install(Vue, options) {
        Vue.mixin({
            data() {
                return {
                    route_mixin: true
                }
            },
            methods: {
                go_to(name) {
                    this.$router.push({
                        name
                    })
                },
                go_to_root() {
                    this.$router.push({})
                },
                go_to_push() {

                },
                go_back(){
                    this.$router.go(-1)
                },
                go_to_user(user){
                    this.$router.push({
                        name:"users-view",
                        params:{
                            id:user.id,
                            user
                        }
                    })
                }
            }
        })
    }
}