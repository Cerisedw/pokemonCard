import {constructList} from './constructList';

export const sendId = (e) => {
    const form = new FormData();
    form.append('typeId', e.target.id);
    axios.post("{{ path ('getByTypeId') }}", form)
    .then((res) => {
        constructList(res.data);
        $('.pagination').empty();

    })
    .catch((error) => console.log(error));
};
