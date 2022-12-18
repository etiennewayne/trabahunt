<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-8">
                    <form @submit.prevent="submit">
                        <div class="box">
                            <div class="has-text-weight-bold">
                                POST JOB
                            </div>
                            <hr>
                            <div class="mt-5">
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="TITLE"
                                            :type="this.errors.title ? 'is-danger':''"
                                            :message="this.errors.title ? this.errors.title[0] : ''">
                                            <b-input type="text" v-model="fields.title" placeholder="Title" required></b-input>
                                        </b-field>
                                    </div>
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Job Description"
                                            :type="this.errors.job_desc ? 'is-danger':''"
                                            :message="this.errors.job_desc ? this.errors.job_desc[0] : ''">
                                            <quill-editor
                                                ref="myQuillEditor"
                                                v-model="fields.job_desc"
                                                :options="editorOption"
                                            />
                                        </b-field>
                                    </div>

                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Minimum Experience"
                                            :type="this.errors.minimum_experience ? 'is-danger':''"
                                            :message="this.errors.minimum_experience ? this.errors.minimum_experience[0] : ''">
                                            <b-select v-model="fields.minimum_experience" expanded>
                                                <option value="Below 1 Year">Below 1 Year</option>
                                                <option value="1 - 3 Years">1 - 3 Years</option>
                                                <option value="3 - 5 Years">3 - 5 Years</option>
                                                <option value="5 - 10 Years">5 - 10 Years</option>
                                                <option value="Above 10 Years">Above 10 Years</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Minimum Qualification"
                                            :type="this.errors.minimum_qualification ? 'is-danger':''"
                                            :message="this.errors.minimum_qualification ? this.errors.minimum_qualification[0] : ''">
                                            <b-select v-model="fields.minimum_qualification">
                                                <option v-for="(item, index) in qualifications" :key="index" :value="item.qualification">{{ item.qualification }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Category" expanded
                                            :type="this.errors.category ? 'is-danger':''"
                                            :message="this.errors.category ? this.errors.category[0] : ''">
                                            <b-select v-model="fields.category" expanded placeholder="Category">
                                                <option v-for="(item, index) in categories" :key="index" :value="item.category_id">{{ item.category }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Job Type" expanded
                                            :type="this.errors.job_type ? 'is-danger':''"
                                            :message="this.errors.job_type ? this.errors.job_type[0] : ''">
                                            <b-select v-model="fields.job_type" expanded placeholder="Job Type">
                                                <option v-for="(item, index) in jobTypes" :key="index" :value="item.jobtype_id">{{ item.jobtype }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div> <!--cols-->

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Salary (PESO)">
                                            <b-numberinput v-model="fields.from_salary"
                                                placeholder="From" :controls="false"></b-numberinput>
                                            <b-numberinput v-model="fields.to_salary"
                                                placeholder="To" :controls="false"></b-numberinput>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Skill(s)">
                                            <b-taginput
                                                v-model="fields.skills"
                                                :data="filteredTags"
                                                autocomplete
                                                field="skill"
                                                icon="label"
                                                placeholder="Add a skill"
                                                @typing="getFilteredTagSkills">
                                                <template v-slot="props">
                                                    {{props.option.skill}}
                                                </template>
                                                <template #empty>
                                                    There are no items
                                                </template>
                                            </b-taginput>
                                        </b-field>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="buttons is-right mt-5">
                                <button class="button is-primary">
                                    POSTS
                                    &nbsp;
                                    &nbsp;
                                    <b-icon icon="content-save-outline"></b-icon>
                                </button>
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
                            <div class="has-text-weight-bold">{{ item.title }}</div>
                            <div class="box-post-heading-item-left">
                                <b-dropdown aria-role="list">
                                    <template #trigger="{ active }">
<!--                                        <b-button-->
<!--                                            label="Option"-->
<!--                                            class="is-small"-->
<!--                                            type="is-primary"-->
<!--                                            :icon-right="active ? 'menu-up' : 'menu-down'" />-->
                                        <div class="dots">...</div>
                                    </template>

                                    <b-dropdown-item aria-role="listitem" @click="modalUpdate(item.job_post_id)">Update</b-dropdown-item>
                                    <b-dropdown-item aria-role="listitem" @click="confirmDelete(item.job_post_id)">Delete</b-dropdown-item>
                                </b-dropdown>
                            </div>
                        </div>
                        <div class="box-time">
                            {{ item.created_at | formatDateTime }}
                        </div>
                        <hr>
                        <div class="w-tag-container">
                            <div class="tag-category">
                                {{ item.category.category }}
                            </div>
                            <div class="tag-jobtype">
                                {{ item.jobtype.jobtype }}
                            </div>
                        </div>
                        <div class="box-post-body content" v-html="item.job_desc">
                        </div>
                        <hr>
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
            </div> <!-- col centered -->
        </div><!--section-->


        <b-modal v-model="isModalActive" has-modal-card
                 trap-focus scroll="keep" aria-role="dialog" aria-modal>
            <div class="modal-card card-width">
                <header class="modal-card-head">
                    <p class="modal-card-title">JOB POST INFORMATION</p>
                    <button type="button" class="delete"
                            @click="isModalActive = false"/>
                </header>

                <section class="modal-card-body">
                    <div>
                        <div class="mt-5">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="TITLE">
                                        <b-input type="text" v-model="modalFields.title" placeholder="Title"></b-input>
                                    </b-field>
                                </div>
                            </div>
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Job Description"
                                        :type="this.errors.job_desc ? 'is-danger':''"
                                        :message="this.errors.job_desc ? this.errors.job_desc[0] : ''">
                                        <quill-editor
                                            ref="myQuillEditor"
                                            v-model="modalFields.job_desc"
                                            :options="editorOption"
                                        />
                                        </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                    <div class="column">
                                        <b-field label="Minimum Experience"
                                            :type="this.errors.minimum_experience ? 'is-danger':''"
                                            :message="this.errors.minimum_experience ? this.errors.minimum_experience[0] : ''">
                                            <b-select v-model="modalFields.minimum_experience" expanded>
                                                <option value="Below 1 Year">Below 1 Year</option>
                                                <option value="1 - 3 Years">1 - 3 Years</option>
                                                <option value="3 - 5 Years">3 - 5 Years</option>
                                                <option value="5 - 10 Years">5 - 10 Years</option>
                                                <option value="Above 10 Years">Above 10 Years</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Minimum Qualification"
                                            :type="this.errors.minimum_qualification ? 'is-danger':''"
                                            :message="this.errors.minimum_qualification ? this.errors.minimum_qualification[0] : ''">
                                            <b-select v-model="modalFields.minimum_qualification">
                                                <option v-for="(item, index) in qualifications" :key="index" :value="item.qualification">{{ item.qualification }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Category" expanded>
                                        <b-select v-model="modalFields.category_id" expanded placeholder="Category">
                                            <option v-for="(item, index) in categories" :key="index" :value="item.category_id">{{ item.category }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                                <div class="column">
                                    <b-field label="Job Type" expanded>
                                        <b-select v-model="modalFields.jobtype_id" expanded placeholder="Job Type">
                                            <option v-for="(item, index) in jobTypes" :key="index" :value="item.jobtype_id">{{ item.jobtype }}</option>
                                        </b-select>
                                    </b-field>
                                </div>
                            </div> <!--cols-->

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Salary (PESO)">
                                        <b-numberinput v-model="modalFields.from_salary"
                                            placeholder="From" :controls="false"></b-numberinput>
                                        <b-numberinput v-model="modalFields.to_salary"
                                            placeholder="To" :controls="false"></b-numberinput>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Skill(s)">
                                        <b-taginput
                                            v-model="modalFields.skills"
                                            :data="filteredTags"
                                            autocomplete
                                            field="skill"
                                            @remove="removeLedaTag"
                                            :open-on-focus="true"
                                            icon="label"
                                            type="is-warning"
                                            placeholder="Add a skill"
                                            @typing="getFilteredTagSkills">
                                            <template v-slot="props">
                                                {{props.option.skill}}
                                            </template>
                                            <template #empty>
                                                There are no items
                                            </template>
                                        </b-taginput>
                                    </b-field>
                                </div>
                            </div>


                        </div>

                    </div>
                </section>

                <footer class="modal-card-foot">
                    <b-button
                        label="Close"
                        @click="isModalActive=false"></b-button>
                    <b-button
                        type="is-primary"
                        label="Update"
                        icon-right="content-save-outline"
                        @click="update"></b-button>
                </footer>
            </div>
        </b-modal>


    </div>
</template>

<script>

export default {
    props: ['propCompanyId', 'propJobTypes', 'propCategories', 'propQualifications'],

    data() {
        return {
            categories: [],
            jobTypes: [],

            fields: {},
            modalFields: {
                job_post_id: 0,
                title: '',
                job_desc: '',
                minimum_experience: '',
                minimum_qualification: '',
                category_id: 0,
                jobtype_id: 0,
                from_salary: 0,
                to_salary: 0
            },
            errors: {},

            companyId: null,

            jobPosts: [],
            qualifications: [],

            isModalActive: false,


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

            editorOption: {
                // Some Quill options...
            },

            dataSkills: [],
            filteredTags: [],

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
            axios.get(`/employer/get-job-posts?${params}`)
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
                        message: 'Job post successfully',
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
                message: 'Are you sure you want to delete this post? This action cannot be undone.',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/employer/company-job-post-delete/' + delete_id).then(res => {
                this.loadJobPosts();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        initData(){
            this.jobTypes = this.propJobTypes;
            this.categories = this.propCategories;
            this.qualifications = JSON.parse(this.propQualifications);

            console.log(this.propCompanyId);
            this.companyId = this.propCompanyId;
            this.fields.company_id = this.companyId;
        },

        modalUpdate(jobPostId){
            this.isModalActive = true;
            this.getData(jobPostId)
        },

        getData: function(jobPostId){
            axios.get('/employer/get-job-post/' + jobPostId).then(res=>{
                //this.modalFields = res.data
                this.modalFields.job_post_id = res.data.job_post_id;
                this.modalFields.title = res.data.title;
                this.modalFields.job_desc = res.data.job_desc;
                this.modalFields.minimum_experience = res.data.minimum_experience;
                this.modalFields.minimum_qualification = res.data.minimum_qualification;
                this.modalFields.category_id = res.data.category_id;
                this.modalFields.jobtype_id = res.data.jobtype_id;
                this.modalFields.from_salary = parseFloat(res.data.from_salary);
                this.modalFields.to_salary = parseFloat(res.data.to_salary);

                let a = [];
                res.data.skills.forEach(element => {
                    a.push({
                        'job_post_id': element.job_post_id,
                        'skill': element.job_post_skill
                    })
                });
                this.modalFields.skills = a

            })
        },

        update: function(){
            axios.put('/employer/company-job-update/' + this.modalFields.job_post_id, this.modalFields).then(res=>{
                if(res.data.status === 'updated'){
                    this.$buefy.dialog.alert({
                        title: "SAVED!",
                        message: 'Job post updated successfully.',
                        type: 'is-success',
                        onConfirm: ()=>  {
                            //window.location = '/employer/company-job-post/' +this.companyId
                            this.loadJobPosts()
                            this.isModalActive = false
                            this.modalFields = {}
                        }
                    });
                }
            })
        },


        /* QUILL METHODS*/
        onEditorBlur(quill) {
            console.log('editor blur!', quill)
        },
        onEditorFocus(quill) {
            console.log('editor focus!', quill)
        },
        onEditorReady(quill) {
            console.log('editor ready!', quill)
        },
        onEditorChange({ quill, html, text }) {
            console.log('editor change!', quill, html, text)
            this.content = html
        },
        /* QUILL METHODS*/


        loadSkills: function(){
            axios.get('/get-open-skills').then(res=>{
                this.dataSkills = res.data;
            })
        },
        getFilteredTagSkills(text) {
            this.filteredTags = this.dataSkills.filter((option) => {
                return option.skill
                    .toString()
                    .toLowerCase()
                    .indexOf(text.toLowerCase()) >= 0
            })
        },
        removeLedaTag: function(data){
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this skill? This action cannot be undone.',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => {
                    axios.delete('/employer/job-post-skill-delete/' + data.skill + '/' + data.job_post_id).then(res=>{
                        this.$buefy.toast.open({
                            message: 'Skill deleted successfully,',
                            type: 'is-success'
                        })
                    })
                }
            });

        }

    },

    mounted(){
        this.initData();
        this.loadJobPosts();
        this.loadCompanies();
        this.loadSkills();
    },

    computed: {
        editor() {
            return this.$refs.myQuillEditor.quill
        }
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
        margin: 10px 10px 0 15px;
        display: flex;
    }
    .box-time{
        margin: 10px 0 0 15px;
        color: gray;
        font-size: .8em;
    }

    .box-post-heading-item-left{
        margin-left: auto;
    }

    .box-post-body{
        padding: 15px;
    }

    .box-post-footer{
        padding: 15px;
        display: flex;
        justify-content: space-evenly;
    }

    .dots{
        font-weight: bold;
        font-size: 1.8em;
        cursor: pointer;
    }
</style>
