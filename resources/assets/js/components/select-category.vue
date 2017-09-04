<template>
    <select v-model="note.category_id" class="browser-default">
        <option value="" disabled>Elija una opcion</option>
        <option v-for="category in categories" v-bind:value="category.id">{{ category.name }}</option>
    </select>
</template>

<script>
    export default {
        props: ['categories','note'],
    }
</script>