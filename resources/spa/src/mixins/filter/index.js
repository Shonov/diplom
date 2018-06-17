export default {
    data: () => ({
        currentPage: 1,
        perPage: 5,
        pageOptions: [ 5, 10, 20 ],
        sortBy: null,
        sortDesc: true,
        sortDirection: 'asc',
        filter: null,
    }),
    computed: {
        sortOptions () {
            return this.fields
                .filter(f => f.sortable)
                .map(f => { return { text: f.label, value: f.key } })
        },
    },
    methods: {
        onFiltered(filteredItems) {
            this.totalRows = filteredItems.length;
            this.currentPage = 1
        },
    },

}