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


export const getters = {
    isAuthenticated(state) {
        return state.auth.loggedIn
    },

    loggedInUser(state) {
        return state.auth.user
    },

    loggedIn(state) {
        return state.auth.loggedIn
    }
}