<template>
  <div :style="customStyle" class="node-box">
    <Handle type="target" position="top" class="handle" />
    <div class="node-header">
      <span class="icon">{{ icon }}</span>
      <span class="title">{{ title }}:</span>
    </div>
    <div class="node-label">{{ label }}</div>
    <Handle type="source" position="bottom" class="handle" />
  </div>
</template>

<script setup>
import { Handle } from '@braks/vue-flow'

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
})

const typeIcons = {
  trigger: '🔔',
  condition: '🧠',
  action: '💡',
}

const typeColors = {
  trigger: '#22c55e',   // green
  condition: '#eab308', // yellow
  action: '#3b82f6',    // blue
}

const typeDark = {
  trigger: '#14532d',
  condition: '#78350f',
  action: '#1e3a8a',
}

const icon = typeIcons[props.data.type] || '🔧'
const title = props.data.type?.charAt(0).toUpperCase() + props.data.type?.slice(1)
const label = props.data.label || ''

const customStyle = {
  backgroundColor: typeDark[props.data.type] || '#1e1e1e',
  border: `2px solid ${typeColors[props.data.type] || '#ccc'}`,
  color: 'white',
  borderRadius: '12px',
  padding: '12px',
  minWidth: '220px',
  textAlign: 'left',
  boxShadow: '0 4px 12px rgba(0, 0, 0, 0.4)',
  fontFamily: 'Inter, sans-serif',
}
</script>

<style scoped>
.node-box {
  position: relative;
}
.node-header {
  font-weight: bold;
  display: flex;
  align-items: center;
  margin-bottom: 6px;
}
.icon {
  margin-right: 6px;
}
.title {
  font-size: 1rem;
}
.node-label {
  font-size: 0.95rem;
  line-height: 1.2;
}
.handle {
  width: 10px;
  height: 10px;
  background: #fff;
  border: 1px solid #999;
  border-radius: 50%;
}
</style>
