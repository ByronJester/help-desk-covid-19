<template>
    <div class="flex flex-row mb-3 --center" v-if="pagination">
        <svg
            @click="$emit('previous')"
            :class="{
                'wl-text-primary': pagination.hasPrevious,
                'text-gray-400': !pagination.hasPrevious
            }"
            class="w-5 h-5 cursor-pointer mr-3"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 19l-7-7 7-7"
            ></path>
        </svg>

        <div class="text-sm select-none">
            Page <span class="font-bold mx-1"> {{ pagination.page }} </span> of
            <span class="mx-1"> {{ pagination.last_page }} </span>
        </div>
        <svg
            @click="$emit('next')"
            :class="{
                'wl-text-primary': pagination.hasNext,
                'text-gray-400': !pagination.hasNext
            }"
            class="w-5 h-5 cursor-pointer ml-3"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5l7 7-7 7"
            ></path>
        </svg>
    </div>
</template>

<script>
export default {
    props: ["pagination"]
};
</script>

<style lang="scss" scope>
.flex {
    .--center {
        text-align: center;
    }
}
</style>
