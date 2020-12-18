import axios from "axios";

const client = axios.create({
    baseURL: "/api"
});

export default {
    find(id) {
        return client.get(`superheroes/${id}`);
    },
    update(id, data) {
        return client.put(`superheroes/${id}`, data);
    }
};
