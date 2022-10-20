<template>
    <div>
        <div class="section">

            <div class="buttons">
                <a class="button is-primary" tag="a" href="/employer/company-add-edit">ADD COMPANY</a>
            </div>

            <div class="company-container">
                <div class="company-box" v-for="(item, index) in companies" :key="index">
                    <div class="company-title">
                        {{ item.company }}
                    </div>
                    <hr>
                    <div class="company-desc">
                        {{ item.overview }}
                    </div>
                    <div class="company-footer">
                         {{ item.owner_account.lname }}, {{ item.owner_account.fname }} {{ item.owner_account.middlename }}
                    </div>

                    <div class="buttons">
                        <b-button tag="a" class="button is-primary" href="/employer/company/1">VIEW COMPANY</b-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            companies: []
        }
    },

    methods: {
        loadCompanies(){
            axios.get('/employer/get-my-companies').then(res=>{
                this.companies = res.data;
            })
        }
    },

    mounted(){
        this.loadCompanies();
    }
}
</script>
<style scoped>
    .company-container{
        display: flex;
    }

    .company-box{
        width: 300px;
        border: 1px solid gray;
        padding: 15px;
        margin: 10px;
    }

    .company-title{
        font-weight: bold;
    }

    .company-footer{
        margin: 15px 0 15px 0;
        border-top: 1px solid rgb(207, 207, 207);
    }
</style>