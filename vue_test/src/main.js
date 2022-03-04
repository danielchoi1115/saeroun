import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";

const app = createApp(App).use(router)

app.config.errorHandler = (err, vm, info) => {
    // error trace, vue component, vue specefic info(lifecycle hooks, events that caused error)
    // Sentry
    // bugsnag
}

app.config.performance = true

app.mount("#app");
