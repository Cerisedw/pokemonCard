import { constructList, pageChangeDisplay, getIdTarget } from "./mesFonctions2";

export const sendIdPage = (e) => {
    const form = new FormData();
    const maxPage = parseInt(($('.pagination').attr('id')).slice(3));
    const idTarget = getIdTarget(e);
    if(maxPage >= idTarget && idTarget != 0){
        form.append('page', idTarget);
        let url = Routing.generate('getAllByPage');
        axios.post(url, form)
        .then((res) => {
            pageChangeDisplay(idTarget, maxPage);
            constructList(res.data);
        }).catch((error) => console.log(error));
    }
};

export const sendId = (e) => {
    const form = new FormData();
    form.append('typeId', e.target.id);
    let url = Routing.generate('getByTypeId');
    axios.post(url, form)
    .then((res) => {
        constructList(res.data);
        $('.pagination').empty();

    })
    .catch((error) => console.log(error));
};