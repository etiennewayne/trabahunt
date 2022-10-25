<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="box">
                        <div class="post-heading has-text-weight-bold">
                            POST JOB
                        </div>
                        <div class="mt-5">
                            <b-field label="JOB DESCRIPTION">
                                <b-input type="textarea" v-model="fields.job_desc"></b-input>
                            </b-field>
                            <b-field label="Job Type">
                                <b-select v-model="fields.job_type">
                                    <option v-for="(item, index) in jobTypes" :key="index" :value="item.jobtype_id">{{ item.jobtype }}</option>
                                </b-select>
                            </b-field>
                        </div>
                        <div class="buttons mt-5">
                            <button class="button is-primary">POST</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <a class="button is-primary is-small is-outlined" tag="a" href="/employer/company-add-edit">
                    <b-icon
                        class="mr-2"
                        icon="plus-thick"
                        type="is-info">
                    </b-icon>
                    ADD COMPANY
                </a>
            </div>


        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            companies: [],
            jobTypes: [],

            fields: {},
            errors: {},
        }
    },

    methods: {
        loadCompanies(){
            axios.get('/employer/get-my-companies').then(res=>{
                this.companies = res.data;
            })
        },

        editCompany(id){
            window.location = '/employer/company-add-edit/' +id;
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

    },

    mounted(){
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
