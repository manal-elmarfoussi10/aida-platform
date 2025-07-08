<template>
    <div class="h-screen bg-black text-white">
      <h2 class="text-2xl font-bold p-4">Automation Logic</h2>
      <button @click="addNode" class="bg-green-500 text-white px-4 py-2 rounded ml-4 mb-2">Create New Automation</button>
      
      <VueFlow
        :nodes="nodes"
        :edges="edges"
        :fit-view="true"
        class="h-[80%] bg-neutral-900"
      >
        <MiniMap />
        <Controls />
        <Background pattern-color="#444" gap="12" />
      </VueFlow>
    </div>
  </template>
  
  <script setup>
  import { VueFlow, useVueFlow, MiniMap, Controls, Background } from '@vue-flow/core'
  
  const { addNodes, addEdges } = useVueFlow()
  
  const nodes = [
    {
      id: '1',
      type: 'default',
      data: { label: '🔔 Trigger:\nMotion detected in Zone A' },
      position: { x: 100, y: 200 },
      style: { background: '#1f7a1f', color: '#fff', padding: '10px' }
    },
    {
      id: '2',
      data: { label: '⏰ Condition:\nAfter 6pm' },
      position: { x: 400, y: 200 },
      style: { background: '#eab308', color: '#000', padding: '10px' }
    },
    {
      id: '3',
      data: { label: '💡 Action:\nTurn on Lights' },
      position: { x: 700, y: 100 },
      style: { background: '#2563eb', color: '#fff', padding: '10px' }
    },
    {
      id: '4',
      data: { label: '🌿 Action:\nSet HVAC to Eco' },
      position: { x: 700, y: 300 },
      style: { background: '#2563eb', color: '#fff', padding: '10px' }
    },
  ]
  
  const edges = [
    { id: 'e1-2', source: '1', target: '2', animated: true, style: { stroke: '#facc15' } },
    { id: 'e2-3', source: '2', target: '3', animated: true, style: { stroke: '#3b82f6' } },
    { id: 'e2-4', source: '2', target: '4', animated: true, style: { stroke: '#3b82f6' } },
  ]
  </script>
  
  <style scoped>
  .vue-flow {
    border: 1px solid #333;
  }
  </style>