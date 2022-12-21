<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-10">

                    <div class="box-container" v-for="(applicant, index) in applicants" :key="index">
                        <div class="box">
                            <div>
                                Date Applied: {{ applicant.created_at | formatDateTime }}
                            </div>
                            <div>
                                Name: {{ applicant.applicant.lname }}, {{ applicant.applicant.fname }} {{ applicant.applicant.mname }}
                            </div>
                            <div>
                                Address: {{ applicant.applicant.street }}, {{ applicant.applicant.barangay }} {{ applicant.applicant.city }} {{ applicant.applicant.province }}
                            </div>
                            <div>
                                Message: {{ applicant.pitch }}
                            </div>
                            <div>
                                Resume: 
                                    <a class="is-small button"
                                        v-if="applicant.resume_path"
                                        :href="`/employer/display-resume/${applicant.applicant_id}`">View</a>
                            </div>
                            <div class="buttons mt-5">
                                <button class="button is-primary">Accept</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default{
    props: ['propJobPostId'],
    data(){
        return {
            job_post_id: 0,
            applicants: [],
        }
    },

    methods: {
        initData(){
            this.job_post_id = parseFloat(this.propJobPostId)
        },

        getApplicants(){
            axios.get('/employer/get-applicants/' + this.job_post_id).then(res=>{
                this.applicants = res.data
                console.log(res.data)
            })
        }
    },

    mounted(){
        this.initData();
        this.getApplicants();
    }

}
</script>

<style scoped>

    .box-container{
        margin: 15px 0;
    }

</style>>