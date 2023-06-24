<template>
    <div v-if="links.length > 3">
        <div>
            <template v-for="(link, k) in links" :key="k">
                <span v-if="link.url === null" v-html="link.label"/>
                <inertia-link v-else :href="link.url" v-html="link.label" style="margin-right: 2px;"/>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: "PaginationComponent",
    props: {
        links: Array
    }
}
</script>
