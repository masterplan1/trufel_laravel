export function setUser(state, user){
  state.user.data = user
}

export function setToken(state, payload){
  const token = payload?.token ?? payload
  const remember = payload?.remember ?? false
  state.user.token = token
  if(token){
    if(remember){
      localStorage.setItem('TOKEN', token)
      sessionStorage.removeItem('TOKEN')
    } else {
      sessionStorage.setItem('TOKEN', token)
      localStorage.removeItem('TOKEN')
    }
  } else {
    localStorage.removeItem('TOKEN')
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

export function setCategories(state, data){
  state.categories.data = data.data
  state.categories.links = data.meta
}
export function setCategoriesLoading(state, loading){
  state.categories.loading = loading
}

export function setTypes(state, data){
  state.types.data = data.data
  state.types.links = data.meta
}
export function setTypesLoading(state, loading){
  state.types.loading = loading
}

export function setOrders(state, data){
  state.orders.data = data.data
  state.orders.links = data.meta
}
export function setOrdersLoading(state, loading){
  state.orders.loading = loading
}

export function setComments(state, data){
  state.comments.data = data.data
  state.comments.links = data.meta
}
export function setCommentsLoading(state, loading){
  state.comments.loading = loading
}