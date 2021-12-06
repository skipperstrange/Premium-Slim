export default function({ $axios }, inject) {
    // Create a custom axios instance
    const api = $axios.create({
        headers: {
            'Content-Type': 'application/json',
            common: {
                Accept: 'text/plain, */*'
            }
        }
    })

    // Set baseURL to something different
    api.setBaseURL("https://vanguardassurance.com/quote/")

    // Inject to context as $api
    inject('premiumapi', api)
}