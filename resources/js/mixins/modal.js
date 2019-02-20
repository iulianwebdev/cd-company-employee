const modalMixin = {
  data () {
    return {
      modalVisible: false,
      type: '',
      showLoader: false
    }
  },
  methods: {
    showModal () {
      this.modalVisible = true
    },
    closeModal () {
      this.modalVisible = false
    },
    loading () {
      this.showLoader = true
    },
    stopLoading () {
      this.showLoader = false
    }

  }
}

export default modalMixin
