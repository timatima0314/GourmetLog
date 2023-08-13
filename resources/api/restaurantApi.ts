import axios from 'axios';

const restaurantGet = async () => {
    const { data } = await axios.get(`/api/gourmet/`);
    return data;
};

const restaurantCreate = async ({
    name,
    name_katakana,
    comment,
    food_picture,
    map_url,
    review,
    tel,
    user_id,
    categorie,
    config
}) => {
    const { data } = await axios.post(`/api/gourmet`, {
        name,
        name_katakana,
        comment,
        food_picture,
        map_url,
        review,
        tel,
        user_id,
        categorie
    }, config);
    return data;
};
const restaurantUpdate = async ({
    name,
    name_katakana,
    review,
    food_picture,
    map_url,
    comment,
    tel,
    user_id,
    id,
    categorie,
    config
}) => {
    await axios
        .post(`/api/updata/${id}`,
            {
                name,
                name_katakana,
                review,
                food_picture,
                map_url,
                comment,
                tel,
                user_id,
                categorie
            }, config
        )
}
const destroy = async (id: number) => {
    const { data } = await axios.delete(`/api/gourmet/${id}`);
    return data;
};


export { restaurantGet, restaurantCreate, destroy, restaurantUpdate }