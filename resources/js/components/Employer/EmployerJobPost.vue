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
                                        <b-field label="TITLE">
                                            <b-input type="text" v-model="fields.title" placeholder="Title"></b-input>
                                        </b-field>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Job Description">
                                            <b-input type="textarea" v-model="fields.job_desc" placeholder="Job description"></b-input>
                                        </b-field>
                                    </div>
                                </div>
    
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Category" expanded>
                                            <b-select v-model="fields.category" expanded placeholder="Category">
                                                <option v-for="(item, index) in categories" :key="index" :value="item.category_id">{{ item.category }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Job Type" expanded>
                                            <b-select v-model="fields.job_type" expanded placeholder="Job Type">
                                                <option v-for="(item, index) in jobTypes" :key="index" :value="item.jobtype_id">{{ item.jobtype }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        
                                        <b-field label="Salary (PESO)">
                                            <b-input type="text" v-model="fields.salary" placeholder="Salary (PESO)"></b-input>
                                        </b-field>
                                    </div>
         
                                </div> <!--cols-->
                            </div>
    
                            <div class="buttons mt-5">
                                <button class="button is-primary">POSTS</button>
                            </div>
                        </div> <!--box-->
                    </form>
                </div>
            </div>

        </div> <!--section -->
        
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-8">
                    
                    <div class="box-post" v-for="(item, index) in jobPosts" :key="index">
                        <div class="box-post-heading">
                            {{ item.title }}
                        </div>
                        <div class="box-post-body">
                            <div>
                                {{ item.job_desc }}
                            </div>
                           
                        </div>
                        <div class="box-post-footer">
                            <div>
                                <span>JOB TYPE: </span>
                                {{ item.jobtype.jobtype }}
                            </div>

                            <div>
                                <span>SALARY: </span>
                                {{ item.salary }}
                            </div>
                        </div>
                    </div>
                
     
                    <b-pagination
                        :total="total"
                        v-model="current"
                       
                        :per-page="perPage"
                        :icon-prev="prevIcon"
                        :icon-next="nextIcon"
                        aria-next-label="Next page"
                        aria-previous-label="Previous page"
                        aria-page-label="Page"
                        aria-current-label="Current page">
                    </b-pagination>
                    
                </div>
            </div>
        </div><!--section-->
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

            jobPosts: [],


            //pagination
            total: 0,
            current: 1,
            page: 1,
            perPage: 5,
            //rangeBefore: 3,
            //rangeAfter: 1,
            //order: '',
            //size: '',
            //isSimple: false,
           // isRounded: false,
            //hasInput: false,
            prevIcon: 'chevron-left',
            nextIcon: 'chevron-right',
            //inputPosition: '',
            //inputDebounce: '',

            sortField: 'job_post_id',
            sortOrder: 'desc',

        }
    },

    methods: {
        loadCompanies(){
            axios.get('/employer/get-my-companies').then(res=>{
                this.companies = res.data;
            })
        },

        loadJobPosts(){
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `cid=${this.companyId}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            //this.loading = true
            axios.get(`/employer/get-job-post?${params}`)
                .then(({ data }) => {
                    this.jobPosts = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.jobPosts.push(item)
                    })
                    //this.loading = false
                })
                .catch((error) => {
                    this.jobPosts = []
                    this.total = 0
                    this.loading = false
                    throw error
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
        this.loadJobPosts();
        this.loadCompanies();
    }
}
</script>
<style scoped>
    .post-heading{
        margin-bottom: 10px;
        border-bottom: 1px solid gray;
    }

    .box-post{
        border: 1px solid gray;
        margin: 15px 0;
    }

    .box-post-heading{
        padding: 15px;
    }
    .box-post-body{
        padding: 15px;
    }
    .box-post-footer{
        padding: 15px;
        display: flex;
        justify-content: space-evenly;
    }
</style>
