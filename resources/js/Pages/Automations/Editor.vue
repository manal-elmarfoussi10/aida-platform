<template>
  <div class="h-screen bg-black text-white p-6">
    <h2 class="text-2xl font-bold mb-4">Automation Logic</h2>

    <!-- Dropdowns -->
    <div class="mb-4 flex gap-4">
      <select class="bg-white text-black px-4 py-2 rounded w-40"></select>
      <select class="bg-white text-black px-4 py-2 rounded w-40"></select>
      <select class="bg-white text-black px-4 py-2 rounded w-40"></select>
      <select class="bg-white text-black px-4 py-2 rounded w-40"></select>
    </div>

    <!-- Zone info -->
    <div class="mb-4 p-4 rounded bg-neutral-900">
      <div class="font-bold">Automation Rules for: Lobby</div>
      <div class="text-sm text-gray-300">Zone Type: public · Area: 5000 sq ft · Capacity: 100 people</div>
    </div>

    <!-- Button -->
    <button @click="addNode" class="bg-green-500 text-white px-4 py-2 rounded mb-4">Create New Automation</button>

    <!-- VueFlow -->
    <VueFlow
      :nodes="nodes"
      :edges="edges"
      :fit-view="true"
      class="h-[60%] bg-neutral-900 rounded"
      :node-types="{ custom: CustomNode }"
    >
      <Controls />
      <Background pattern-color="#333" gap="12" />
    </VueFlow>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { VueFlow, useVueFlow } from '@vue-flow/core'
import { Controls } from '@vue-flow/controls'
import { Background } from '@vue-flow/background'

// ✅ Composant node personnalisé
const CustomNode = {
  props: ['id', 'data'],
  template: `
    <div
      :style="data.style"
      class="p-3 rounded text-white text-sm border border-white font-normal"
      v-html="data.label"
    />
  `
}

const { addNodes, addEdges } = useVueFlow()

const nodes = ref([
  {
    id: '1',
    type: 'custom',
    data: {
      label: `<strong>🔔 Trigger:</strong> Motion detected in Lobby`,
      style: 'background: #14532d; color: #fff;'
    },
    position: { x: 100, y: 200 }
  },
  {
    id: '2',
    type: 'custom',
    data: {
      label: `<strong>💠 Condition:</strong> After 6pm`,
      style: 'background: #a16207; color: #fff;'
    },
    position: { x: 400, y: 200 }
  },
  {
    id: '3',
    type: 'custom',
    data: {
      label: `<strong>💡 Action:</strong> Turn on Lights in Lobby`,
      style: 'background: #1e40af; color: #fff;'
    },
    position: { x: 700, y: 100 }
  },
  {
    id: '4',
    type: 'custom',
    data: {
      label: `<strong>🔒 Action:</strong> Activate Security in Lobby`,
      style: 'background: #b91c1c; color: #fff;'
    },
    position: { x: 700, y: 300 }
  }
])

const edges = ref([
  { id: 'e1-2', source: '1', target: '2', animated: true, style: { stroke: '#facc15', strokeDasharray: '5 5' } },
  { id: 'e2-3', source: '2', target: '3', animated: true, style: { stroke: '#3b82f6', strokeDasharray: '5 5' } },
  { id: 'e2-4', source: '2', target: '4', animated: true, style: { stroke: '#ef4444', strokeDasharray: '5 5' } }
])
</script>
