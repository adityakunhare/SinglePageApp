<template>
    <div>
        <div v-if="focus" @click="focus=false" class=" absolute bg-black opacity-25 right-0 left-0 top-0 bottom-0 z-10" >

        </div>
        <div class="relative z-10">
            <div class="absolute ">
            <svg viewBox="0 0 24 24" class="w-5 h-5 mt-2 ml-2">
                <path fill-rule="evenodd" d="M20.2 18.1l-1.4 1.3-5.5-5.2 1.4-1.3 5.5 5.2zM7.5 12c-2.7 0-4.9-2.1-4.9-4.6s2.2-4.6 4.9-4.6 4.9 2.1 4.9 4.6S10.2 12 7.5 12zM7.5.8C3.7.8.7 3.7.7 7.3s3.1 6.5 6.8 6.5c3.8 0 6.8-2.9 6.8-6.5S11.3.8 7.5.8z" clip-rule="evenodd"/>
            </svg>
        </div>
        <input type="text" @focus="focus=true" class="w-64 mr-6 bg-gray-200 border border-gray-400 pl-8 pr-3 py-1 rounded-full text-sm focus:outline-none focus:border-blue-500 focus:shadow focus:bg-gray-100" placeholder="Search here..." id="searchTerm" v-model="searchTerm" @input="search">
            
       <transition name="bounce"  >
            <div v-if="focus" class=" absolute  bg-blue-900 text-white rounded-lg p-4 w-96 right-0 mr-6 mt-2 shadow z-20">
                <div v-if="results == 0">No results found for '{{ searchTerm }}'</div>
                <div v-for="result in results"    @click="focus=false" >
                    <router-link :to="result.links.self" class="py-2 block hover:bg-blue-500">
                        <div class="flex items-center">
                            <UserCircle :name="result.data.name" />
                            <div class="pl-3">
                                <p> {{ result.data.name }} </p>
                                <p> {{ result.data.company }} </p>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
       </transition>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';
import UserCircle from '../components/UserCircle';
export default {
    name: "SearchBar",
    data: function(){
        return{
            searchTerm: '',
            focus: false,
            results:[],
        }
    },
    components:{
        UserCircle,
    },
    methods:{
        search:_.debounce(function(e){
          if(this.searchTerm.length < 3){
              return;
          }
            axios.post('/api/search',{ searchTerm: this.searchTerm })
                .then(response => {
                    this.results = response.data.data;
                })
                .catch(error=>{
                    console.log(error.response);
                })
        },500),
    }
}
</script>

<style scoped>
.bounce-enter-active {
  animation: bounce-in .5s;
}
.bounce-leave-active {
  animation: bounce-in .5s reverse;
}
@keyframes bounce-in {
  0% {
    transform: scale(0);
  }
  50% {
    transform: scale(1);
  }
  /* 100% {
    transform: scale(1);
  } */
}
</style>

</style>