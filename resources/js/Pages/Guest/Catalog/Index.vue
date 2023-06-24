<template>
    <h1>Catalog</h1>

    <div style="display: flex; align-content: center;">

        <div>
            <FiltersComponent
                :brands="brands"
                :attribute-values="attributeValues"
            />
        </div>

        <div v-if="products.data.length">
            <ProductComponent
                v-for="(product, index) in products.data"
                :key="index"
                :product="product"
            />

            <PaginationComponent
                :links="products.meta?.links"
            />

        </div>
    </div>
</template>

<script>

import ProductComponent from "../../../Components/ProductComponent.vue";
import FiltersComponent from "../../../Components/FiltersComponent.vue";
import PaginationComponent from "../../../Components/PaginationComponent.vue";

export default {
    name: "Index",
    components: {
        ProductComponent,
        FiltersComponent,
        PaginationComponent
    },
    props: {
        products: Object,
        brands: Object,
        categories: Object,
        attributeValues: Object
    }

}
</script>
