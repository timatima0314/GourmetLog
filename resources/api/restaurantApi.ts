import axios from 'axios';
import { RestaurantData } from '../ts/type/RestaurantType';

// DB::restaurant全取得
const restaurantDataGetAll = async () => {
    const { data } = await axios.get<[RestaurantData]>(`/api/get_all`);
    return data
}

// DB::restaurant登録
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

// DB::restaurant更新
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

// DB::restaurant削除
const destroy = async (id: number) => {
    const { data } = await axios.delete(`/api/gourmet/${id}`);
    return data;
};


export { restaurantDataGetAll, restaurantCreate, destroy, restaurantUpdate }