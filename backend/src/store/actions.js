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
  return axiosClient.get('/type')
}


