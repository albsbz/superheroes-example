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
    },
    getAll() {
        return client.get(`favorite-superheroes`);
    },
    setFavorites(favorites) {
        return client.put(`favorite-superheroes`, { favorites });
    },
    getIndexData({ page, superpower }, callback) {
        const params = { page, superpower };
        client
            .get("/superheroes", { params })
            .then(response => {
                callback(null, response.data);
            })
            .catch(error => {
                // console.log(error);
                callback(error, error.response.data);
            });
    }
};
