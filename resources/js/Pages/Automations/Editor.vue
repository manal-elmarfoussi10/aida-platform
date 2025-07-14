<template>
  <div class="p-6 text-white">
    <h2 class="text-2xl font-bold mb-4">Automation Logic</h2>

    <!-- Filtres : Site, Bâtiment, Étage, Zone -->
    <div class="flex flex-wrap gap-2 mb-4">
      <select class="bg-gray-800 text-white p-2 rounded" v-model="selectedSite">
        <option disabled value="">Site</option>
        <option>Cisco Atlanta</option>
        <option>MHT New York City</option>
      </select>

      <select class="bg-gray-800 text-white p-2 rounded" v-model="selectedBuilding">
        <option disabled value="">Building</option>
        <option>Cisco Atlanta Campus</option>
        <option>Main Tower</option>
      </select>

      <select class="bg-gray-800 text-white p-2 rounded" v-model="selectedFloor">
        <option disabled value="">Floor</option>
        <option>Ground Floor</option>
      </select>

      <select class="bg-gray-800 text-white p-2 rounded" v-model="selectedZoneId" @change="loadAutomations">
        <option disabled value="">Zone</option>
        <option v-for="zone in zones" :key="zone.id" :value="zone.id">
          {{ zone.name }}
        </option>
      </select>
    </div>

    <!-- Liste des automatisations -->
    <div v-if="automations.length" class="space-y-4 mb-6">
      <div
        v-for="automation in automations"
        :key="automation.id"
        @click="selectAutomation(automation)"
        class="bg-slate-800 rounded-lg p-4 cursor-pointer hover:ring-2 ring-green-400"
      >
        <div class="font-semibold text-lg mb-2">⚙️ Test: {{ automation.name }}</div>
        <div class="space-y-1 text-sm">
          <div v-if="automation.trigger" class="text-green-400">🔔 Trigger: {{ automation.trigger }}</div>
          <div v-if="automation.condition" class="text-yellow-300">🧠 Condition: {{ automation.condition }}</div>
          <div v-if="automation.action" class="text-blue-400">💡 Action: {{ automation.action }}</div>
        </div>
      </div>
    </div>

    <!-- Composant FlowEditor.vue -->
    <div v-if="selectedAutomation" class="mt-8">
      <h3 class="text-xl font-semibold mb-2">
        Graph: {{ selectedAutomation.name }}
      </h3>
      <FlowEditor :automationId="selectedAutomation.id" />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import FlowEditor from './FlowEditor.vue'

const selectedSite = ref('')
const selectedBuilding = ref('')
const selectedFloor = ref('')
const selectedZoneId = ref(null)

const zones = ref([])
const automations = ref([])
const selectedAutomation = ref(null)

const loadZones = async () => {
  const res = await axios.get('/api/zones')
  zones.value = res.data.zones || []
}

const loadAutomations = async () => {
  selectedAutomation.value = null
  if (!selectedZoneId.value) return

  const res = await axios.get(`/api/automations?zone=${selectedZoneId.value}`)
  automations.value = res.data.automations || []
}

const selectAutomation = (automation) => {
  selectedAutomation.value = automation
}

onMounted(loadZones)
</script>
