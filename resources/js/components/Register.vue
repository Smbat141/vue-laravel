<template>
   <!-- <div class="container">
        <form class="form-horizontal" role="form" @submit.prevent>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <h2>Register New User</h2>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="name">Name</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon is-invalid" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                            <input v-model="credentials.name" v-validate="'required|min:3'" type="text" name="name" class="form-control" id="name"  placeholder="John">
                        </div>
                    </div>

                </div>
                <div class="col-md-3 ">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" v-show="errors.has('name')">
                            <i class="fas fa-window-close" > {{errors.first('name')}}</i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="name">Surname</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon is-invalid" style="width: 2.6rem"><i class="fa fa-user"></i></div>
                            <input v-validate="'required|min:5'" type="text" name="surname" class="form-control" id="surname" v-model="credentials.surname"   placeholder="Morgan">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" v-show="errors.has('surname')">
                            <i class="fas fa-window-close" > {{errors.first('surname')}}</i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="email">E-Mail Address</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-at"></i></div>
                            <input v-validate="'email'" type="text" name="email" class="form-control" id="email" v-model="credentials.email"
                                   placeholder="you@example.com" required autofocus>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" v-show="errors.has('email')">
                            <i class="fas fa-window-close" > {{errors.first('email')}}</i>
                        </span>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="password">Password</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group has-danger">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem"><i class="fa fa-key"></i></div>
                            <input v-validate="'required|min:8'" ref="password" type="password" name="password" class="form-control" id="password" v-model="credentials.password"
                                   placeholder="Password" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                         <span class="text-danger align-middle" v-show="errors.has('password')">
                            <i class="fas fa-window-close" > {{errors.first('password')}}</i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 field-label-responsive">
                    <label for="password">Confirm Password</label>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                            <div class="input-group-addon" style="width: 2.6rem">
                                <i class="fas fa-redo-alt"></i>
                            </div>
                            <input v-validate="'confirmed:password'" data-vv-as="password" type="password" name="confirm_password" class="form-control" v-model="credentials.confirm_password"
                                   id="password-confirm" placeholder="Password" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-control-feedback">
                        <span class="text-danger align-middle" v-show="errors.has('confirm_password')">
                            <i class="fas fa-window-close" > {{errors.first('confirm_password')}}</i>
                        </span>
                    </div>
                </div>
            </div>
            <span class="text-danger align-middle" v-show="emailExist">
                    <i class="fas fa-window-close" > Email exist</i>
            </span>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <button type="submit"  class="btn btn-success" :disabled="errors.any() || !isComplete" @click="register">
                        <i class="fa fa-user-plus">Register</i>
                    </button>
                </div>
            </div>
        </form>
    </div>-->
</template>

<script>
    export default {
        name: "Register"
    }
</script>

<style scoped>

</style>
