<template>
    <div>
        <inertia-link href="#">
            {{ product.name }}
        </inertia-link>
    </div>
</template>

<script>
export default {
    name: "ProductComponent",
    props: {
        product: Object
    }
}
</script>
