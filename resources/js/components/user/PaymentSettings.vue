<template>
    <div>
        <div>
            <h1>
                Select your payment
            </h1>
            <form action="">
                <div class="input-group mb-3">

                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01">
                        <option value="1">Create Post every time pay 5$</option>
                        <option value="2">Subscribe the Montly plan</option>
                        <option value="3">Subscribe the Daily plan</option>
                    </select>
                </div>
                <button class="btn btn-sm btn-outline-warning">Save</button>
            </form>
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="card" style="">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                Your current card <b>****.****.****.4242</b>
                                <span
                                        class="btn btn-sm btn-outline-warning"
                                        data-toggle="collapse"
                                        aria-expanded="false"
                                        aria-controls="collapseExample"
                                        href="#changeCard"
                                >Change</span>
                            </li>
                            <li class="list-group-item">Vestibulum at eros</li>
                        </ul>
                    </div>
                </div>
                <div  class="collapse col" id="changeCard">
                    <div class="row">
                        <div class="col">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Payment Details
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <form role="form" >
                                        <div class="form-group">
                                            <label for="cardNumber">
                                                CARD NUMBER</label>
                                            <div class="input-group">
                                                <input type="text"  class="form-control" id="cardNumber"
                                                       placeholder="Valid Card Number"
                                                       required autofocus
                                                       v-model="cardParams.number"
                                                       :maxlength="16"
                                                />
                                                <span class="input-group-addon"><span
                                                        class="glyphicon glyphicon-lock"></span></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-4 col-md-4 ">
                                                <div class="form-group">
                                                    <label for="month">
                                                        Exp Month</label>
                                                    <input type="text" class="form-control" id="month" placeholder="MM"
                                                           required
                                                           v-model="cardParams.month"
                                                           :maxlength="2"

                                                    />
                                                </div>
                                            </div>
                                            <div class="col-xs-4 col-md-4 ">
                                                <div class="form-group">
                                                    <label for="year">
                                                        Exp year</label>
                                                    <input type="text" class="form-control" id="year" placeholder="YY"
                                                           v-model="cardParams.year"
                                                           :maxlength="4"
                                                           required/>
                                                </div>
                                            </div>
                                            <div class="col-xs-4 col-md-4">
                                                <div class="form-group">
                                                    <label for="cvc">
                                                        CVC CODE</label>
                                                    <input type="text" class="form-control" id="cvc" placeholder="CVC"
                                                           v-model="cardParams.cvc"
                                                           :maxlength="3"
                                                           required/>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <button @click="SaveCardSettings" class="btn btn-warning btn-lg btn-block" role="button">Save</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "PaymentSettings",
        data(){
          return{
              cardParams:{
                  number:null,
                  month:null,
                  year:null,
                  cvc:null,
              },
                stripe:'pk_test_RlXH1I8awnngOj6V9mzdwG3P00enKwr5bm'
          }
        },
        computed: {
            auth() {
                return this.$store.getters.getAuth;
            }
        },
        methods:{
            SaveCardSettings(){
                axios.post('api/payment',this.cardParams,{
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.user.api_token
                    }
                }).then(res=>{
                    console.log(res);
                })

            }
        },
        created() {

        }
    }
</script>

<style scoped>
    .panel-title {
        display: inline;
        font-weight: bold;
    }

    .checkbox.pull-right {
        margin: 0;
    }

    .pl-ziro {
        padding-left: 0px;
    }
    #cardNumber::-webkit-inner-spin-button
     {
        display: none;
    }
</style>
