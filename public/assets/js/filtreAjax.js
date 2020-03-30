
const constructList = (arr) => {
    $('#content').empty();
    arr.forEach((item)=>{
        $('#content').append($(`<img id="${item.id}" src="${item.imageUrl}"/>`));
    });
}
const sendId = (e) => {
    console.log(e.target.id);
    const form = new FormData();
    form.append('typeId', e.target.id);
    axios.post("{{ path ('getByTypeId') }}", form)
    .then((res) => {
        console.log(res.data);
        constructList(res.data);

    })
    .catch((error) => console.log(error));
};


