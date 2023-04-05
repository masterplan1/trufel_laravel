export function setUser(state, user){
  state.user.data = user
}

export function setToken(state, token){
  state.user.token = token
  if(token){
    sessionStorage.setItem('TOKEN', token)
  } else {
    sessionStorage.removeItem('TOKEN')
  }
}

export function setFillings(state, data){
  state.fillings.data = data.data
  state.fillings.links = data.meta
}
export function setFillingsLoading(state, loading){
  state.fillings.loading = loading
}

export function setProducts(state, data){
  state.products.data = data.data
  state.products.links = data.meta
}
export function setProductsLoading(state, loading){
  state.products.loading = loading
}