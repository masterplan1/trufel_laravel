export const state = {
  user: {
    token: sessionStorage.getItem('TOKEN'),
    data: {}
  },
  fillings: {
    loading: false,
    data: [],
    links: {}
  }
}