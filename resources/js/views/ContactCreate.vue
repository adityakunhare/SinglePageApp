    
<template>
  <div>
      <form @submit.prevent="submitForm">
          <InputField name="name" label="Contact Name" placeholder="Contacts Name"  @update:field="form.name = $event" :errors ="errors" />
          <InputField name="email" label="Contact Email" placeholder="Contacts Email"  @update:field="form.email= $event" :errors ="errors" />
          <InputField name="company" label="Company" placeholder="Company"  @update:field="form.company= $event" :errors ="errors" />
          <InputField name="birthday" label="Birthday" placeholder="MM/DD/YYYY"  @update:field="form.birthday= $event" :errors ="errors" />


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
   
    methods:{
        submitForm: function(){
            axios.post('/api/contacts',this.form)
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