import axios from 'axios';
import { Categorie } from '../ts/type/RestaurantType';

// DB::カテゴリー取得
const categorieGet = async () => {
    const { data } = await axios.get<[Categorie]>(`/api/categorie/`);
    return data;
};

// DB::カテゴリー新規登録
const categorieCreate = async ({
    name,
    user_id,
}) => {
    const { data } = await axios.post(`/api/categorie`, {
        name,
        user_id,
    });
    return data;
};

// DB::カテゴリー更新
const categorieUpdate = async ({
    name,
    id
}) => {
    await axios
        .patch(`/api/categorie/${id}`,
            {
                name,
            }
        )
}

// DB::カテゴリー削除
const destroy = async (id: number) => {
    const { data } = await axios.delete(`/api/categorie/${id}`);
    return data;
};


export { categorieGet, categorieCreate, destroy, categorieUpdate }