<template>

    <inertia-link :href="$page.props.currentUrl">
        Reset
    </inertia-link>

    <div>
        <label for="search">Search</label>
        <input type="search" id="search" placeholder="Search in catalog..." v-model="form.query">
    </div>

    <div v-if="brands.length">
        <h3>Brands</h3>

        <div v-for="(brand, index) in brands" :key="index">
            <input
                type="checkbox"
                :value="brand.slug"
                :id="`brand_${brand.slug}`"
                v-model="form.filters.brands"
            >
            <label :for="`brand_${brand.slug}`">{{ brand.name }}</label>
        </div>
    </div>

    <div v-if="Object.keys(attributeValues).length">
        <h3>Attributes</h3>

        <div v-for="(values, attribute, index) in attributeValues" :key="index">
            <b>{{ attribute }}</b>

            <div v-for="(value, index) in values" :key="index">
                <input
                    type="checkbox"
                    :id="`value_${value.id}`"
                    :value="`${value.attribute.id}-${value.id}`"
                    v-model="form.filters.attributes"
                >
                <label :for="`value_${value.id}`">{{ value.value }}</label>
            </div>

        </div>
    </div>
</template>

<script>

import {router} from "@inertiajs/vue3";
import {debounce, pickBy} from "lodash";

export default {
    name: "FiltersComponent",
    props: {
        brands: Object,
        attributeValues: Object
    },
    watch: {
        form: {
            deep: true,
            handler: debounce(function () {
                this.applyFilters();
            }, 400)
        },
    },
    data() {
        return {
            form: {
                query: this.$page.props.query ?? "",
                filters: {
                    brands: this.$page.props.filters.brands ?? [],
                    attributes: this.$page.props.filters.attributes ?? [],
                }
            }
        }
    },
    methods: {
        applyFilters() {
            const url = this.$page.props.currentUrl;

            const data = {
                filters: pickBy(this.form.filters)
            };

            if (this.form.query !== '') {
                data['query'] = this.form.query;
            }

            const options = {
                preserveScroll: true,
                preserveState: true
            };

            router.get(url, data, options);
        }
    }
}
</script>
