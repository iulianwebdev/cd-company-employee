import { BASE_IMG_PATH, DEFAULT_IMG_THUMBNAIL } from '../store/constants'

const pathMixin = {
  created () {
    this.BASE_PATH = BASE_IMG_PATH
    this.THUMB_PATH = DEFAULT_IMG_THUMBNAIL
  }
}

export default pathMixin
