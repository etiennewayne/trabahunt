<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-8">
                    <form @submit.prevent="submit">
                        <div class="box">
                            <div class="post-heading has-text-weight-bold">
                                POST JOB
                            </div>
    
                            <div class="mt-5">
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="JOB DESCRIPTION">
                                            <b-input type="textarea" v-model="fields.job_desc"></b-input>
                                        </b-field>
                                    </div>
                                </div>
    
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Category" expanded>
                                            <b-select v-model="fields.category" expanded>
                                                <option v-for="(item, index) in categories" :key="index" :value="item.category_id">{{ item.category }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Job Type" expanded>
                                            <b-select v-model="fields.job_type" expanded>
                                                <option v-for="(item, index) in jobTypes" :key="index" :value="item.jobtype_id">{{ item.jobtype }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        
                                        <b-field label="Price (PESO)">
                                            <b-input type="text" v-model="fields.price" placeholder="Price (PESO)"></b-input>
                                        </b-field>
                                    </div>
         
                                </div> <!--cols-->
                            </div>
    
                            <div class="buttons mt-5">
                                <button class="button is-primary">POST</button>
                            </div>
                        </div> <!--box-->
                    </form>
                </div>
            </div>

        </div> <!--section -->

        <div class="columns is-centered">
            <div class="column is-8">


                
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: ['propCompanyId', 'propJobTypes', 'propCategories'],

    data() {
        return {
            categories: [],
            jobTypes: [],

            fields: {},
            errors: {},

            companyId: null,

            jobPost: [],

        }
    },

    methods: {
        loadCompanies(){
            axios.get('/employer/get-my-companies').then(res=>{
                this.companies = res.data;
            })
        },

        loadJobPost(){
            axios.get('/employer/get-job-post?cid='+this.companyId).then(res=>{
                this.jobPost = res.data;
            })
        },

        submit(){
            axios.post('/employer/company-job-post/' + this.companyId, this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: "SAVED!",
                        message: 'Register successfully',
                        type: 'is-success',
                        onConfirm: ()=>  window.location = '/employer/company-job-post/' +this.companyId
                    });
                }
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
            });

        },


        //alert box ask for deletion
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this company? This action cannot be undone.',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/employer/company-delete/' + delete_id).then(res => {
                this.loadCompanies();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        initData(){
            this.jobTypes = this.propJobTypes;
            this.categories = this.propCategories;
            console.log(this.propCompanyId);
            this.companyId = this.propCompanyId;
            this.fields.company_id = this.companyId;
        }

    },

    mounted(){
        this.initData();
        this.loadJobPost();
        this.loadCompanies();
    }
}
</script>
<style scoped>
    .post-heading{
        margin-bottom: 10px;
        border-bottom: 1px solid gray;
    }
</style>
