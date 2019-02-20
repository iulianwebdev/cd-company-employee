const sortMixin = {
  data () {
    return {
      sortData: {
        sort_by: '',
        order: 'asc'
      }
    }
  },
  methods: {
    sort (data) {
      Object.assign(this.sortData, data)
      this.get()
    },
    buildSortParams (args) {
      let { sort_by, order } = this.sortData
      args.push(sort_by, order)
      return args
    }
  }
}

export default sortMixin
