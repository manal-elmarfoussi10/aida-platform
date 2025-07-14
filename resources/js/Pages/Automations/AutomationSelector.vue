<template>
  <div class="automation-selector">
    <div class="selectors">
      <select v-model="selectedSite" @change="fetchBuildings">
        <option disabled value="">Select Site</option>
        <option v-for="site in sites" :key="site.id" :value="site.id">{{ site.name }}</option>
      </select>

      <select v-model="selectedBuilding" @change="fetchFloors" :disabled="!selectedSite">
        <option disabled value="">Select Building</option>
        <option v-for="building in buildings" :key="building.id" :value="building.id">{{ building.name }}</option>
      </select>

      <select v-model="selectedFloor" @change="fetchZones" :disabled="!selectedBuilding">
        <option disabled value="">Select Floor</option>
        <option v-for="floor in floors" :key="floor.id" :value="floor.id">{{ floor.name }}</option>
      </select>

      <select v-model="selectedZone" @change="fetchAutomation" :disabled="!selectedFloor">
        <option disabled value="">Select Zone</option>
        <option v-for="zone in zones" :key="zone.id" :value="zone.id">{{ zone.name }}</option>
      </select>

      <button class="create-button" @click="goToCreateAutomation" :disabled="!selectedZone">
        ➕ Create New Automation
      </button>
    </div>

    <FlowEditor v-if="automationId" :automationId="automationId" />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import FlowEditor from './FlowEditor.vue'

const router = useRouter()

const sites = ref([])
const buildings = ref([])
const floors = ref([])
const zones = ref([])

const selectedSite = ref('')
const selectedBuilding = ref('')
const selectedFloor = ref('')
const selectedZone = ref('')

const automationId = ref(null)

const fetchSites = async () => {
  const { data } = await axios.get('/api/sites')
  sites.value = data
}

const fetchBuildings = async () => {
  const { data } = await axios.get(`/api/buildings?site_id=${selectedSite.value}`)
  buildings.value = data
  floors.value = []
  zones.value = []
  automationId.value = null
}

const fetchFloors = async () => {
  const { data } = await axios.get(`/api/floors?building_id=${selectedBuilding.value}`)
  floors.value = data
  zones.value = []
  automationId.value = null
}

const fetchZones = async () => {
  const { data } = await axios.get(`/api/zones?floor_id=${selectedFloor.value}`)
  zones.value = data
  automationId.value = null
}

const fetchAutomation = async () => {
  const { data } = await axios.get(`/api/automations/by-zone/${selectedZone.value}`)
  automationId.value = data?.id || null
}

const goToCreateAutomation = () => {
  router.push({ name: 'AutomationCreate', query: { zone: selectedZone.value } })
}

fetchSites()
</script>

<style scoped>
.automation-selector {
  display: flex;
  flex-direction: column;
  gap: 16px;
  padding: 16px;
}

.selectors {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
  align-items: center;
}

select {
  padding: 8px;
  border-radius: 6px;
  background: #1e293b;
  color: white;
  border: 1px solid #334155;
}

.create-button {
  background-color: #22c55e;
  color: white;
  padding: 8px 12px;
  border-radius: 6px;
  font-weight: bold;
  border: none;
  cursor: pointer;
}
</style>
