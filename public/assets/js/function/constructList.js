export const constructList = (arr) => {
    $('#content').empty();
    arr.forEach((item)=>{
        $('#content').append($(`<img id="${item.id}" src="${item.imageUrl}"/>`));
    });
}