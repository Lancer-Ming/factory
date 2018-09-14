import Vue from 'vue'
import Vuex from 'vuex'
import {Local} from '../utils/common'
Vue.use(Vuex)



// initial state
const state = {
    activeTabs: new Local().get('activeTabs') || [],
    activeSideBar: new Local().get('activeSideBar') || '',
    recordTabsWithHeader: new Local().get('recordTabsWithHeader') || {},
    tabs: new Local().get('tabs') || [],
    activeNavIndex: new Local().get('activeNavIndex') || 0,
    currentOpenMenuName: new Local().get('currentOpenMenuName') || []
  }
  
  // getters
const getters = {}
  
  // actions
const actions = {}
  
  // mutations
const mutations = {
    setClearAll(state, payload) {
        state.activeTabs = []
        state.activeSideBar = '',
        state.recordTabsWithHeader =  {},
        state.tabs = [],
        state.activeNavIndex = 0,
        state.currentOpenMenuName = []
        new Local().clear()
    },
    setActiveTabs(state, payload) {
        state.activeTabs = payload
        new Local().set('activeTabs', payload)
    },

    setActiveSideBar(state, payload) {
        state.activeSideBar = payload
        new Local().set('activeSideBar', payload)
    },
    
    setRecordTabsWithHeader(state, payload) {
        state.recordTabsWithHeader = payload
        new Local().set('recordTabsWithHeader', payload)
    },

    setTabs(state, payload) {
        state.tabs = payload
        new Local().set('tabs', payload)
    },

    setActiveNavIndex(state, payload) {
        state.activeNavIndex = payload
        new Local().set('activeNavIndex', payload)
    },
    setCurrentOpenMenuName(state, payload) {
        state.currentOpenMenuName = payload
        new Local().set('currentOpenMenuName', payload)     
    }

}




export default new Vuex.Store({
    state,
    getters,
    actions,
    mutations
})