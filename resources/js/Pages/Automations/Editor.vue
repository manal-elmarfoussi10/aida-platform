<template>
  <div class="p-6 bg-black text-white min-h-screen">
    <h2 class="text-2xl font-bold mb-4">Automation Editor</h2>

    <div class="flex space-x-4 mb-4">
      <select v-model="selectedSite" @change="fetchBuildings" class="p-2 text-black rounded">
        <option disabled value="">Select Site</option>
        <option v-for="site in sites" :key="site.id" :value="site.id">{{ site.name }}</option>
      </select>

      <select v-model="selectedBuilding" @change="fetchFloors" class="p-2 text-black rounded" :disabled="!selectedSite">
        <option disabled value="">Select Building</option>
        <option v-for="b in buildings" :key="b.id" :value="b.id">{{ b.name }}</option>
      </select>

      <select v-model="selectedFloor" @change="fetchZones" class="p-2 text-black rounded" :disabled="!selectedBuilding">
        <option disabled value="">Select Floor</option>
        <option v-for="f in floors" :key="f.id" :value="f.id">{{ f.name }}</option>
      </select>

      <select v-model="selectedZone" class="p-2 text-black rounded" :disabled="!selectedFloor">
        <option disabled value="">Select Zone</option>
        <option v-for="z in zones" :key="z.id" :value="z.id">{{ z.name }}</option>
      </select>
    </div>

    <div class="border border-white p-4 rounded">
      <p>Ici on ajoutera Vue Flow ou autre interface graphique pour créer les règles.</p>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const sites = ref([])
const buildings = ref([])
const floors = ref([])
const zones = ref([])

const selectedSite = ref('')
const selectedBuilding = ref('')
const selectedFloor = ref('')
const selectedZone = ref('')

const fetchSites = async () => {
  try {
    const res = await axios.get('/api/sites')
    sites.value = res.data
  } catch (err) {
    console.error('Erreur lors de la récupération des sites:', err)
  }
}

const fetchBuildings = async () => {
  selectedBuilding.value = ''
  selectedFloor.value = ''
  selectedZone.value = ''
  buildings.value = []
  floors.value = []
  zones.value = []

  try {
    const res = await axios.get(`/api/buildings?site_id=${selectedSite.value}`)
    buildings.value = res.data
  } catch (err) {
    console.error('Erreur lors de la récupération des bâtiments:', err)
  }
}

const fetchFloors = async () => {
  selectedFloor.value = ''
  selectedZone.value = ''
  floors.value = []
  zones.value = []

  try {
    const res = await axios.get(`/api/floors?building_id=${selectedBuilding.value}`)
    floors.value = res.data
  } catch (err) {
    console.error('Erreur lors de la récupération des étages:', err)
  }
}

const fetchZones = async () => {
  selectedZone.value = ''
  zones.value = []

  try {
    const res = await axios.get(`/api/zones?floor_id=${selectedFloor.value}`)
    zones.value = res.data
  } catch (err) {
    console.error('Erreur lors de la récupération des zones:', err)
  }
}

onMounted(() => {
  fetchSites()
})
</script>
