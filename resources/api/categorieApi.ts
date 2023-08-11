import axios from 'axios';

const categorieGet = async () => {
    const { data } = await axios.get(`/api/categorie/`);
    return data;
};

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
const destroy = async (id: number) => {
    const { data } = await axios.delete(`/api/categorie/${id}`);
    return data;
};


export { categorieGet, categorieCreate, destroy, categorieUpdate }