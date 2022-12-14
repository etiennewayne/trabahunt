<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8-desktop is-10-tablet">
                    <div class="box">

                        <div class="buttons is-right">
                            <b-dropdown aria-role="list">
                                <template #trigger="{ active }">
                                    <b-button
                                        label="..."
                                        type=""
                                        :icon-right="active ? 'menu-up' : 'menu-down'" />
                                </template>


                                <b-dropdown-item aria-role="listitem">Change Password</b-dropdown-item>
                                <!-- <b-dropdown-item aria-role="listitem">Another action</b-dropdown-item>
                                <b-dropdown-item aria-role="listitem">Something else</b-dropdown-item> -->
                            </b-dropdown>
                        </div><!-- buttons-->
                        
                        <div class="columns">
                            <div class="column is-4">
                                <div class="image">
                                    <img class="avatar" :src="avatarSrc"/>
                                </div>

                                <b-upload v-model="fields.file" class="file-label" expanded>
                                    <a class="button is-primary is-fullwidth">
                                        <b-icon icon="upload"></b-icon>
                                        <span>Click to upload</span>
                                    </a>
                                </b-upload>
                                <div class="file-name" expanded v-if="fields.file">
                                    {{ fields.file.name }}
                                </div>

                                <!-- <div class="buttons">
                                    <b-button class="button is-success is-outlined is-fullwidth">Upload Avatar</b-button>
                                </div> -->
                            </div>

                            <div class="column">
                                <div class="profile-form">

                                    <div class="subtitle">Personal Information</div>
                                    
                                    <div class="columns">
                                        <div class="column">
                                            <b-field label="Last Name" label-position="on-border">
                                                <b-input type="text" v-model="fields.lname" placeholder="Last Name" />
                                            </b-field>
                                        </div>
                                    </div>
                                   <div class="columns">
                                        <div class="column">
                                            <b-field label="First Name" label-position="on-border">
                                                <b-input type="text" v-model="fields.fname" placeholder="First Name" />
                                            </b-field>
                                        </div>
                                   </div>
                                   <div class="columns">
                                        <div class="column">
                                            <b-field label="Middle Name" label-position="on-border">
                                                <b-input type="text" v-model="fields.mname" placeholder="Middle Name" />
                                            </b-field>
                                        </div>
                                   </div>

                                   <div class="columns">
                                        <div class="column">
                                            <b-field label="Suffix" label-position="on-border">
                                                <b-input type="text" v-model="fields.suffix" placeholder="Suffix" />
                                            </b-field>
                                        </div>
                                        <div class="column">
                                            <b-field label="Birthdate" label-position="on-border">
                                                <b-datepicker
                                                    placeholder="Type or select your birthdate..."
                                                    icon="calendar-today"
                                                    v-model="fields.bdate"
                                                    editable>
                                                </b-datepicker>
                                            </b-field>
                                        </div>
                                        <div class="column">
                                            <b-field label="Sex" label-position="on-border" expanded>
                                                <b-select v-model="fields.sex" placeholder="Sex" expanded>
                                                    <option value="MALE">MALE</option>
                                                    <option value="FEMALE">FEMALE</option>
                                                </b-select>
                                            </b-field>
                                        </div>
                                   </div>

                                   <div class="columns">
                                        <div class="column">
                                            <b-field label="Email" label-position="on-border">
                                                <b-input type="email" v-model="fields.email" placeholder="Email" />
                                            </b-field>
                                        </div>
                                        <div class="column">
                                            <b-field label="Contact No." label-position="on-border">
                                                <b-input type="text" v-model="fields.contact_no" placeholder="Contact No." />
                                            </b-field>
                                        </div>
                                   </div>

                                   <div class="subtitle">Address</div>

                                   <div class="columns">
                                        <div class="column">
                                            <b-field label="Province" expanded label-position="on-border"
                                                    :type="this.errors.province ? 'is-danger':''"
                                                    :message="this.errors.province ? this.errors.province[0] : ''">
                                                <b-select v-model="fields.province" expanded placeholder="Province" @input="loadCity">
                                                    <option v-for="(item, index) in provinces" :key="index" :value="item.provCode">{{ item.provDesc }}</option>
                                                </b-select>
                                            </b-field>
                                        </div>
                                        <div class="column">
                                            <b-field label="City/Municipality" expanded label-position="on-border"
                                                    :type="this.errors.city ? 'is-danger':''"
                                                    :message="this.errors.city ? this.errors.city[0] : ''">
                                                <b-select expanded v-model="fields.city" placeholder="City" @input="loadBarangay">
                                                    <option v-for="(item, index) in cities" :key="index" :value="item.citymunCode">{{ item.citymunDesc }}</option>
                                                </b-select>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="columns">
                                        <div class="column">
                                            <b-field label="Barangay" expanded
                                                    :type="this.errors.barangay ? 'is-danger':''" label-position="on-border"
                                                    :message="this.errors.barangay ? this.errors.barangay[0] : ''">
                                                <b-select v-model="fields.barangay" expanded placeholder="Barangay">
                                                    <option v-for="(item, index) in barangays" :key="index" :value="item.brgyCode">{{ item.brgyDesc }}</option>
                                                </b-select>
                                            </b-field>
                                        </div>
                                        <div class="column">
                                            <b-field label="House #. Street" label-position="on-border">
                                                <b-input type="text"></b-input>
                                            </b-field>
                                        </div>
                                    </div>

                                    <div class="butons">
                                        <button class="button is-success is-outlined is-fullwidth" @click="updateProfile">UPDATE PROFILE</button>
                                    </div>

                                </div><!--profile form -->
                                
                            </div><!--col-->
                        </div><!--cols-->
                    </div><!-- box-->
                </div><!--col-->
            </div> <!--cols---->
           
        </div><!--section-->
    </div>
