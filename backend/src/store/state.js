export const state = {
  user: {
    token: sessionStorage.getItem('TOKEN'),
    data: {}
  },
  fillings: {
    loading: false,
    data: [],
    links: {}
  },
  products: {
    loading: false,
    data: [],
    links: {}
  },
  categories: {
    loading: false,
    data: [],
    links: {}
  },
  types: {
    loading: false,
    data: [],
    links: {}
  },
  orders: {
    loading: false,
    data: [],
    links: {}
  },
  comments: {
    loading: false,
    data: [],
    links: {}
  },
}