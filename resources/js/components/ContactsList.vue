<template>
     <div>
        <div v-if="loading">
            <!-- Loading... -->
             <img class="m-auto pt-12" src="/storage/images/loading.gif">
            </div>
        <div v-else>
            <div v-if="contacts.length ===0">
                    <p>No Contacts Yet <router-link to="/contacts/create">Get Started</router-link></p>
            </div>

            <div v-for="contact in contacts">
              <router-link :to="'/contacts/' +contact.data.contact_id" class="flex items-center border-b border-gray-400 p-4 hover:bg-gray-100">
                <UserCircle :name="contact.data.name"/>
                <div class="pl-4">
                    <p class="text-blue-400">{{ contact.data.name }}</p>
                    <p class="text-gray-600">{{ contact.data.company }}</p>
                </div>
              </router-link>
            </div>
        </div>

    </div>
</template>

<script>
import UserCircle from './UserCircle';
export default {
    name: "ContactsList",
    
    components:{
        UserCircle,
    },
    props:[
        'endpoint'
    ],
      mounted(){
        axios.get(this.endpoint)
            .then(response=>{
                this.contacts = response.data.data;
                this.loading = false;
            })
            .catch(error =>{
                this.loading = false;
                alert('Unable to fetch contacts');
            });
    },
    data: function(){
        return {
            loading:true,
            contacts: null,
        }
    }

    
}
</script>

<style>

</style>