</template>

<script>
export default {
    props: ['propUserId'],

    data() {
        return{
            id: 0,

            fields: {
                avatar: ''
            },
            errors: {},

            provinces: [],
            cities: [],
            barangays: [],
            categories: [],
        }
    },

    methods: {

        //ADDRESS
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
        //FOR CATEGORIES
        loadCategories: function(){
            axios.get('/get-open-categories').then(res=>{
                this.dataCategories = res.data;
            })
        },


        getData: function(){
                 //nested axios for getting the address 1 by 1 or request by request
               
            axios.get('/employee/get-user/'+ this.id).then(res=>{
             
                this.fields.bdate = new Date(res.data.bdate);
                //this.fields = res.data;
                this.fields.lname = res.data.lname;
                this.fields.fname = res.data.fname;
                this.fields.mname = res.data.mname;
                this.fields.suffix = res.data.suffix;
                this.fields.sex = res.data.sex;
                this.fields.email = res.data.email;
                this.fields.contact_no = res.data.contact_no;
                this.fields.avatar = res.data.avatar;

                
                this.fields.province = res.data.province.provCode;

                let tempData = res.data;
                //load city first
                axios.get('/load-cities?prov=' + this.fields.province).then(res=>{
                    //load barangay
                    this.cities = res.data;
                   
                    this.fields.city = tempData.city.citymunCode;

                    axios.get('/load-barangays?prov=' + this.fields.province + '&city_code='+this.fields.city).then(res=>{
                        this.barangays = res.data;
                        this.fields.barangay = tempData.barangay.brgyCode
                       
                    });
                });
            });
        },

        updateProfile(){

            let birthDate = new Date(this.fields.bdate);

            birthDate = birthDate.getFullYear() + '-'+ (birthDate.getMonth() + 1) + '-' + birthDate.getDate();

            let formData = new FormData();
            formData.append('lname', this.fields.lname);
            formData.append('fname', this.fields.fname);
            formData.append('mname', this.fields.mname);
            formData.append('suffix', this.fields.suffix);
            formData.append('bdate', birthDate);
            formData.append('sex', this.fields.sex);
            formData.append('email', this.fields.email);
            formData.append('contact_no', this.fields.contact_no);
            formData.append('province', this.fields.province);
            formData.append('city', this.fields.city);
            formData.append('barangay', this.fields.barangay);
            formData.append('street', this.fields.street);
            formData.append('file', this.fields.file);

            axios.post('/employee/profile-update/' + this.id, formData).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: 'UPDATED!',
                        message: 'Profile Successfully updated.',
                        type: 'is-success',
                        confirmText: 'OK',
                        onConfirm: () => {
                           window.location = '/employee/profile'
                        }
                    })
                }
            })

        },

        initData: function(){
            this.id = this.propUserId;

            this.getData();
        }
    },


    mounted(){
        this.loadProvince()
        this.initData();
        
    },

    computed:{
        avatarSrc(){
            if(this.fields.avatar){
                return '/storage/avatar/' + this.fields.avatar;
            }else{
                return '/';
            }
        }
    }
}
</script>

<style scoped>
    .profile-form{
        margin: 25px 5px;
    }
    .avatar{
        vertical-align: middle;
        width: 128px;
        height: 128px;
        border-radius: 50%;
        object-fit: cover;
        margin: 15px auto;
    }

    .image{
        border: 1px solid gray;
    }
</style>
