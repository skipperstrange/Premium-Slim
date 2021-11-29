import axios from 'axios'

export const state = () => ({
    customers: [],
    requests: []
})

export const mutations = {
    setCustomers(state, customers) {
        state.customers = customers
    },
    setCurrentCustomer(state, customer) {
        state.request = customer
    },
    setRequests(state, requests) {
        state.requests = requests
    },
    currentRequest(state, request) {
        state.request = request
    },
}

export const actions = {
    async nuxtServerInit({ commit }) {
        await axios.get("http://localhost:8080/api/v1/requests").then((response) => {
            const requests = response.data
            commit("setRequests", requests)
        }).catch(e => console.log(e))

        await axios.get("http://localhost:8080/api/v1/customers").then((response) => {
            const customers = response.data
            commit("setCustomers", customers)
        }).catch(e => console.log(e))
    },


}

export const getters = {

}