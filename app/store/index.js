import axios from '@nuxtjs/axios'

export const state = () => ({
    customers: [],
    requests: []
})

export const mutations = {
    setCustomers(state, customers) {
        state.customers = customers
    },
    setRequests(state, requests) {
        state.requests = requests
    },
    setCurrentRequest(state, request) {
        state.request = request
    },
}

export const actions = {
    async commitCustomers({ commit }) {
        const response = await axios.get("/customers")
        const customers = response.data

        commit("setCustomers", customers)
    },
    async commitRequests({ commit }) {
        const response = await axios.get("/requests")
        const requests = response.data

        commit("setRequests", requests)
    }
}