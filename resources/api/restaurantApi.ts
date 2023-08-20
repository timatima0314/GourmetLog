import axios from 'axios';
import { RestaurantData } from '../ts/type/RestaurantType';
const restaurantDataGetAll = async () => {
    const { data } = await axios.get<[RestaurantData]>(`/api/get_all`);
    return data
}
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
    categorieId,
    config
}: RestaurantData) => {
    await axios.post<RestaurantData>(`/api/gourmet`, {
        name,
        name_katakana,
        comment,
        food_picture,
        map_url,
        review,
        tel,
        user_id,
        categorie,
        categorieId
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
}: RestaurantData) => {
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


export { restaurantDataGetAll, restaurantCreate, destroy, restaurantUpdate }