<template>
  <div class="flow-container">
    <vue-flow
      v-model="elements"
      :nodes-draggable="false"
      :nodes-connectable="false"
      :default-edge-options="{ markerEnd: 'arrowclosed' }"
      class="vue-flow-custom"
    >
      <template #node-custom="props">
        <CustomNode :data="props.data" />
      </template>
    </vue-flow>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, nextTick } from 'vue'
import axios from 'axios'
import dagre from 'dagre'
import { VueFlow, useVueFlow } from '@braks/vue-flow'
import CustomNode from './CustomNode.vue'

const { fitView } = useVueFlow() // 👈 Import de fitView

const props = defineProps({
  automationId: {
    type: [String, Number],
    required: true,
  },
})

const elements = ref([])

const typeColors = {
  trigger: '#22c55e',
  condition: '#eab308',
  action: '#3b82f6',
}

// Positionnement automatique avec dagre
const applyLayout = (nodes, edges) => {
  const g = new dagre.graphlib.Graph()
  g.setDefaultEdgeLabel(() => ({}))
  g.setGraph({ rankdir: 'LR', nodesep: 80, ranksep: 100 })

  nodes.forEach((node) => {
    g.setNode(node.id, { width: 200, height: 80 })
  })

  edges.forEach((edge) => {
    g.setEdge(edge.source, edge.target)
  })

  dagre.layout(g)

  return nodes.map((node) => {
    const pos = g.node(node.id)
    return {
      ...node,
      position: { x: pos.x - 100, y: pos.y - 40 },
    }
  })
}

const fetchAutomation = async () => {
  try {
    const res = await axios.get(`/api/automations/${props.automationId}`)
    const { nodes, edges } = res.data

    const nodeIds = nodes.map((n) => n.id.toString())
    const validEdges = edges.filter(
      (edge) =>
        nodeIds.includes(edge.source.toString()) &&
        nodeIds.includes(edge.target.toString())
    )

    const layoutedNodes = applyLayout(
      nodes.map((node) => ({
        id: node.id.toString(),
        type: 'custom',
        data: {
          type: node.type,
          label: node.data.label,
        },
        position: { x: 0, y: 0 },
      })),
      validEdges
    )

    elements.value = [
      ...layoutedNodes,
      ...validEdges.map((edge) => ({
        id: `e-${edge.source}-${edge.target}`,
        source: edge.source.toString(),
        target: edge.target.toString(),
        animated: true,
        type: 'step',
        markerEnd: 'arrowclosed',
        style: {
          stroke:
            typeColors[nodes.find((n) => n.id == edge.source)?.type] || '#888',
          strokeDasharray: '6 4',
          strokeWidth: 2,
        },
      })),
    ]

    // 👇 Attendre que le DOM soit mis à jour, puis centrer
    await nextTick()
    setTimeout(() => fitView({ padding: 0.4 }), 100)

  } catch (err) {
    console.error('Erreur chargement automation:', err)
  }
}

watch(() => props.automationId, fetchAutomation)
onMounted(fetchAutomation)
</script>

<style scoped>
.flow-container {
  height: 700px;
  background-color: #0f172a;
  border-radius: 12px;
  padding: 10px;
}

.vue-flow-custom {
  height: 100%;
  background-image:
    linear-gradient(rgba(255, 255, 255, 0.04) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255, 255, 255, 0.04) 1px, transparent 1px);
  background-size: 20px 20px;
}
</style>
