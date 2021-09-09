<template>
    <div>
        <svg
            v-if="
                column.sortable &&
                pagination.descending &&
                pagination.sortBy === column.name
            "
            @click="changeSort"
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 ml-2 cursor-pointer"
            fill="currentColor"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                fill-rule="evenodd"
                d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                clip-rule="evenodd"
            ></path>
        </svg>

        <svg
            v-if="
                column.sortable &&
                !pagination.descending &&
                pagination.sortBy === column.name
            "
            @click="changeSort"
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 ml-2 cursor-pointer"
            fill="currentColor"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                clip-rule="evenodd"
            ></path>
        </svg>

        <svg
            v-if="
                column.sortable &&
                pagination.sortBy != column.name
            "
            @click="changeSort"
            xmlns="http://www.w3.org/2000/svg"
            class="h-4 w-4 ml-2 cursor-pointer"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M8 9l4-4 4 4m0 6l-4 4-4-4"
            />
        </svg>
    </div>
</template>

<script>
export default {
    props: ["column", "pagination"],
    methods: {
        changeSort(){
            if( this.column.name === this.pagination.sortBy )
                this.$emit('sort', !this.pagination.descending, this.column.name)
            else
                this.$emit('sort', false, this.column.name)
        }
    }
};
</script>

<style></style>
