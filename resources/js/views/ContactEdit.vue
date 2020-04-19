    
<template>
  <div>
      <div class="flex justify-between">
         <a href= "#" @click="$router.back()" class= "text-blue-400">
                    < Back
                </a>
      </div>
      <form @submit.prevent="submitForm">
          <InputField name="name" label="Contact Name" placeholder="Contacts Name"  @update:field="form.name = $event" :errors ="errors" :data="form.name" />
          <InputField name="email" label="Contact Email" placeholder="Contacts Email"  @update:field="form.email= $event" :errors ="errors" :data="form.email" />
          <InputField name="company" label="Company" placeholder="Company"  @update:field="form.company= $event" :errors ="errors" :data="form.company" />
          <InputField name="birthday" label="Birthday" placeholder="DD/MM/YYYY"  @update:field="form.birthday= $event" :errors ="errors" :data="form.birthday" />


          <div class="flex justify-end">
              <button class="py-2 px-4 border border-gray-400 text-red-700 hover:border-red-700 rounded mr-5">Cancel</button>
              <button  class="bg-blue-500 py-2 px-4 rounded text-white hover:bg-blue-400">Add New Contact</button>
          </div>
      </form>
  </div>
</template>

<script>
import InputField from '../components/InputField';
export default {
    name: "ContactCreate",
    components:{
        InputField
    },
    data:function(){
        return{
            form:{
                'name':'',
                'email':'',
                'company':'',
                'birthday':'',
            },
            errors: null
        }
        
    },
    mounted(){
          axios.get('/api/contacts/' + this.$route.params.id)
            .then(response => {
                this.form = response.data.data;
                this.loading = false;
            })
            .catch(error=>{
                this.loading = false; 
                if(error.response.status === 404){
                    this.$router.push('/contacts');
                }
            })
    },
   
    methods:{
        submitForm: function(){
            axios.patch('/api/contacts/'+ this.$route.params.id, this.form)
                .then(response=>{
                    this.$router.push(response.data.links.self);
                })
                .catch(errors=>{
                    this.errors = errors.response.data.errors;
                });
        }
    }
}
</script>

<style>

</style>