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
    },
    delete(id) {
        return client.delete(`superheroes/${id}`);
    },
    create(data) {
        return client.post("superheroes", data);
    },
    createData() {
        return client.get(`superheroes/create-data`);
    }
};
