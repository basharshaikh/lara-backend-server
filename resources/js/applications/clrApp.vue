<template>
    <div class="relative" id="codeloverColorPicker">
        <div 
            :style="`background-color: ${hexCode}`"
            class="inline-block px-3 text-sm py-2 h-[39px] border text-white rounded-sm mb-3 cursor-pointer " 
            @click="togglePicker"
        >{{hexCode}}</div>

        <ColorPicker
        v-if="ShowPicker" 
        style="width: 220px;"
        class="absolute"
        @changeColor="changeColor"
        >
            <div class="flex justify-between">
                <Button class="mt-3" text="Close" BGcolor="red" @click="hidePicker"/>
                <Button class="mt-3" text="Insert" @click="insertTheColor"/>
            </div>
        </ColorPicker>

    </div>
    <div v-if="ShowPicker"  @click="hidePicker" class="fixed w-[100%] h-[100%] bg-[#333] top-0 left-0 bg-opacity-50 z-99999"></div>
</template>

<script setup>
import { ColorPicker } from 'vue-color-kit'
import 'vue-color-kit/dist/vue-color-kit.css'
import Button from './Button.vue'
import {ref} from 'vue'

const ShowPicker = ref(false)

const emit = defineEmits(["changeColor"])
const props = defineProps({
    index: Number,
    hexCode: {
        type: String,
        default: '#333'
    }
})

function togglePicker(){
    if(ShowPicker.value == false){
        ShowPicker.value = true
    } else {
        ShowPicker.value = false
    }
}

// On Change color
function changeColor(color){
    props.hexCode = color.hex
    emit("changeColor", {
        hexCode: color.hex,
        index: props.index
    })
}

// Insert the color 
function insertTheColor(){
    // hexCode
    ShowPicker.value = false
}

function hidePicker(){
    ShowPicker.value = false
}

</script>