<template>
    <div>
        <div class="relative pb-4">
            <label :for="name" class="uppercase text-xs font-bold text-blue-500 absolute pt-2"> {{ label }} </label>
            <input :id="name" type="text" class="pt-8 w-full border-b pb-2 border-gray-400 focus:outline-none focus:border-blue-400 text-gray-900 " :class="errorClassObject()" :placeholder="placeholder" v-model="value" @input="updateField()" >
            
            <p class="text-red-600 text-sm" v-text="errorMessage()">Error Here</p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "InputField",
        props: [
            'name', 'label', 'placeholder', 'errors', 'data',
        ],
        data:function() {
            return {
                value:''
            }
        },
         computed:{
            hasError:function(){
                return this.errors && this.errors[this.name] && this.errors[this.name].length >0;
            }
        },
        methods:{
            updateField: function(){
                this.clearErrors(this.name);
                this.$emit('update:field', this.value);
            },

            errorMessage: function (){
                if(this.hasError){
                    return this.errors[this.name][0];
                }
            },

            clearErrors: function(){
                if(this.hasError){
                   return this.errors[this.name] = null;
                }
            },

            errorClassObject: function(){
                return {
                    'error-field':this.hasError
                }
            }
        },
        watch:{
            data: function(val){
                this.value = val;
            }
        }

    }
</script>

<style>
.error-field{
    @apply
    .border-red-500
    .border-b-2
}
</style>