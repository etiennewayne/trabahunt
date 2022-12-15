<template>
    <div>
        <div class="section">
            <div class="slogan animate__animated animate__fadeInDown">
                Hunt the best job today!
            </div>
            <div class="slogan animate__animated animate__fadeInDown">
                Hunt the best people for your job!
            </div>
        </div>


        <div class="section filter">
            <div class="job-search-container">
                <div class="columns">
                    <div class="column">
                        <b-field label-position="on-border" label="Job Title or Company Name">
                            <b-input class="search-text" v-model="search.key"
                                     @keydown.enter="loadJobHiring"
                                     type="input" icon-right="magnify" placeholder="Job Title, Company name.."></b-input>

                        </b-field>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <b-field label-position="on-border" label="Job Type" expanded>
                            <b-select v-model="search.jobtype" expanded>
                                <option selected value="">--NONE--</option>
                                <option v-for="(item, index) in jobTypes"  :key="index" :value="item.jobtype">{{ item.jobtype }}</option>
                            </b-select>
                        </b-field>
                    </div>

                    <div class="column">
                        <b-field label-position="on-border" label="Category" expanded>
                            <b-select v-model="search.category" expanded>
                                <option selected value="">--NONE--</option>
                                <option v-for="(item, index) in categories"  :key="index" :value="item.category">{{ item.category }}</option>
                            </b-select>
                        </b-field>
                    </div>
                    <div class="column is-2">
                        <div class="buttons is-centered">
                            <button class="button is-primary is-fullwidth" @click="loadJobHiring">Search</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="result-container">
            <div v-for="(item, index) in jobs" :key="index">
                <div></div>
            </div>
        </div>


        <div class="section">
            <div class="t-box-container">
                <div class="t-box-applicant">
                    <div class="t-box-title">Applicant (Aplikante)</div>
                    <div style="display:flex;">
                        <div>
                            <div class="t-box-applicant-title">Looking for a job?</div>
                            <div class="t-box-applicant-subtitle">Nangita ka ug trabaho?</div>
                        </div>
                        <div>
                            <button @click="applyNow" class="applicant-button"><span>Apply now!</span></button>
                        </div>
                    </div>
                </div>

                <div class="t-box-applicant">
                    <div class="t-box-title">Employer (Amo)</div>
                    <div style="display: flex;">
                        <div>
                            <div class="t-box-applicant-title">Are you hiring?</div>
                            <div class="t-box-applicant-subtitle">Naghire ba ka?</div>
                        </div>
                        <div>
                            <button class="applicant-button" @click="signup"><span>Register now!</span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="section">
            <div>
                <h1 class="title" style="text-align: center;">Browse Your Desire Category</h1>
            </div>

            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="category-container">
                        <div class="category-box" v-for="(item, index) in categories" :key="index">
                            <div class="category-content">
                                <div class="category-icon">
                                    <b-icon size="is-large" icon="account"></b-icon>
                                </div>
                                <div class="category-desc">
                                    {{ item.category }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--col-->
            </div><!--cols-->
        </div>




    </div> <!--root div-->
</template>

<script>
export default {
    props: ['propUser', 'propCategories', 'propJobTypes'],
    data(){
        return{
            locale: undefined,
            isModalActive: false,

            search: {
                jobtype: '',
                category: '',
                key: ''
            },
            categories: [],
            jobTypes: [],
            jobs: [],
        }

    },

    methods: {
        signup: function(){
            window.location = '/employer/signup'
        },

        loadJobHiring(){
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `key=${this.search.key}`,
                `jobtype=${this.search.jobtype}`,
                `category=${this.search.category}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            axios.get(`/get-jobs-hiring?${params}`).then(res=>{
                this.jobs = res.data
            })
        },

        initData(){
            this.categories = JSON.parse(this.propCategories);
            this.jobTypes = JSON.parse(this.propJobTypes);
        },
        applyNow: function(){
            window.location = '/sign-up';
        }

    },

    mounted() {
        this.initData();
    },


}
</script>

<style scoped>


    .slogan{
        font-weight: bold;
        font-size: 3em;
        color: rgb(0, 100, 0);
        text-align: center;
    }

    .filter{
        background: #fffcfc;
    }
    .job-search-container{
        max-width: 1024px;
        /*border: 1px solid red;*/
        margin: auto;
    }
    .result-container{
        max-width: 1024px;
        border: 1px solid red;
        margin: auto;
    }



    /* APPLICANT EMPOYER SECTION */

    .t-box-container{
        display: flex;
        justify-content: center;
    }

    .t-box-applicant{
        padding: 20px;
        border-radius: 30px;
        background-color: green;
        color: white;
        margin: 10px;
    }

    .t-box-title{
        font-weight: bold;
        font-size: 1em;
    }
    .t-box-applicant-title{
        font-weight: bold;
        font-size: 1.2em;
    }

    .t-box-applicant-subtitle{
        padding: 15px;
    }

    .applicant-button{
        padding: 15px;
        border-radius: 30px;
        border: 1px solid green;
        font-weight: bold;
        color:green;
    }

    /* .applicant-button:hover{
        background-color: rgb(179, 250, 165);
        cursor: pointer;
    } */
    .applicant-button:active {
        /* background-color: #3e8e41;
        box-shadow: 0 5px #666; */
        transform: translateY(4px);
    }


    .applicant-button {
        transition-duration: 0.4s;
    }

    .applicant-button span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
    }

    .applicant-button span:after {
        content: '\00bb';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
    }

    .applicant-button:hover span {
        padding-right: 25px;
    }

    .applicant-button:hover span:after {
        opacity: 1;
        right: 0;
    }



/* CATEGORY CONTAINER */

    .category-container{
        margin-top: 15px;
        display: flex;
        flex-wrap: wrap;
    }
    .category-box{
        background-color: green;
        padding: 25px;
        color: white;
        width: 150px;
        height: 150px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 5px;
    }

    .category-content{
        margin: auto;
    }
    .category-icon{
        margin: auto;
        text-align: center;
    }
    .category-desc{
        font-weight: bold;
        text-align: center;
    }
















    @media only screen and (max-width: 1024px) {

    }

    @media only screen and (max-width: 768px) {
        .main-text-container{
            top: 230px;
            width: 100%;
            margin: 0;
        }
    }

    @media only screen and (max-width: 480px) {
        .main-text-container{
            padding: 15px;
        }
        .main-title{
            font-size: 1.2em;
        }

        .main-subtitle{
            font-size: .8em;
        }

    }







</style>
