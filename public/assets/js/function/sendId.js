import {constructList} from './constructList';

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
