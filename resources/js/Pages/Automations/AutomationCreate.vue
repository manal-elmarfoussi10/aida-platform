<template>
  <div class="automation-create">
    <h2>Create a New Automation</h2>

    <!-- Formulaire -->
    <div class="form-section">
      <input v-model="name" placeholder="Automation Name" class="input" />

      <AutomationSelector
        v-model:site="selectedSite"
        v-model:building="selectedBuilding"
        v-model:floor="selectedFloor"
        v-model:zone="selectedZone"
      />

      <button class="add-node" @click.prevent="addNode">+ Add Node</button>
    </div>

    <!-- Graph Editor -->
    <div class="editor-section">
      <VueFlow
        v-model:nodes="nodes"
        v-model:edges="edges"
        :fit-view="true"
        class="flow-editor"
      >
        <template #node-custom="props">
          <CustomNode :data="props.data" />
        </template>
      </VueFlow>
    </div>

    <!-- Bouton Sauvegarder -->
    <button class="save-btn" @click="saveAutomation">Save Automation</button>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { VueFlow } from '@braks/vue-flow'
import CustomNode from './CustomNode.vue'
import AutomationSelector from './AutomationSelector.vue'

const name = ref('')
const selectedSite = ref(null)
const selectedBuilding = ref(null)
const selectedFloor = ref(null)
const selectedZone = ref(null)

const nodes = ref([])
const edges = ref([])

const addNode = () => {
  const newId = String(Date.now())
  nodes.value.push({
    id: newId,
    type: 'custom',
    data: { type: 'trigger', label: 'New Node' },
    position: { x: 100, y: 100 }
  })
}

const saveAutomation = async () => {
  try {
    await axios.post('/api/automations', {
      name: name.value,
      zone_id: selectedZone.value,
      nodes: nodes.value,
      edges: edges.value
    })
    alert('Automation saved successfully!')
  } catch (err) {
    console.error('Save failed:', err)
    alert('Error saving automation')
  }
}
</script>

<style scoped>
.automation-create {
  padding: 20px;
  background: #0f172a;
  color: white;
}

.form-section {
  margin-bottom: 20px;
}

.input {
  padding: 8px;
  margin-right: 10px;
  border-radius: 6px;
  border: 1px solid #ccc;
}

.add-node {
  background: #3b82f6;
  color: white;
  padding: 8px 12px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.editor-section {
  height: 500px;
  background-color: #1e293b;
  border-radius: 8px;
  margin-bottom: 20px;
}

.flow-editor {
  height: 100%;
}

.save-btn {
  background: #22c55e;
  color: white;
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
}
</style>
