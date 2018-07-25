<template>
  <div class="dropdown" 
    :class="{active:isActive, disabled:isDisabled, loading: isLoading}" 
    @click.self="$emit('clickSelf', $event)">
      {{ title }}
             
    <ul>
      <li v-for="item in items"
          :key="item.slug"
          @click="$emit('pick', $event, item.slug, item.name)"
          :class="{picked: picked == item.slug}">
        {{ item.name }}
      </li>
    </ul>

    <div class="loader" v-if="isLoading">
      <div class="loader-line">
        <div class="line"></div>
      </div>
    </div>
  </div>
</template>

<script type="text/babel">
export default {
  name: 'filterBlock',

  props: [
    'isActive',
    'isDisabled',
    'isLoading',
    'title',
    'items',
    'picked'
  ]
}
</script>