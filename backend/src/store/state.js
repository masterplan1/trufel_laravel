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
}