import {createStore} from 'vuex';
import * as actions from './actions'
import * as mutations from './mutations'
import {state} from './state'

const store = createStore({
  state,
  actions,
  mutations,
  getters: {}
})

export default store