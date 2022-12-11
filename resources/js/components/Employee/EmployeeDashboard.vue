<template>
    <div>
        <div class="section">
            <div class="feeds-container">
                <div class="feeds-title">NEWS FEED</div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    props: ['propUser'],

    data(){
        return{
            search: {
                categories: [],
            },
            jobs: [],

            user: {},
            categories: [],
        }
    },
    methods: {

        initData(){
            this.user = JSON.parse(this.propUser)
        },

        getRecommendedJobs(){

            this.user.categories.forEach(job => {
                this.categories.push(job.category.category)
            })


            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `categories=${this.categories}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            axios.get(`/get-recommended-jobs?${params}`).then(res=>{
                this.jobs = res.data;
                console.log(this.jobs)
            })
        }
    },

    mounted() {
        this.initData()
        this.getRecommendedJobs()
    }
}
</script>

<style scoped>

.feeds-container{
    display: flex;
    flex-direction: column;
}

.feeds-title{
    font-weight: bold;
}



</style>
