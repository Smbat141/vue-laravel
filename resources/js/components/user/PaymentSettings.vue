<template>
    <div>
        <div class="container">
            <div class="row">
                <div class="row" v-if="userCardParams.active">
                    <div class="col">
                        <div class="card" style="">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    Your current card <b>****.****.****.{{userCardParams.card_last_four}}</b>
                                    <span
                                            class="btn btn-sm btn-outline-warning"
                                            data-toggle="collapse"
                                            aria-expanded="false"
                                            aria-controls="collapseExample"
                                            href="#changeCard"
                                    >
                                    Change
                                    </span>
                                </li>
                                <li class="list-group-item">
                                    Card brand <b>{{userCardParams.card_brand}}</b>
                                </li>
                                <li class="list-group-item" v-if="userCardParams.subscribe_plan !== false">
                                   Your Plan <b>{{userCardParams.subscribe_plan}}</b>
                                    <span
                                            class="btn btn-sm btn-outline-warning"
                                            data-toggle="collapse"
                                            aria-expanded="false"
                                            aria-controls="collapseExample"
                                            href="#changePlan"

                                    >
                                    Change
                                    </span>
                                    <span
                                            class="btn btn-sm btn-outline-danger"
                                            @click="CancelSub"
                                    >
                                    Cancel Subscription
                                    </span>
                                </li>
                                <li class="list-group-item" v-else>
                                    <b>No Subscribe</b>
                                    <span
                                            class="btn btn-sm btn-outline-warning"
                                            data-toggle="collapse"
                                            aria-expanded="false"
                                            aria-controls="collapseExample"
                                            href="#subscribePlan"
                                    >
                                    Subscribe
                                    </span>
                                </li>
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
                                                           v-model="newCardParams.number"
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
                                                               v-model="newCardParams.month"
                                                               :maxlength="2"

                                                        />
                                                    </div>
                                                </div>
                                                <div class="col-xs-4 col-md-4 ">
                                                    <div class="form-group">
                                                        <label for="year">
                                                            Exp year</label>
                                                        <input type="text" class="form-control" id="year" placeholder="YY"
                                                               v-model="newCardParams.year"
                                                               :maxlength="4"
                                                               required/>
                                                    </div>
                                                </div>
                                                <div class="col-xs-4 col-md-4">
                                                    <div class="form-group">
                                                        <label for="cvc">
                                                            CVC CODE</label>
                                                        <input type="text" class="form-control" id="cvc" placeholder="CVC"
                                                               v-model="newCardParams.cvc"
                                                               :maxlength="3"
                                                               required/>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <span class="text-danger">{{errorMessage}}</span>
                                <button @click="SaveCardSettings" class="btn btn-warning btn-lg btn-block" role="button">Save</button>
                            </div>
                        </div>
                    </div>
                    <div class="collapse col" id="changePlan">
                        <div v-if="Object.keys(userCardParams.subscribe_plan).length > 0" class="container">
                            <h1>
                                Change plan
                            </h1>
                            <form @prevent>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect02">Options</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect02" v-model="new_plan_name">
                                        <option disabled value="">Select Plan</option>
                                        <option
                                                :value="{name:'Monthly',plan_id:'plan_FASMxFBcGUkT0P',current_plan:userCardParams.subscribe_plan}"
                                                v-show="userCardParams.subscribe_plan !== 'Monthly'"
                                        >
                                            Subscribe the Monthly plan $40
                                        </option>
                                        <option
                                                :value="{name:'Daily',plan_id:'plan_FATJvPhOW3xHYV',current_plan:userCardParams.subscribe_plan}"
                                                v-show="userCardParams.subscribe_plan !== 'Daily'"
                                        >
                                        Subscribe the Daily plan $10
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-sm btn-outline-warning" @click="changePlan">Save</button>
                            </form>
                        </div>
                    </div>
                    <div class="collapse col" id="subscribePlan" v-show="Object.keys(userCardParams.subscribe_plan).length === 0">
                        <div class="container">
                            <h1>
                                Subscribe plan
                            </h1>
                            <form @prevent>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="inputGroupSelect03">Options</label>
                                    </div>
                                    <select class="custom-select" id="inputGroupSelect03" v-model="new_plan_name">
                                        <option disabled value="">Select Plan</option>
                                        <option
                                                :value="{name:'Monthly',plan_id:'plan_FASMxFBcGUkT0P',current_plan:userCardParams.subscribe_plan}"
                                        >
                                            Subscribe the Monthly plan $40
                                        </option>
                                        <option
                                                :value="{name:'Daily',plan_id:'plan_FATJvPhOW3xHYV',current_plan:userCardParams.subscribe_plan}"
                                        >
                                        Subscribe the Daily plan $10
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-sm btn-outline-warning" @click="subscribe">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col" v-else>
                    <div class="row">
                        <div class="col">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        Create new Card
                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <form role="form" >
                                        <div class="form-group">
                                            <label for="cardNumber">
                                                CARD NUMBER</label>
                                            <div class="input-group">
                                                <input type="text"  class="form-control"
                                                       placeholder="Valid Card Number"
                                                       required autofocus
                                                       v-model="newCardParams.number"
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
                                                    <input type="text" class="form-control"  placeholder="MM"
                                                           required
                                                           v-model="newCardParams.month"
                                                           :maxlength="2"

                                                    />
                                                </div>
                                            </div>
                                            <div class="col-xs-4 col-md-4 ">
                                                <div class="form-group">
                                                    <label for="year">
                                                        Exp year</label>
                                                    <input type="text" class="form-control"  placeholder="YY"
                                                           v-model="newCardParams.year"
                                                           :maxlength="4"
                                                           required/>
                                                </div>
                                            </div>
                                            <div class="col-xs-4 col-md-4">
                                                <div class="form-group">
                                                    <label for="cvc">
                                                        CVC CODE</label>
                                                    <input type="text" class="form-control"  placeholder="CVC"
                                                           v-model="newCardParams.cvc"
                                                           :maxlength="3"
                                                           required/>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <span class="text-danger">{{errorMessage}}</span>
                            <button @click="SaveCardSettings" class="btn btn-warning btn-lg btn-block" role="button">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<div v-if="Object.keys(userCardParams.subscribe_plan).length === 0">
            <h1>
                Select your payment plan
            </h1>
            <form @prevent>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01" v-model="new_plan_name">
                        <option :value="{name:'Monthly',plan_id:'plan_FASMxFBcGUkT0P'}">Subscribe the Monthly plan $40</option>
                        <option :value="{name:'Daily',plan_id:'plan_FATJvPhOW3xHYV'}">Subscribe the Daily plan $10</option>
                    </select>
                </div>
                <button class="btn btn-sm btn-outline-warning" @click="subscribe">Save</button>
            </form>
        </div>-->

    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "PaymentSettings",
        data(){
          return{
              newCardParams:{
                  number:null,
                  month:null,
                  year:null,
                  cvc:null,
              },
              userCardParams:{
                  active:false,
                  card_last_four:null,
                  card_brand:'',
                  subscribe_plan:'',
              },
              errorMessage:'',
              new_plan_name:'',
          }
        },
        computed: {
            auth() {
                return this.$store.getters.getAuth;
            }
        },
        methods:{
            getCardParams(){
                axios.get('api/user-subscriptions',{
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.user.api_token
                    }
                }).then(res=>{
                    if(res.status === 200){
                        this.userCardParams = {...res.data};
                        this.newCardParams = {...''}
                        this.userCardParams.active = true;
                    }
                })
            },
            SaveCardSettings(){
                    axios.post('api/new-card',this.newCardParams,{
                        headers: {
                            'Accept': 'application/json',
                            'Authorization': 'Bearer ' + this.auth.user.api_token
                        }
                    }).then(res=>{
                        this.getCardParams();
                    }).catch(err => {
                        this.errorMessage = err.response.data.message;
                    })
            },
            subscribe(){
                axios.post('api/subscribe',{'plan_params':this.new_plan_name},{
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.user.api_token
                    }
                }).then(res=>{
                    if(res.status === 200){
                        this.getCardParams();
                    }
                }).catch()
            },
            changePlan(){
                axios.post('api/change-plan',this.new_plan_name,{
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.user.api_token
                    }
                }).then(res => {
                    if(res.status === 200) {
                        this.getCardParams();
                    }
                })
            },
            CancelSub(){
                if(window.confirm('Are your sure?'))
                axios.post('api/cancel-subscription',{name:this.userCardParams.subscribe_plan},{
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.auth.user.api_token
                    }
                }).then(res=>{
                    if(res.status === 200){
                        this.getCardParams();
                    }
                })
            }
        },
        created() {
            axios.get('api/user-subscriptions',{
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + this.auth.user.api_token
                }
            }).then(res=>{
                if(res.status === 200){
                    if(res.data !== false){
                        this.userCardParams = {...res.data};
                        this.userCardParams.active = true;
                    }
                }
            }).catch()
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
