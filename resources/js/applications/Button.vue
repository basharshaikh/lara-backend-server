<template>
    <button 
    :type="type" 
    :style="`color: ${Tcolor}; background: ${BGcolor}`"
    class="py-2 px-4 rounded-sm border border-transparent text-sm font-medium transition">
        {{text}}
    </button>
</template>
<style scoped>
button:hover{
    opacity: .9;
}
button:focus{
    outline: v-bind(BGcolor) 2px solid;
    outline-offset: 3px;
}
</style>

<script setup>
const props = defineProps({
    type:{
        type: String,
        default: 'button'
    },
    text: {
        type: String,
        default: 'Enter'
    },
    BGcolor: {
        type: String,
        default: '#4F46E5'
    },
    Tcolor: {
        type: String,
        default: 'white'
    }
})
</script>

