<template>
  <td
    class="px-6 py-4 align-top text-xs text-center leading-5"
    :class="column.color ? `text-${getColor}` : ''"
  >
    <slot>
      <pre><span v-if="column.name === 'image'"><img width="100" :src="getRowKey" /></span> <span v-else>{{ getRowKey }}</span></pre>
    </slot>
  </td>
</template>

<script>
export default {
  props: ["row", "field", "column"],
  computed: {
    getColor() {
      return typeof this.column.color === "function"
        ? this.column.color(this.row)
        : this.column.color;
    },
    getRowKey() {
      return typeof this.field === "function"
        ? this.field(this.row)
        : this.row[this.field];
    }
  }
};
</script>

<style scoped>
td {
  /* word-break: break-all */
  white-space: normal !important;
}
pre {
  white-space: pre-wrap; /* Since CSS 2.1 */
  white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
  white-space: -pre-wrap; /* Opera 4-6 */
  white-space: -o-pre-wrap; /* Opera 7 */
  word-wrap: break-word; /* Internet Explorer 5.5+ */
}
</style>
