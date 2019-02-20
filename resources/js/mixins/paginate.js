import { PER_PAGE } from '../store/constants'

const paginateMixin = {
  data () {
    return {
      pagerData: {
        current_page: 1,
        per_page: PER_PAGE
      }
    }
  },
  methods: {
    updatePagination (pagerData) {
      Object.keys(pagerData).forEach(el => this.$set(this.pagerData, el, pagerData[el]))
    },
    paginate (data) {
      // console.log(data)
      this.updatePagination(data)
      this.get()
    },
    buildPaginationParams (args) {

      let { current_page, per_page } = this.pagerData

      args.push(per_page, current_page)
      return args
    }
  }
}

export default paginateMixin
