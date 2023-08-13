import axios from 'axios';
import router from "../ts/router";

const authLogin = async (email, password) => {
    await axios
        .get("/sanctum/csrf-cookie")
        .then(() => {
            axios
                .post(`/api/user/login`, {
                    password: password,
                    email: email,
                })
                .then((res) => {
                    console.log(res.data);
                    router.push("/dash_board");
                })
                .catch(() => { });
        })
        .catch(() => { });
};

const authLogout = async () => {
    axios
        .post("/api/user/logout")
        .then((res) => {
            // auth.value = false;
            console.log(res.data.message);
            router.push("/login");

        })
        .catch((err) => {
            console.log(err.response);
        });
};
const authGet = async () => {
const {data}=  await axios
        .get("/api/user/auth")
        // .then((res) => {
        //     if (res.data.result) {
        //         console.log(res.data.user);
        //     }
        // })
        // .catch((err) => {
        //     router.push("/login");

        //     console.log(err.response);
        // });
        return data
};

const authSingUp = async (name, email, password) => {
    await axios.post(`/api/user/sing_up`, {
        name: name,
        email: email,
        password: password,
    });
};

export { authLogin, authLogout, authGet, authSingUp }
