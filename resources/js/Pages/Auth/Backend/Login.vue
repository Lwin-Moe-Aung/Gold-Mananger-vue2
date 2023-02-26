<template>
    <div class="container mt-5">
        <div class="col-md-4 offset-4">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form @submit.prevent="login">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" :class="['form-control',errors.email?'border-danger':'']" v-model="form.email">
                            <small v-if="errors.email" class="text text-danger"> {{ errors.email }}</small>

                        </div>
                         <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" :class="['form-control',errors.password?'border-danger':'']" v-model="form.password">
                            <small v-if="errors.password" class="text text-danger"> {{ errors.password }}</small>
                        </div>
                        <button class="btn btn-sm btn-success float-right">
                            <div v-if="loading" class="spinner-border spinner-border-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <span v-show="loading">Wait..</span>
                                <span v-show="!loading">Login</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default{
        name:"Login",
        props:{errors:Object},
        data() {
            return {
                loading: false,
                form: this.$inertia.form({
                    email:"",
                    password: "",
                }),
            }
        },
        methods: {
            login() {

                // var data = new FormData();
                // data.append("email", this.email);
                // data.append("password", this.password);
                // this.$inertia.post("/login", data);
                var headers = {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                this.form.post(this.route('post.login'), {
                    preserveScroll: true,
                    headers: headers,
                    onSuccess:() => {
                        this.loading = true;
                        Toast.fire({
                            icon: 'success',
                            title: 'Login Success!'
                        })
                    }
                })
            }
        },
    }
</script>
