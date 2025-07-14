<template>
  <div class="automation-create">
    <h2>Create a New Automation</h2>

    <!-- Error Message -->
    <div v-if="errorMessage" class="error-message">
      ⚠️ {{ errorMessage }}
    </div>

    <!-- Horizontal Form Row -->
    <div class="form-row">
      <input
        v-model="name"
        placeholder="Automation Name"
        class="input inline"
      />

      <AutomationSelector
        v-model:site="selectedSite"
        v-model:building="selectedBuilding"
        v-model:floor="selectedFloor"
        v-model:zone="selectedZone"
      />

      <button class="create-btn" @click.prevent="saveAutomation">
        + Create New Automation
      </button>
    </div>

    <!-- Add Node -->
    <button class="add-node" @click.prevent="addNode">+ Add Node</button>

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
const errorMessage = ref('')

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
  errorMessage.value = ''

  if (!name.value || !selectedZone.value) {
    errorMessage.value = 'Name and Zone are required.'
    return
  }

  try {
    await axios.post('/api/automations', {
      name: name.value,
      zonev2_id: selectedZone.value,
      nodes: nodes.value,
      edges: edges.value
    })
    alert('✅ Automation saved successfully!')
  } catch (err) {
    console.error('Save failed:', err)
    errorMessage.value = err.response?.data?.message || 'Error saving automation.'
  }
}
</script>

<style scoped>
.automation-create {
  padding: 24px;
  background: #0f172a;
  color: white;
}

h2 {
  font-size: 24px;
  color: #22c55e;
  margin-bottom: 16px;
}

.error-message {
  background-color: #b91c1c;
  color: white;
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 12px;
  font-weight: bold;
}

.form-row {
  display: flex;
  flex-wrap: wrap;
  gap: 12px;
  align-items: center;
  margin-bottom: 16px;
}

.input.inline {
  padding: 10px;
  background-color: #1e293b;
  border: 1px solid #334155;
  border-radius: 6px;
  color: white;
  min-width: 180px;
}

.create-btn {
  background: #22c55e;
  color: black;
  padding: 10px 16px;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  cursor: pointer;
}

.create-btn:hover {
  background: #16a34a;
}

.add-node {
  background: #3b82f6;
  color: white;
  padding: 10px 14px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  margin-bottom: 16px;
}

.editor-section {
  height: 500px;
  background-color: #1e293b;
  border-radius: 8px;
  padding: 10px;
  border: 1px solid #334155;
}

.flow-editor {
  height: 100%;
}
</style>