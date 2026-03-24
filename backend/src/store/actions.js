import axiosClient from '../axios'

export function login({commit}, data){
  return axiosClient.post('/login', data)
    .then(({data}) => {
      commit('setUser', data.user)
      commit('setToken', data.token)
      return data;
    })
}

export function logout({commit}){
  return axiosClient.post('/logout')
    .then((response) => {
      commit('setToken', null)
      return response
    })
}

export function getUser({commit}){
  return axiosClient.get('/user')
    .then(({data}) => {
      commit('setUser', data)
      return data;
    })
}

export function getFillings({commit}, {page = null, perPage = null, search = null, type = null, sort_direction = null, sort_field = null}){
  commit('setFillingsLoading', true)
  // const url = url ?? '/filling'
  return axiosClient.get(`/filling`, {
    params: { per_page: perPage, page, search, type, sort_direction, sort_field }
  })
    .then(({data}) => {
      commit('setFillings', data)
      commit('setFillingsLoading', false)
      return data;
    })
}

export function createFilling({commit}, filling){
  if(filling.image instanceof File){
    const form = new FormData();
    for (let key in filling){
      form.append(key, filling[key]);
    }
    filling = form;
  }
  return axiosClient.post('/filling', filling)
}
export function updateFilling({commit}, filling){
  const id = filling.id;
  if(filling.image instanceof File){
    const form = new FormData();
    for (let key in filling){
      form.append(key, filling[key]);
    }
    form.append('_method', 'PUT');
    filling = form;
  } else {
    delete filling.image
    filling._method = 'PUT'
  }
  return axiosClient.post(`/filling/${id}`, filling)
}

export function getFilling({}, id){
  return axiosClient.get(`/filling/${id}`)
}

export function removeFilling({commit}, id){
  return axiosClient.delete(`/filling/${id}`)
}


export function getProducts({commit}, {page = null, perPage = null, search = null, type = null, sort_direction = null, sort_field = null}){
  commit('setProductsLoading', true)
  // const url = url ?? '/filling'
  return axiosClient.get(`/product`, {
    params: { per_page: perPage, page, search, type, sort_direction, sort_field }
  })
    .then(({data}) => {
      commit('setProducts', data)
      commit('setProductsLoading', false)
      return data;
    })
}

export function createProduct({commit}, product){
  if(product.image instanceof File){
    const form = new FormData();
    for (let key in product){
      form.append(key, product[key]);
    }
    product = form;
  }
  return axiosClient.post('/product', product)
}

export function getProduct({}, id){
  return axiosClient.get(`/product/${id}`)
}

export function removeProduct({commit}, id){
  return axiosClient.delete(`/product/${id}`)
}

export function getTypes(){
  return axiosClient.get('/type/all')
}

export function getAllTypes({commit}, {page = null, perPage = null, search = null, sort_direction = null, sort_field = null}){
  commit('setTypesLoading', true)
  return axiosClient.get('/type', {
    params: { per_page: perPage, page, search, sort_direction, sort_field }
  })
    .then(({data}) => {
      commit('setTypes', data)
      commit('setTypesLoading', false)
      return data;
    })
}

export function createType({commit}, type){
  if (type.image instanceof File) {
    const form = new FormData()
    for (let key in type) form.append(key, type[key] ?? '')
    return axiosClient.post('/type', form)
  }
  return axiosClient.post('/type', type)
}

export function updateType({commit}, type){
  const id = type.id
  if (type.image instanceof File) {
    const form = new FormData()
    for (let key in type) form.append(key, type[key] ?? '')
    form.append('_method', 'PUT')
    return axiosClient.post(`/type/${id}`, form)
  }
  type._method = 'PUT'
  return axiosClient.post(`/type/${id}`, type)
}

export function getType({}, id){
  return axiosClient.get(`/type/${id}`)
}

export function removeType({commit}, id){
  return axiosClient.delete(`/type/${id}`)
}

export function getCategories({commit}, {page = null, perPage = null, search = null, type = null, sort_direction = null, sort_field = null}){
  commit('setCategoriesLoading', true)
  return axiosClient.get(`/category`, {
    params: { per_page: perPage, page, search, type, sort_direction, sort_field }
  })
    .then(({data}) => {
      commit('setCategories', data)
      commit('setCategoriesLoading', false)
      return data;
    })
}

export function createCategory({commit}, category){
  return axiosClient.post('/category', category)
}
export function updateCategory({commit}, category){
  const id = category.id;
  delete category.image
  category._method = 'PUT'
  return axiosClient.post(`/category/${id}`, category)
}

export function getCategory({}, id){
  return axiosClient.get(`/category/${id}`)
}

export function removeCategory({commit}, id){
  return axiosClient.delete(`/category/${id}`)
}

export function getDashboard(){
  return axiosClient.get('/dashboard')
}

export function getOrders({commit}, {page = null, perPage = null, status = null, sort_direction = null, sort_field = null}){
  commit('setOrdersLoading', true)
  return axiosClient.get('/order', {
    params: { per_page: perPage, page, status, sort_direction, sort_field }
  }).then(({data}) => {
    commit('setOrders', data)
    commit('setOrdersLoading', false)
    return data
  })
}

export function updateOrderStatus({commit}, {id, status}){
  return axiosClient.put(`/order/${id}`, { status })
}

export function getComments({commit}, {page = null, perPage = null, sort_direction = null}){
  commit('setCommentsLoading', true)
  return axiosClient.get('/comment', {
    params: { per_page: perPage, page, sort_direction }
  }).then(({data}) => {
    commit('setComments', data)
    commit('setCommentsLoading', false)
    return data
  })
}

export function removeComment({commit}, id){
  return axiosClient.delete(`/comment/${id}`)
}

