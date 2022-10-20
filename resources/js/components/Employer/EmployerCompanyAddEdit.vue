<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="box top-border-green">
                        <div class="form-section-title">
                            Company Information
                        </div>

                        <div>
                            <form @submit.prevent="submit">
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Company Name">
                                            <b-input type="text" placeholder="Company Name" v-model="fields.company_name"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Owner">
                                            <b-input type="text" placeholder="Owner" v-model="fields.owner"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Company Overview">
                                            <b-input type="textarea" placeholder="Company Overview" v-model="fields.overview"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Company Size">
                                            <b-numberinput placeholder="Company Size" v-model="fields.company_size" controls-alignment="right" controls-position="compact"></b-numberinput>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Benefits/Others">
                                            <b-input type="text" placeholder="Benefits/Others" v-model="fields.benefits_others"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <hr>
                                <div>
                                    Contact Information
                                </div>
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Contact No.">
                                            <b-input type="text" placeholder="Contact No." v-model="fields.phone_contact"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="FB">
                                            <b-input type="text" placeholder="FB" v-model="fields.fb_contact"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Twitter">
                                            <b-input type="text" placeholder="Twitter" v-model="fields.twitter_contact"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Instagram">
                                            <b-input type="text" placeholder="Instagram" v-model="fields.insta_contact"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Viber">
                                            <b-input type="text" placeholder="Viber" v-model="fields.viber_contact"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="WhatsApp">
                                            <b-input type="text" placeholder="WhatsApp" v-model="fields.whatsapp_contact"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <hr>
                                <div>
                                    Address Information
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Province" label-position="on-border" expanded
                                                :type="this.errors.province ? 'is-danger':''"
                                                :message="this.errors.province ? this.errors.province[0] : ''">
                                            <b-select v-model="fields.province" @input="loadCity" expanded>
                                                <option v-for="(item, index) in provinces" :key="index" :value="item.provCode">{{ item.provDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>

                                    <div class="column">
                                        <b-field label="City" label-position="on-border" expanded
                                                :type="this.errors.city ? 'is-danger':''"
                                                :message="this.errors.city ? this.errors.city[0] : ''">
                                            <b-select v-model="fields.city" @input="loadBarangay" expanded>
                                                <option v-for="(item, index) in cities" :key="index" :value="item.citymunCode">{{ item.citymunDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Barangay" label-position="on-border" expanded
                                                :type="this.errors.barangay ? 'is-danger':''"
                                                :message="this.errors.barangay ? this.errors.barangay[0] : ''">
                                            <b-select v-model="fields.barangay" expanded>
                                                <option v-for="(item, index) in barangays" :key="index" :value="item.brgyCode">{{ item.brgyDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Street" label-position="on-border">
                                            <b-input v-model="fields.street"
                                                    placeholder="Street">
                                            </b-input>
                                        </b-field>
                                    </div>
                                </div>


                                <div class="buttons">
                                    <button class="button is-primary">SAVE COMPANY</button>
                                </div>

                            </form>
                        </div><!--div form-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    data() {
        return{
            fields: {
                company_size: 0
            },
            errors: {},

            //address variables
            provinces: [],
            cities: [],
            barangays: [],
            street: '',

        }
    },

    methods: {
        
        //handle addressess
        loadProvince: function(){
            axios.get('/load-provinces').then(res=>{
                this.provinces = res.data;
            })
        },

        loadCity: function(){
            axios.get('/load-cities?prov=' + this.fields.province).then(res=>{
                this.cities = res.data;
            })
        },

        loadBarangay: function(){
            axios.get('/load-barangays?prov=' + this.fields.province + '&city_code='+this.fields.city).then(res=>{
                this.barangays = res.data;
            })
        },


        submit: function(){
            axios.post('/employer/company-add-edit').then(res=>{

            }).catch(res=>{
                
            })
        }

    },

    mounted(){
        this.loadProvince();
    }
}
</script>


<style scoped>
    .form-section-title{

    }

</style>