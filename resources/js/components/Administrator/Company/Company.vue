<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-10">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">COMPANIES</div>

                        <div class="level">
                            <div class="level-left">
                                <b-field label="Page">
                                    <b-select v-model="perPage" @input="setPerPage">
                                        <option value="5">5 per page</option>
                                        <option value="10">10 per page</option>
                                        <option value="15">15 per page</option>
                                        <option value="20">20 per page</option>
                                    </b-select>
                                    <b-select v-model="sortOrder" @input="loadAsyncData">
                                        <option value="asc">ASC</option>
                                        <option value="desc">DESC</option>

                                    </b-select>
                                </b-field>
                            </div>

                            <div class="level-right">
                                <div class="level-item">
                                    <b-field label="Search">
                                        <b-input type="text"
                                                 v-model="search.company" placeholder="Search Company"
                                                 @keyup.native.enter="loadAsyncData"/>
                                        <p class="control">
                                            <b-tooltip label="Search" type="is-success">
                                                <b-button type="is-primary" icon-right="account-filter" @click="loadAsyncData"/>
                                            </b-tooltip>
                                        </p>
                                    </b-field>
                                </div>
                            </div>
                        </div>


                        <b-table
                            :data="data"
                            :loading="loading"
                            paginated
                            backend-pagination
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page"
                            backend-sorting
                            :default-sort-direction="defaultSortDirection"
                            @sort="onSort">

                            <b-table-column field="company_id" label="ID" v-slot="props">
                                {{ props.row.company_id }}
                            </b-table-column>

                            <b-table-column field="company" label="Company Name" v-slot="props">
                                {{ props.row.company }}
                            </b-table-column>

                            <b-table-column field="owner" label="Owner" v-slot="props">
                                {{ props.row.owner }}
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small is-warning mr-1" tag="a" icon-right="pencil" @click="getData(props.row.category_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small is-danger mr-1" icon-right="delete" @click="confirmDelete(props.row.category_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>
                        </b-table>

                        <div class="buttons mt-3">
                            <b-button @click="openModal" icon-right="account-arrow-up-outline" class="is-success">NEW</b-button>
                        </div>

                    </div>
                </div><!--close column-->
            </div>


        </div><!--section div-->



        <!--modal create-->
        <b-modal v-model="isModalCreate" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal
                 type = "is-link">

            <form @submit.prevent="submit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">New/Update Category</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Category"
                                             :type="this.errors.category ? 'is-danger':''"
                                             :message="this.errors.category ? this.errors.category[0] : ''">
                                        <b-input type="text" v-model="fields.category" placeholder="Category" required />
                                    </b-field>
                                </div>
                            </div>

                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="isModalCreate=false"/>
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->


    </div>
</template>

<script>
export default {

    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'company_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',


            global_id : 0,

            search: {
                category: '',
            },

            isModalCreate: false,

            fields: {
                service_id: 0,
                service: '',
                price: 0

            },
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

        }
    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `category=${this.search.category}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/admin/get-companies?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                    })
                    this.loading = false
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },
        /*
        * Handle page-change event
        */
        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },

        openModal(){
            this.isModalCreate=true;
            this.fields = {};
            this.errors = {};


        },



        //alert box ask for deletion
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/admin/companies/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.isModalCreate = true;


            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/admin/companies/' +data_id).then(res=>{
                this.fields = res.data;
            });
        },

        clearFields(){
            this.fields = {
                service: null,
                price: null,
            };
        },


        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/admin/companies/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.isModalCreate = false;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                })
            }else{
                //INSERT HERE
                axios.post('/admin/companies', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.isModalCreate = false;
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });
            }
        }

    },

    mounted() {
        this.loadAsyncData();
    }

}
</script>

<style scoped>

</style>
