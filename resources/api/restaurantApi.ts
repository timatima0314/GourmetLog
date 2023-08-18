import axios from 'axios';
import { RestaurantData } from '../ts/type/RestaurantType';
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
}:RestaurantData) => {
    await axios.post<RestaurantData>(`/api/gourmet`, {
        name,
        name_katakana,
        comment,
        food_picture,
        map_url,
        review,
        tel,
        user_id,
        categorie
    }, config)

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
}:RestaurantData) => {
    await axios
        .post<RestaurantData>(`/api/updata/${id}`,
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