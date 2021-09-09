<template>
  <div class=" flex flex-col items-center">
    <table class="min-w-full select-none border border-collapse">
      <thead class="bg-white">
        <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
          <th
            v-if="hasDelete"
            :class="`px-${hpx} py-${hpy}`"
          >
          </th>
          <th
            :class="`px-${hpx} py-${hpy}`"
            class="text-center text-sm tracking-wider"
            v-for="column in columns"
            :key="column.name"
          >
            <div class="flex items-center justify-center">
              {{ column.label }}
              <sortableIcon
                :column="column"
                :pagination="pagination"
                @sort="sortColumn"
              />

            </div>
          </th>

          <!-- <th :class="`px-${hpx} py-${hpy}`">
          </th> -->
        </tr>
      </thead>
      <tbody class="bg-white">
        <tr
          v-for="(row, index) in tableData"
          :key="index"
          class="hover:bg-gray-100 border border-gray-200 cursor-pointer"
          @click="emitClick(row)"
        >
          <td
            v-if="hasDelete"
            :class="`px-${bpx} py-${bpy} ${disabledClass}`"
            class="px-6 py-4 align-top text-sm leading-5 cursor-pointer"
            @click="emitDelete(index)"
          >
            <svg
              class="w-5 h-5 text-red-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
              >
              </path>
            </svg>
          </td>

          <i-td
            v-for="column in columns"
            :key="`row-${column.name}`"
            :row="row"
            :field="column.field"
            :column="column"
          >
            <slot
              :name="`body-cell-${column.name}`"
              :props="row"
            ></slot>
          </i-td>
          <!-- <td
          v-if="draggable"
          :class="`px-${bpx} py-${bpy} ${disabledClass}`"
          class="align-top text-sm cursor-pointer handle"
          style="word-wrap: break-word;"
        >
          <svg
            v-show="enalbeDrag"
            class="w-4 h-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 10h16M4 14h16M4 18h16"
            >
            </path>
          </svg>
        </td> -->

        </tr>
      </tbody>
    </table>

    <i-pagination
      class="mt-2 --pagination"
      v-if="pagination.total"
      @previous="previous"
      @next="next"
      :pagination="pagination"
    />
  </div>
</template>

<script>
import iTd from "./iTd";
import iPagination from "./Pagination.vue";
// import draggable from 'vuedraggable';
import NProgress from 'nprogress'
import sortableIcon from './sortButton.vue'

export default {
  components: {
    iTd,
    iPagination,
    // draggable,
    sortableIcon
  },
  props: {
    hasDelete: {
      type: Boolean,
      default: false
    },
    // draggable: {
    //   type: Boolean,
    //   default: false
    // },
    data: {
      type: Array,
      default: () => []
    },
    columns: {
      type: Array,
      default: () => []
    },
    hpx: {
      type: String,
      default: "6"
    },
    hpy: {
      type: String,
      default: "3"
    },
    bpx: {
      type: String,
      default: "6"
    },
    bpy: {
      type: String,
      default: "4"
    },
    disabled: {
      type: Boolean,
      default: false
    },
    filters: {
      type: Object,
      default: () => ({})
    },
    dataRoute: {
      type: String,
      default: undefined
    },
    customFilter: {
      type: Boolean,
      default: false
    },
    updateTableOrder: {
      type: Function,
      default: () => ({})
    },
    enalbeDrag: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      dragOptions: {
        animation: 200,
        ghostClass: 'ghost',
      },
      pagination: {
        sortBy: undefined,
        descending: false,
        page: 1,
        per_page: 5,
        last_page: 0,
        total: 0,
        hasPrevious: false,
        hasNext: false,
      },
      loading: false,
      tableDataHolder: []

    };
  },
  mounted() {
    const columns = JSON.stringify(this.columns);
    const sortable = JSON.parse(columns).find(column => column.sortable)
    if (sortable) {
      this.pagination.sortBy = sortable.name;
    } else {
      if (this.dataRoute) this.getData();
    }
  },
  computed: {
    tableData: {
      get: function () {
        if (this.dataRoute)
          return this.tableDataHolder;

        return this.data;
      },
      set: function (newValue) {
        if (this.dataRoute)
          this.tableDataHolder = newValue;
        else
          this.data = newValue;
      }
    },
    disabledClass() {
      if (this.disabled) return "cursor-not-allowed";
    },
    paginationPage() {
      return this.pagination.page;
    },
    sortBy() {
      return this.pagination.sortBy;
    },
    descending() {
      return this.pagination.descending;
    }
  },
  watch: {
    tableDataHolder: {
      handler(value) {
        this.$emit('dataOrder', value);
      }
    },
    customFilter(val) {
      this.getData({ myTaskOnly: val })
    },
    filters: {
      deep: true,
      handler(val) {
        this.getData(val);
      }

    },
    descending: {
      handler() {
        this.getData(this.filters);
      }
    },
    sortBy: {
      handler() {
        this.getData(this.filters);
      }
    },
    paginationPage: {
      handler() {
        this.getData(this.filters);
      }
    }
  },
  methods: {
    sortColumn(descending, name) {
      if (this.loading) return;
      this.pagination.sortBy = name;
      this.pagination.descending = descending;
    },
    refresh() {
      this.getData();
    },
    previous() {
      if (this.pagination.hasPrevious && !this.loading)
        this.pagination.page--;
    },
    next() {
      if (this.pagination.hasNext && !this.loading)
        this.pagination.page++;

    },
    getData(filters = {}) {
      NProgress.start();
      this.loading = true;
      this.pagination.filters = JSON.stringify(this.filters);
      axios
        .get(this.route(this.dataRoute, { ...this.pagination }))
        .then(response => {
          const data = response.data;
          this.tableDataHolder = data.data;
          // this.pagination.page = data.current_page;
          this.pagination.last_page = data.last_page;
          this.pagination.total = data.total;
          this.pagination.hasPrevious = !!data.prev_page_url;
          this.pagination.hasNext = !!data.next_page_url;
          this.$emit("dataTable", data);
        })
        .finally(() => {
          NProgress.done();
          this.loading = false;
        });
    },
    emitClick(row) {
      if (!this.disabled && !this.loading) this.$emit("row-click", row);
    },
    emitDelete(index) {
      if (!this.disabled && !this.loading) this.$emit("delete", index);
    }
  }
};
</script>

