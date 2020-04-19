<template>
  <div>
       <div class="rounded-full text-white border border-gray-400 bg-blue-400 flex justify-center h-10 w-10 items-center">
            {{ userCircle }}
        </div>
  </div>
</template>

<script>
export default {
    name: "UserCircle",

    props:
        [
            'name'
        ],
    computed:{
        userCircle: function(){
            return this.name.match(/[A-Z]/g).slice(0,2).join('');
        }
    }
}
</script>

<style>

</style>