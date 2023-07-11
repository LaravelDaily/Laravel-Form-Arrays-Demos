<script setup>

import {ref} from "vue";

const props = defineProps({
  users: {
    required: true,
  },
  selectedUsers: {
    required: false
  },
  errorBag: {
    required: false,
    default: () => {
      return {}
    }
  }
})

const positions = {
  'Goalkeeper': 'Goalkeeper',
  'Defender': 'Defender',
  'Midfielder': 'Midfielder',
  'Forward': 'Forward',
  'Coach': 'Coach',
  'Assistant Coach': 'Assistant Coach',
  'Physiotherapist': 'Physiotherapist',
  'Doctor': 'Doctor',
  'Manager': 'Manager',
  'President': 'President',
}

const players = ref([])

// Setting players from validation bag
if (props.selectedUsers.length > 0) {
  props.selectedUsers.forEach((user) => {
    players.value.push({
      id: user.id ?? "",
      position: user.position ?? "",
    })
  })
}

const addUser = () => {
  players.value.push({
    id: "",
    position: "",
  })
}

const removeUser = (index) => {
  players.value.splice(index, 1)
}
</script>

<template>
  <div>
    <div v-for="(user, index) in players" class="mb-4 grid grid-cols-3 gap-4">
      <div>
        <label class="text-xl text-gray-600" :for="'players['+index+'][id]'">Position<span
            class="text-red-500">*</span></label>
        <select :name="'players['+index+'][id]'" :id="'players['+index+'][id]'"
                v-model="user.id"
                class="border-2 border-gray-300 p-2 w-full">
          <option value="">Select Player</option>
          <option v-for="(name, id) in props.users" :value="id">{{ name }}</option>
        </select>
        <div class="text-red-500 mt-2 text-sm mb-4" v-if="errorBag['players.'+index+'.id']">
          {{ errorBag['players.'+index+'.id'][0] }}
        </div>
      </div>
      <div>
        <label class="text-xl text-gray-600" :for="'players['+index+'][position]'">Position<span
            class="text-red-500">*</span></label>
        <select :name="'players['+index+'][position]'" :id="'players['+index+'][position]'"
                v-model="user.position"
                class="border-2 border-gray-300 p-2 w-full">
          <option value="">Select Position</option>
          <option v-for="(position, key) in positions" :value="key">{{ position }}</option>
        </select>
        <div class="text-red-500 mt-2 text-sm mb-4" v-if="errorBag['players.'+index+'.position']">
          {{ errorBag['players.'+index+'.position'][0] }}
        </div>
      </div>
      <div>
        <button @click="removeUser(index)"
                type="button"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mt-8">
          Remove
        </button>
      </div>
    </div>
    <div class="text-red-500 mt-2 text-sm mb-4" v-if="errorBag.players">
      {{ errorBag.players[0] }}
    </div>
    <button @click="addUser"
            type="button"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
      Add Player
    </button>
  </div>
</template>