<style lang="scss">
// .--table {
table {
  thead {
    border-width: 0 !important;

    tr {
      th {
        /* padding: 20px 20px; */
        letter-spacing: 0;
        font-family: "Roboto", sans-serif;
        font-size: 14px;
        white-space: nowrap;
        /* white-space: pre-wrap; */
      }
    }
  }
}

tbody {
  tr {
    border-left: 15px solid transparent !important;

    // &:hover {
    //   border-left: 15px solid var(--whitelabel-primary) !important;
    //   transition: 0.3s;
    // }

    td {
      padding: 18px 20px !important;
      font-family: "Roboto", sans-serif;
      font-size: 14px;
      white-space: pre-wrap;

      pre {
        font-size: 14px;
        font-family: "Roboto", sans-serif !important;
      }
    }
  }
}
// }

// .--pagination {
//   margin-top: 30px;
// }

// /* SAFARI BROWSER */
// @media not all and (min-resolution: 0.001dpcm) {
//   .--table {
//     thead {
//       tr {
//         th {
//           font-size: 12px !important;
//         }
//       }
//     }

//     tbody {
//       tr {
//         td {
//           pre {
//             font-size: 12px !important;
//           }
//         }
//       }
//     }
//   }
// }
</style>
<style lang="scss" scoped>
// div.--table {
//   overflow-x: scroll;
//   overflow-y: hsidden;
//   width: 100%;

//   table {
//     border-bottom: 1px solid #cdcdcd;
//   }

//   &::-webkit-scrollbar {
//     width: 0px;
//     height: 0px;
//   }

//   &::-webkit-scrollbar-track {
//     box-shadow: inset 0 0 5px transparent;
//     border-radius: 10px;
//   }

//   &::-webkit-scrollbar-thumb {
//     background: transparent;
//     border-radius: 0;
//   }

//   &::-webkit-scrollbar-thumb:hover {
//     background: transparent;
//   }
// }

// @media (max-width: 1024px) {
//   .--npd {
//     padding-left: 0;
//     padding-right: 0;
//   }

//   .--w100 {
//     width: 100%;
//   }

//   .--ml0 {
//     margin-left: 0;
//   }

//   .--mt10 {
//     margin-top: 10px;
//   }

//   .--flex-column {
//     display: flex;
//     justify-content: flex-start;
//     align-items: flex-start;
//     flex-direction: column;
//     width: 100%;
//   }

//   .--tbl-container {
//     margin: 30px 0 0 0;
//     padding: 0 0 0 0;
//     width: 100%;
//   }

//   .--table {
//     align-items: flex-start;
//     overflow-x: scroll;
//     overflow-y: hidden;
//     width: 100%;
//   }

//   .--table::-webkit-scrollbar {
//     width: 0px;
//     height: 0px;
//   }

//   /* Track */
//   .--table::-webkit-scrollbar-track {
//     box-shadow: inset 0 0 5px transparent;
//     border-radius: 10px;
//   }

//   /* Handle */
//   .--table::-webkit-scrollbar-thumb {
//     background: transparent;
//     border-radius: 10px;
//   }

//   /* Handle on hover */
//   .--table::-webkit-scrollbar-thumb:hover {
//     background: transparent;
//   }
// }
</style>