const modalMixin = {
  data () {
    return {
      modalVisible: false
    }
  },
  methods: {
    showModal () {
      this.modalVisible = true
    },
    closeModal () {
      this.modalVisible = false
    }
  }
}

export default modalMixin
