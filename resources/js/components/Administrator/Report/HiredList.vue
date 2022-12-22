<template>
    <div>
       
        <div class="printarea">
            <div class="buttons">
                <a class="button" href="/admin/home">BACK</a>
            </div>
            
            <div class="report-head">
                LIST OF HIRED EMPLOYEES
            </div>

            <div class="report-body">
                <table class="report-table" border="1">
                    <tr>
                        <th>Name</th>
                        <th>Sex</th>
                        <th>Contact No.</th>
                        <th>Email</th>
                        <th>Company</th>
                        <th>Date Hired</th>
                    </tr>
                    <tr v-for="(item, index) in data" :key="index">
                        <td>{{ item.applicant.lname }}, {{  item.applicant.fname }} {{ item.applicant.mname }}</td>
                        <td>{{ item.applicant.sex }}</td>
                        <td>{{ item.contact_no }}</td>
                        <td>{{ item.email }}</td>
                        <td>{{ item.job_post.company.company }}</td>
                        <td>{{ item.date_hired }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div><!-- root-->
</template>

<script>

export default{
    props: ['propData'],
    data(){
        return {
            data: [],
        }
    },

    methods: {
        initData(){
            this.data = JSON.parse(this.propData)
        }
    },

    mounted(){
        this.initData()
    }
}
</script>