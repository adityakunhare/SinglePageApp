<template>
    <div>
        <div v-if="loading">
          Loading...
        </div>
        <div v-else>
            <div class="flex justify-between">
                <a href= "#" @click="$router.back()" class= "text-blue-400">
                    < Back
                </a>
                <div class="relative">
                    <router-link :to="contact.contact_id + '/edit'" class="px-4 py-2 rounded text-sm mr-2 font-bold text-green-500 border border-green-500">Edit</router-link>
                    <a href="#" class="px-4 py-2 border border-red-500 rounded text-sm font-bold text-red-500" @click="modal= ! modal">Delete</a>
                    
                    <div v-if="modal" class="absolute bg-blue-900 text-white rounded-lg z-20 p-8 w-64 right-0 mt-2 mr-6">
                        Are you sure you want to delete this record?

                        <div class="flex items-center mt-6 justify-end">
                            <button class="text-white pr-4" @click="modal= ! modal" >Cancel</button>
                            <button class=" px-4 py-2 bg-red-500 rounded text-sm font-bold text-white" @click="destroy" >Delete</button>
                        </div>
                    </div>
                </div>
                    <div @click="modal= ! modal" class="bg-black opacity-25 absolute right-0 left-0 top-0 bottom-0 z-10" v-if="modal"></div>
            </div>
            <div class="flex items-center pt-6">
                <UserCircle :name="contact.name"/>
                <p class="pl-5 text-xl"> {{ contact.name }} </p>
            </div>

            <p class="uppercase pt-6 font-bold text-gray-500 text-sm">Contact</p>
            <p class="pt-2 text-blue-400" > {{ contact.email }} </p>

            <p class="uppercase pt-6 font-bold text-gray-500 text-sm">Company</p>
            <p class="pt-2 text-blue-400" > {{ contact.company }} </p>

            <p class="uppercase pt-6 font-bold text-gray-500 text-sm" >Birthday</p>
            <p class="pt-2 text-blue-400" > {{ contact.birthday }} </p>

        </div>

    </div>
</template>

<script>
import UserCircle from '../components/UserCircle';

export default {
    name: "ContactShow",
    components:{
        UserCircle
    },
    data: function(){
        return {
            loading: true,
            modal: false,
            contact: null,
        }
    },
    methods:{
        destroy: function(){
            axios.delete('/api/contacts/' + this.$route.params.id)
                .then(response=>{
                    this.$router.push('/contacts');
                })
                .catch(error =>{
                    alert('Internal Error. Unable to delete the record!');
                });
        }
    },

    mounted(){
        axios.get('/api/contacts/' + this.$route.params.id)
            .then(response => {
                this.contact = response.data.data;
                this.loading = false;
            })
            .catch(error=>{
                this.loading = false; 
                if(error.response.status === 404){
                    this.$router.push('/contacts');
                }
            });
    },
}
</script>

<style>

</style>